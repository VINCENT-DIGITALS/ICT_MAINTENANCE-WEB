<x-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Replace the toast notification with a centered modal alert -->
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#007A33',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <div class="flex flex-col xl:flex-row md:flex-row sm:flex-col justify-between pb-1">
        <div>
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title mb-3 md:mb-0">Dashboard</h2>
        </div>
        <div class="flex flex-wrap items-center gap-2 bg-[#F5F7FA] rounded-lg p-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-gray-500 text-xs font-medium">FROM</span>
                <input type="text" id="from-date" placeholder="Select date" value="{{ request('from_date') }}"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500 flatpickr-input">
                <span class="text-gray-500 text-xs font-medium">TO</span>
                <input type="text" id="to-date" placeholder="Select date" value="{{ request('to_date') }}"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500 flatpickr-input">
            </div>
            <select name="station_id" id="station-select"
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                <option value="">PHILRICE CES</option>
                @foreach ($stations as $station)
                    <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>
                        {{ $station->station_abbr }}
                    </option>
                @endforeach
            </select>
            @if (Auth::check() &&
                    Auth::user()->role_id == DB::table('lib_roles')->where('role_name', 'Super Administrator')->value('id'))
                <select id="technician-select"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    <option value="">ALL TECHNICIANS</option>
                    @foreach ($technicians as $technician)
                        <option value="{{ $technician->philrice_id }}"
                            {{ request('technician_id') == $technician->philrice_id ? 'selected' : '' }}>
                            {{ $technician->name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>

    {{-- CARDS FOR PENDING, PICKED, ONGOING, AND COMPLETED --}}
    <div class="">
        @php
            $pendingCount = $pendingRequestsCount;
            $pickedCount = $pickedRequestsCount;
            $ongoingCount = $ongoingRequestsCount;
            $completedCount = $completedRequestsCount;

            $others = $deniedRequestsCount + $cancelledRequestsCount;
            $evaluatedCount = $evaluatedRequestsCount;
            $pausedOngoingRequestsCount = $pausedOngoingRequestsCount;
            $totalRequests = $pendingCount + $pickedCount + $ongoingCount + $completedCount + $others + $evaluatedCount + $pausedOngoingRequestsCount;
            // Avoid division by zero
            $completedPercentage = $totalRequests > 0 ? ($completedCount / $totalRequests) * 100 : 0;
            $ongoingPercentage = $totalRequests > 0 ? ($ongoingCount / $totalRequests) * 100 : 0;
            $pickedPercentage = $totalRequests > 0 ? ($pickedCount / $totalRequests) * 100 : 0;
            $pendingPercentage = $totalRequests > 0 ? ($pendingCount / $totalRequests) * 100 : 0;
        @endphp

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 lg:gap-3 mt-1 p-2 lg:p-3 bg-gray-200 rounded-lg">
            @foreach (['pending' => ['label' => 'Pending Requests', 'count' => $pendingCount], 'picked' => ['label' => 'Picked Requests', 'count' => $pickedCount], 'ongoing' => ['label' => 'Ongoing Services', 'count' => $ongoingCount], 'completed' => ['label' => 'Completed Services', 'count' => $completedCount]] as $status => $data)
                <div class="cursor-pointer" onclick="setActiveTable('{{ $status }}')">
                    <div data-status="{{ $status }}"
                        class="card flex items-center bg-white shadow-md rounded-lg w-full h-[80px] transition-transform duration-200 border-2 border-transparent hover:border-green-500">
                        <div id="icon-{{ $status }}"
                            class="icon-box bg-[#101C35] w-[50px] lg:w-[80px] h-[82px] flex items-center justify-center rounded-lg transition-colors duration-300
                            {{ $status === 'pending' ? 'bg-[#007A33]' : 'bg-[#14213D]' }}">
                            @if ($status == 'pending')
                                <img src="{{ url('public/svg/pending.svg') }}" alt="Custom SVG"
                                    class="size-8 lg:size-10 filter invert">
                            @elseif($status == 'picked')
                                <img src="{{ url('public/svg/picked.svg') }}" alt="Custom SVG"
                                    class="size-8 lg:size-10 filter invert">
                            @elseif($status == 'ongoing')
                                <img src="{{ url('public/svg/ongoing.svg') }}" alt="Custom SVG"
                                    class="size-8 lg:size-10 filter invert">
                            @else
                                <img src="{{ url('public/svg/completed.svg') }}" alt="Custom SVG"
                                    class="size-8 lg:size-10 filter invert">
                            @endif
                        </div>

                        <div class="ml-2 lg:ml-3 flex-grow overflow-hidden">
                            <p class="text-green-600 xl:text-lg lg:text-xs font-medium">{{ $data['label'] }}</p>
                            <div class="flex items-center space-x-1">
                                <p class="xl:text-[2rem] lg:text-[19px] font-bold">{{ $data['count'] }}</p>
                                @if ($status == 'ongoing')
                                    <div class="flex items-end">
                                        <p class="text-[10px] text-gray-500">{{ $pausedOngoingRequestsCount }} paused
                                        </p>
                                    </div>
                                @elseif($status == 'completed')
                                    <div class="flex flex-col text-gray-500 text-[10px]">
                                        <p>{{ $others }} Others</p>
                                        <p>{{ $evaluatedCount }} Evaluated</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <a href="{{ url('/' . $status) }}" class="text-black-600 pr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4"
                                stroke="green" class="w-5 h-5 hover:text-[#0F8C3F] transition-colors duration-300">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col lg:flex-row gap-2 lg:mt-2 xl:h-[45rem]">
            <div class="w-full xl:w-[55%] lg:w-[58%]">
                <div id="table-pending" style="display: none;"
                    class="bg-white shadow-md rounded-lg p-2 lg:p-3 w-full mt-1 flex flex-col xl:h-[680px] lg:h-[480px] md:h-[370px]">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-1 sm:mb-0">
                        <div>
                            <h1 class="font-bold font-roboto text-[18px] md:text-[20px] leading-[30px] text-green-600">
                                Pending Request
                            </h1>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <div class="text-right">
                                <p class="text-[#B0B0B0] text-[9px] lg:text-[10px]">January 1, 2025 to February 28, 2025
                                </p>
                                <p class="text-[#B0B0B0] text-[9px] lg:text-[10px]">PhilRice CES</p>
                            </div>
                            <img src="https://via.placeholder.com/40" alt="Profile"
                                class="size-5 lg:size-6 rounded-full border border-gray-300">
                            <a href="{{ url('/pending') }}" class="text-black-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="4" stroke="green"
                                    class="w-5 h-5 lg:size-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="w-full h-full flex flex-col">
                        <div class="w-full flex-grow overflow-hidden" id="pending-table-container">
                            <div class="overflow-auto max-h-[300px] md:max-h-[395px] xl:max-h-[600px]">
                                <table class="w-full mt-2 text-xs text-center table-fixed">
                                    <thead class="border-b border-t border-gray-400 top-0 font-medium">
                                        <tr class="text-left font-roboto-text">
                                            <th class="py-2 pl-2 w-[15%] md:w-[15%]">No.</th>
                                            <th class="py-2 w-[20%] md:w-[18%]">Service Category</th>
                                            <th class="py-2 w-[20%]">Date</th>
                                            <th class="py-2 w-[25%]">Subject</th>
                                            <th class="py-2 w-[15%]">Division</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pending-table-body" class="font-roboto-text">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- ENTRIES AND PAGINATION --}}
                    <div class="flex items-center justify-between p-2 text-xs text-gray-500">
                        <!-- ✅ Entries Count -->
                        <span class="w-64" id="pending-entries-count"></span>

                        <!-- ✅ Pagination -->
                        <div class="flex justify-end items-center">
                            <!-- Previous Button (Hidden on First Page) -->
                            <button onclick="changePage('pending', currentPage - 1)"
                                class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="pending-prev-btn">
                                ❮
                            </button>

                            <!-- Page Numbers -->
                            <div id="pending-page-numbers" class="flex"></div>

                            <!-- Next Button (Hidden on Last Page) -->
                            <button onclick="changePage('pending', currentPage + 1)"
                                class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="pending-next-btn">
                                ❯
                            </button>
                        </div>
                    </div>
                </div>

                <div id="table-picked" style="display: none;"
                    class="bg-white shadow-md rounded-lg p-2 lg:p-3 w-full xl:h-[680px] lg:h-[480px] md:h-[370px] mt-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-0">
                        <div>
                            <h1 class="font-bold font-roboto text-[18px] md:text-[20px] leading-[30px] text-green-600">
                                Picked Request
                            </h1>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <div class="text-right">
                                <p class="text-[#B0B0B0] text-[10px]">January 1, 2025 to February 28, 2025</p>
                                <p class="text-[#B0B0B0] text-[10px]">PhilRice CES</p>
                            </div>
                            <img src="https://via.placeholder.com/40" alt="Profile"
                                class="size-6 rounded-full border border-gray-300">
                            <a href="{{ url('/pending') }}" class="text-black-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="4" stroke="green"
                                    class="size-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-full h-full flex flex-col">
                        <div class="w-full flex-grow overflow-hidden" id="picked-table-container">
                            <div class="overflow-auto max-h-[300px] md:max-h-[395px] xl:max-h-[600px]">
                                <table class="w-full mt-2 text-xs text-center table-fixed">
                                    <thead class="border-b border-t border-gray-400 top-0 font-medium">
                                        <tr class="text-left font-roboto-text">
                                            <th class="py-2 pl-2 w-[15%] md:w-[15%]">No.
                                            </th>
                                            <th class="py-2 w-[20%] md:w-[16%]">Service Category

                                            </th>
                                            <th class="py-2 w-[15%] md:w-[20%]">Subject

                                            </th>
                                            <th class="py-2 w-[25%] md:w-[20%]">Date Requested

                                            </th>
                                            <th class="py-2 w-[15%]">Technician/s

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="picked-table-body" class="font-roboto-text">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- ENTRIES AND PAGINATION --}}
                    <div class="flex items-center justify-between p-2 text-xs text-gray-500">
                        <!-- ✅ Entries Count -->
                        <span class="w-64" id="picked-entries-count"></span>

                        <!-- ✅ Pagination -->
                        <div class="flex justify-end items-center">
                            <!-- Previous Button (Hidden on First Page) -->
                            <button onclick="changePage('picked', currentPage - 1)"
                                class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="picked-prev-btn">
                                ❮
                            </button>

                            <!-- Page Numbers -->
                            <div id="picked-page-numbers" class="flex"></div>

                            <!-- Next Button (Hidden on Last Page) -->
                            <button onclick="changePage('picked', currentPage + 1)"
                                class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="picked-next-btn">
                                ❯
                            </button>
                        </div>
                    </div>
                </div>

                <div id="table-ongoing" style="display: none;"
                    class="bg-white shadow-md rounded-lg p-2 lg:p-3 w-full xl:h-[680px] lg:h-[480px] md:h-[370px] mt-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-0">
                        <div>
                            <h1 class="font-bold font-roboto text-[18px] md:text-[20px] leading-[30px] text-green-600">
                                Ongoing Services
                            </h1>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <div class="text-right">
                                <p class="text-[#B0B0B0] text-[10px]">January 1, 2025 to February 28, 2025</p>
                                <p class="text-[#B0B0B0] text-[10px]">PhilRice CES</p>
                            </div>
                            <img src="https://via.placeholder.com/40" alt="Profile"
                                class="size-6 rounded-full border border-gray-300">
                            <a href="{{ url('/pending') }}" class="text-black-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="green" stroke-width="4"
                                    class="size-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-full h-full flex flex-col">
                        <div class="w-full flex-grow overflow-hidden" id="ongoing-table-container">
                            <div class="overflow-auto max-h-[300px] md:max-h-[395px] xl:max-h-[600px]">
                                <table class="w-full mt-2 text-xs text-center table-fixed">
                                    <thead class="border-b border-t border-gray-400 top-0 font-medium">
                                        <tr class="text-left font-roboto-text ">
                                            <th class="py-2 pl-2 w-[15%] md:w-[15%]">No.

                                            </th>
                                            <th class="py-2 w-[20%] md:w-[16%]">Service Category

                                            </th>
                                            <th class="py-2 w-[35%] md:w-[20%]">Subject

                                            </th>
                                            <th class="py-2 w-[25%] md:w-[20%]">Date Requested

                                            </th>
                                            <th class="py-2 w-[15%]">Technician/s

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="ongoing-table-body" class="font-roboto-text">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- ENTRIES AND PAGINATION --}}
                    <div class="flex items-center justify-between p-2 text-xs text-gray-500">
                        <!-- ✅ Entries Count -->
                        <span class="w-64" id="ongoing-entries-count"></span>

                        <!-- ✅ Pagination -->
                        <div class="flex justify-end items-center">
                            <!-- Previous Button (Hidden on First Page) -->
                            <button onclick="changePage('ongoing', currentPage - 1)"
                                class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="ongoing-prev-btn">
                                ❮
                            </button>

                            <!-- Page Numbers -->
                            <div id="ongoing-page-numbers" class="flex"></div>

                            <!-- Next Button (Hidden on Last Page) -->
                            <button onclick="changePage('ongoing', currentPage + 1)"
                                class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="ongoing-next-btn">
                                ❯
                            </button>
                        </div>
                    </div>
                </div>

                <div id="table-completed" style="display: none;"
                    class="bg-white shadow-md rounded-lg p-2 lg:p-3 w-full xl:h-[680px] lg:h-[480px] md:h-[370px] mt-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-0">
                        <div>
                            <h1 class="font-bold font-roboto text-[18px] md:text-[20px] leading-[30px] text-green-600">
                                Completed Services
                            </h1>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <div class="text-right">
                                <p class="text-[#B0B0B0] text-[10px]">January 1, 2025 to February 28, 2025</p>
                                <p class="text-[#B0B0B0] text-[10px]">PhilRice CES</p>
                            </div>
                            <img src="https://via.placeholder.com/40" alt="Profile"
                                class="size-6 rounded-full border border-gray-300">
                            <a href="{{ url('/pending') }}" class="text-black-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="4" stroke="green"
                                    class="size-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-full h-full flex flex-col">
                        <div class="w-full flex-grow overflow-hidden" id="completed-table-container">
                            <div class="overflow-auto max-h-[300px] md:max-h-[395px] xl:max-h-[600px]">
                                <table class="w-full mt-2 text-xs text-center table-fixed">
                                    <thead class="border-b border-t border-gray-400 top-0 font-medium">
                                        <tr class="text-left font-roboto-text ">
                                            <th class="py-2 pl-2 w-[15%] md:w-[15%]">No.

                                            </th>
                                            <th class="py-2 w-[20%] md:w-[16%]">Service Category

                                            </th>
                                            <th class="py-2 w-[35%] md:w-[20%]">Subject

                                            </th>
                                            <th class="py-2 w-[25%] md:w-[20%]">Date Completed

                                            </th>
                                            <th class="py-2 w-[15%] ">Technician/s

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="completed-table-body" class="font-roboto-text">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- ENTRIES AND PAGINATION --}}
                    <div class="flex items-center justify-between p-2 text-xs text-gray-500">
                        <!-- ✅ Entries Count -->
                        <span class="w-64" id="completed-entries-count"></span>

                        <!-- ✅ Pagination -->
                        <div class="flex justify-end items-center">
                            <!-- Previous Button (Hidden on First Page) -->
                            <button onclick="changePage('completed', currentPage - 1)"
                                class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="completed-prev-btn">
                                ❮
                            </button>

                            <!-- Page Numbers -->
                            <div id="completed-page-numbers" class="flex"></div>

                            <!-- Next Button (Hidden on Last Page) -->
                            <button onclick="changePage('completed', currentPage + 1)"
                                class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition"
                                style="display: none;" id="completed-next-btn">
                                ❯
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[42%] xl:w-[45%] flex flex-col">
                <div class="bg-white shadow-md rounded-lg p-2 w-full mt-1 overflow-hidden lg:h-[385px] xl:h-[570px]">
                    <div class="flex justify-between items-center pb-1">
                        <h2 class="text-green-600 text-sm lg:text-lg font-bold">Analytics</h2>
                        <p class="text-[9px] lg:text-xs text-gray-500 hidden sm:block">January 1, 2025 to February 28,
                            2025</p>
                        <a href="{{ route('analytics') }}" class="text-green-600 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="4" stroke="green" class="w-5 h-5 lg:w-6 lg:h-6">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div
                        class="bg-white py-2 flex flex-col md:flex-row md:justify-center xl:items-center xl:h-[33rem] xl:space-x-7 md:space-y-0 md:space-x-10 lg:space-x-2 mt-4">
                        <div class="flex flex-col items-center">
                            <div class="md:w-[16rem] lg:w-[13rem] xl:w-[25rem] flex justify-center"
                                style="max-height: 330px;">
                                <canvas id="summaryChart"></canvas>
                            </div>
                            <div
                                class="flex justify-between flex-row items-center text-sm xl:text-lg lg:text-xs md:text-sm sm:text-sm xl:space-x-5 space-x-2 lg:space-x-2 md:space-x-3 mt-1">
                                <div class="text-[#3B4E57] font-bold">{{ round($completedPercentage, 1) }}% <br>
                                    Completed
                                </div>
                                <div class="text-[#914D3A] font-bold">{{ round($ongoingPercentage, 1) }}% <br>
                                    Ongoing
                                </div>
                                <div class="text-[#F4B861] font-bold">{{ round($pickedPercentage, 1) }}% <br>
                                    Picked
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block w-px bg-gray-300"></div>
                        <hr class="md:hidden  border-gray-300" />
                        <div class="w-full md:w-auto overflow-hidden">
                            <h3 class="xl:text-2xl lg:text-base font-bold">Total Requests</h3>
                            <p class="xl:text-4xl lg:text-2xl font-bold mt-1">{{ $totalRequests }}</p>
                            <ul class="mt-1 lg:mt-2 text-[9px] xl:text-sm lg:text-xs grid grid-cols-2 md:block gap-0.5">
                                @foreach ($totalServiceRequests as $request)
                                    <li class="flex justify-between py-0.5">
                                        <span class="truncate pr-1">{{ $request->category_name }}</span>
                                        <span>{{ $request->request_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="modal-container">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
                        <a href="{{ route('customer_feed') }}"
                            class="flex items-center justify-between drop-shadow-lg w-full xl:h-[100px] lg:h-[85px] md:h-[70px] bg-[#45CF7F] text-white font-bold py-2 pl-2 rounded-lg hover:bg-green-500">
                            <div class="flex items-center space-x-4 h-full">
                                <img src="{{ url('public/svg/feedback.svg') }}" alt="Customer Feedback"
                                    class="size-7 lg:size-8 xl:size-10 svg-green2">
                                <span class="text-[#004D1E] text-[10px] xl:text-lg lg:text-[10px]">Customer
                                    Feedback</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="green" class="size-7 lg:size-8 xl:size-10">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="3"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('incident_reports') }}"
                            class="flex items-center justify-between bg-[#45CF7F] xl:h-[100px] lg:h-[85px] text-white drop-shadow-lg font-bold py-2 pl-2 rounded-lg hover:bg-green-500">
                            <div class="flex items-center space-x-4 h-full">
                                <img src="{{ url('public/svg/incidentReport.svg') }}" alt="Incident Reports"
                                    class="w-6 h-6 lg:w-7 lg:h-7 xl:size-10 svg-green2">
                                <span class="text-[#004D1E] text-[10px] xl:text-lg lg:text-[10px]">Incident
                                    Reports</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="green" class="size-7 lg:size-8 xl:size-10">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="3"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="#" onclick="checkRequestLimitAndShowModal(event)"
                            class="flex items-center justify-between bg-[#007A33] xl:h-[100px] lg:h-[85px] text-white drop-shadow-lg font-bold py-2 pl-2 rounded-lg hover:bg-green-700">
                            <div class="flex items-center space-x-4 h-full">
                                <img src="{{ url('public/svg/newRequest.svg') }}" alt="Add New Request"
                                    class="w-6 h-6 lg:w-7 lg:h-7 xl:size-10 filter-white">
                                <span class="text-white text-[10px] xl:text-lg lg:text-[10px]">Add New Request</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="white" class="size-7 lg:size-8 xl:size-10">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="3"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <div id="dashboardModal" style="display: none;"
                            class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-70 flex justify-center items-center z-[9999] p-4">
                            <div
                                class="bg-white w-[700px] max-w-[1000px] pt-4 px-4 rounded-lg shadow-lg overflow-scroll">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h2 class="font-bold text-lg font-roboto-modal">Add New Request</h2>
                                    <button onclick="hideDashboardModal()"
                                        class="text-gray-500 hover:text-gray-700 text-xl">✕</button>
                                </div>
                                <form method="POST" action="{{ route('dashboard.new-request') }}">
                                    @csrf
                                    <div class="mt-4 space-y-2">
                                        <label class="block text-xs font-medium text-[#707070]">Service
                                            Category</label>
                                        <select name="category" id="category"
                                            class="w-full border border-gray-300 text-xs rounded-lg p-2">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $id => $category)
                                                <option value="{{ $id }}">{{ $category }}</option>
                                            @endforeach
                                        </select>

                                        <label class="block text-xs font-medium text-[#707070]">Subcategory</label>
                                        <select name="subcategory" id="subcategory"
                                            class="w-full border border-gray-300 text-xs rounded-lg p-2">
                                            <option value="">Select a subcategory</option>
                                        </select>


                                        <label class="block text-xs font-medium text-[#707070]">Subject</label>
                                        <input type="text" name="subject"
                                            class="w-full border border-gray-300 text-xs rounded-lg p-2"
                                            placeholder="Enter subject...">
                                        <label class="block text-xs font-medium text-[#707070]">Description</label>
                                        <textarea name="description" class="w-full border border-gray-300 text-xs rounded-lg p-2" rows="3"
                                            placeholder="Enter description..."></textarea>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-[#707070] pb-1">Location</label>
                                                <select name="location"
                                                    class="w-full border border-gray-300 text-xs rounded-lg p-2">
                                                    <option>ISD</option>
                                                    <option>TMSD</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-[#707070] pb-1">Requested
                                                    Date of Completion</label>
                                                <input type="date" name="requested_date"
                                                    class="w-full border border-gray-300 text-xs rounded-lg p-2">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-[#707070] pb-1">Telephone
                                                    No.</label>
                                                <input type="text" name="telephone"
                                                    class="w-full border border-gray-300 text-xs rounded-lg p-2"
                                                    placeholder="Enter telephone number...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-[#707070] pb-1">Cellphone
                                                    No.</label>
                                                <input type="text" name="cellphone"
                                                    class="w-full border border-gray-300 text-xs rounded-lg p-2"
                                                    placeholder="Enter cellphone number...">
                                            </div>
                                        </div>
                                        <label class="block text-xs font-medium text-[#707070]">Actual
                                            Client</label>
                                        <input type="text" name="client"
                                            class="w-full border border-gray-300 text-xs rounded-lg p-2"
                                            placeholder="Enter client name...">
                                    </div>
                                    <div class="mt-10 flex justify-center w-full space-x-3">
                                        <button type="submit"
                                            class="bg-[#007A33] text-white px-4 py-2 rounded-lg w-full text-xs font-medium">ADD
                                            NEW REQUEST</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let perPage = getPerPageCount(); // Replace static value with function
        let activeTable = 'pending';
        let tableData = {
            pending: [],
            picked: [],
            ongoing: [],
            completed: []
        };
        let details = null;

        $('#category').on('change', function() {
            var categoryId = $(this).val();
            $('#subcategory').empty().append('<option value="">Loading...</option>');

            if (categoryId) {
                $.ajax({
                    url: '/ServiceTrackerGithub/dashboard/subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory').empty().append(
                            '<option value="">Select a subcategory</option>');
                        $.each(data, function(id, name) {
                            $('#subcategory').append('<option value="' + id + '">' + name +
                                '</option>');
                        });
                    },
                    error: function() {
                        $('#subcategory').empty().append(
                            '<option value="">Error loading subcategories</option>');
                    }
                });
            } else {
                $('#subcategory').empty().append('<option value="">Select a subcategory</option>');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const fromDate = document.getElementById('from-date');
            const toDate = document.getElementById('to-date');

            const today = new Date().toISOString().split('T')[0];

            // Set max defaults
            fromDate.max = today;
            toDate.max = today;

            function updateFromDateLimits() {
                if (toDate.value) {
                    fromDate.max = toDate.value;
                    fromDate.min = null; // You can set a custom lower bound if needed
                    if (fromDate.value > toDate.value) {
                        fromDate.value = toDate.value;
                    }
                } else {
                    fromDate.max = today;
                    fromDate.removeAttribute('min');
                }
            }

            function updateToDateLimits() {
                toDate.max = today;
                if (fromDate.value) {
                    toDate.min = fromDate.value;
                    if (toDate.value < fromDate.value) {
                        toDate.value = fromDate.value;
                    }
                } else {
                    toDate.removeAttribute('min');
                }
            }

            toDate.addEventListener('change', () => {
                updateFromDateLimits();
            });

            fromDate.addEventListener('change', () => {
                updateToDateLimits();
            });

            // Initial setup on page load
            updateFromDateLimits();
            updateToDateLimits();


        });

        function updateFilters() {
            const fromDate = document.getElementById('from-date').value;
            const toDate = document.getElementById('to-date').value;
            const technicianId = document.getElementById('technician-select')?.value;
            const stationId = document.getElementById('station-select')?.value;

            const query = new URLSearchParams();

            if (fromDate) query.append('from_date', fromDate);
            if (toDate) query.append('to_date', toDate);
            if (technicianId) query.append('technician_id', technicianId);
            if (stationId) query.append('station_id', stationId);

            // This reloads the page with the updated query parameters
            window.location.href = `{{ route('dashboard') }}?${query.toString()}`;
        }


        // Adding event listeners for the filter inputs
        document.getElementById('from-date').addEventListener('change', updateFilters);
        document.getElementById('to-date').addEventListener('change', updateFilters);
        document.getElementById('technician-select')?.addEventListener('change', updateFilters);
        document.getElementById('station-select')?.addEventListener('change', updateFilters);


        document.addEventListener("DOMContentLoaded", function() {
            loadSampleData();
            initializeChart();

            // Set initial active table
            setTimeout(function() {
                setActiveTable('pending');
            }, 100);
        });

        function setActiveTable(status) {
            console.log("Setting active table to:", status); // Debug line

            // Hide all tables
            document.querySelectorAll('[id^="table-"]').forEach(table => {
                table.style.display = 'none';
            });

            // Show the selected table
            document.getElementById(`table-${status}`).style.display = 'flex';

            // Reset all icon backgrounds to default color
            document.querySelectorAll('.icon-box').forEach(icon => {
                console.log("Resetting icon:", icon.id); // Debug line
                icon.style.backgroundColor = '#14213D';
                // Remove classes as an alternative approach
                icon.classList.remove('bg-[#007A33]');
                icon.classList.add('bg-[#14213D]');
            });

            // Set active icon background to green
            const activeIcon = document.getElementById(`icon-${status}`);
            if (activeIcon) {
                console.log("Setting active icon:", activeIcon.id); // Debug line
                activeIcon.style.backgroundColor = '#007A33';
                // Add/remove classes as an alternative approach
                activeIcon.classList.remove('bg-[#14213D]');
                activeIcon.classList.add('bg-[#007A33]');
            } else {
                console.error(`Icon with id 'icon-${status}' not found`); // Debug line
            }

            activeTable = status;
            renderTableData(status);
        }

        function loadSampleData() {
            // Make sure data is loaded into tableData
            tableData = {
                pending: @json($pendingRequests),
                picked: @json($pickedRequests),
                ongoing: @json($ongoingRequests),
                completed: @json($completedRequests),
            };

            // Convert timestamps to readable format
            tableData.pending = tableData.pending.map(request => ({
                id: request.ticket?.ticket_full ?? 'N/A',

                category: request.category ? request.category.category_name : 'N/A',
                subject: request.request_title,
                office: request.location,
                date_requested: new Date(request.created_at).toLocaleString(),
                status: request.latest_status?.status?.status_abbr ?? 'PND',
                contact: request.local_no,
                requester: `Requester ID: ${request.requester_id}`,
            }));

            tableData.picked = tableData.picked.map(request => ({
                id: request.ticket?.ticket_full ?? 'N/A',

                category: request.category ? request.category.category_name : 'N/A',
                subject: request.request_title,
                date_requested: new Date(request.created_at).toLocaleString(),
                technician: request.technician ? request.technician.name : 'Unassigned'
            }));

            tableData.ongoing = tableData.ongoing.map(request => ({
                id: request.ticket?.ticket_full ?? 'N/A',

                category: request.category ? request.category.category_name : 'N/A',
                subject: request.request_title,
                date_updated: new Date(request.updated_at).toLocaleString(),
                technician: request.technician ? request.technician.name : 'Unassigned'
            }));

            tableData.completed = tableData.completed.map(request => ({
                id: request.ticket?.ticket_full ?? 'N/A',

                category: request.category ? request.category.category_name : 'N/A',
                subject: request.request_title,
                date_completion: new Date(request.updated_at).toLocaleString(),
                technician: request.technician ? request.technician.name : 'Unassigned'
            }));

            console.log("Loaded Data:", tableData); // Debugging: Check if data loads properly
        }

        function renderTableData(tableType) {
            const data = tableData[tableType];
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const paginatedData = data.slice(start, end);
            const tableBody = document.getElementById(`${tableType}-table-body`);
            if (!tableBody) return;
            tableBody.innerHTML = '';
            paginatedData.forEach(item => {
                const row = document.createElement('tr');
                // Make rows more compact on 1024px screens
                row.className =
                    'border-b border-gray-400 hover:bg-gray-100 cursor-pointer text-left text-[10px] lg:text-xs xl:text-sm';
                row.onclick = () => showDetails(item);
                if (tableType === 'pending') {
                    row.innerHTML = `
                        <td class="lg:py-1.5 md:py-1 pl-2">${item.id}</td>
                        <td class="lg:py-1.5 md:py-1">${item.category}</td>
                        <td class="lg:py-1.5 md:py-1">${item.date_requested}</td>
                        <td class="lg:py-1.5 truncate max-w-[100px] md:py-1 lg:max-w-[150px] overflow-hidden">${item.subject}</td>
                        <td class="lg:py-1.5 md:py-1">${item.office}</td>
                    `;
                } else if (tableType === 'picked') {
                    row.innerHTML = `
                        <td class="py-1 lg:py-1.5 pl-2">${item.id}</td>
                        <td class="py-1 lg:py-1.5">${item.category}</td>
                        <td class="py-1 lg:py-1.5 truncate max-w-[100px] lg:max-w-[150px] overflow-hidden">${item.subject}</td>
                        <td class="py-1 lg:py-1.5">${item.date_requested}</td>
                        <td class="flex py-1 lg:py-1.5 items-center justify-start">
                            <img src="https://via.placeholder.com/30" alt="Technician" class="w-5 h-5 lg:w-6 lg:h-6 rounded-full">
                        </td>
                    `;
                } else if (tableType === 'ongoing') {
                    // Similar adjustments for ongoing table rows
                    row.innerHTML = `
                        <td class="py-1 lg:py-1.5 pl-2">${item.id}</td>
                        <td class="py-1 lg:py-1.5">${item.category}</td>
                        <td class="py-1 lg:py-1.5 truncate max-w-[100px] lg:max-w-[150px] overflow-hidden">${item.subject}</td>
                        <td class="py-1 lg:py-1.5">${item.date_updated}</td>
                        <td class="flex py-1 lg:py-1.5 items-center justify-start">
                            <img src="https://via.placeholder.com/30" alt="Technician" class="w-5 h-5 lg:w-6 lg:h-6 rounded-full">
                        </td>
                    `;
                } else if (tableType === 'completed') {
                    // Similar adjustments for completed table rows
                    row.innerHTML = `
                        <td class="py-1 lg:py-1.5 pl-2">${item.id}</td>
                        <td class="py-1 lg:py-1.5">${item.category}</td>
                        <td class="py-1 lg:py-1.5 truncate max-w-[100px] lg:max-w-[150px] overflow-hidden">${item.subject}</td>
                        <td class="py-1 lg:py-1.5">${item.date_completion}</td>
                        <td class="flex py-1 lg:py-1.5 items-center justify-start">
                            <img src="https://via.placeholder.com/30" alt="Technician" class="w-5 h-5 lg:w-6 lg:h-6 rounded-full">
                        </td>
                    `;
                }
                tableBody.appendChild(row);
            });
            updatePagination(tableType, data.length);
        }

        function updatePagination(tableType, totalItems) {
            const totalPages = Math.ceil(totalItems / perPage);
            const pageNumbersContainer = document.getElementById(`${tableType}-page-numbers`);
            const prevBtn = document.getElementById(`${tableType}-prev-btn`);
            const nextBtn = document.getElementById(`${tableType}-next-btn`);
            const entriesCount = document.getElementById(`${tableType}-entries-count`);

            // Update visibility of Previous and Next buttons
            prevBtn.style.display = currentPage > 1 ? 'inline-block' : 'none';
            nextBtn.style.display = currentPage < totalPages ? 'inline-block' : 'none';

            // Update entries count
            const start = (currentPage - 1) * perPage + 1;
            const end = Math.min(currentPage * perPage, totalItems);
            entriesCount.textContent = `Showing ${start} to ${end} of ${totalItems} entries`;

            // Render page numbers
            pageNumbersContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.className = `py-0.5 px-1.5 text-xs font-semibold transition ${
                    currentPage === i ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'
                }`;
                pageButton.textContent = i;
                pageButton.onclick = () => changePage(tableType, i);
                pageNumbersContainer.appendChild(pageButton);
            }
        }

        function changePage(tableType, newPage) {
            const totalPages = Math.ceil(tableData[tableType].length / perPage);
            if (newPage < 1 || newPage > totalPages) return;
            currentPage = newPage;
            renderTableData(tableType);
        }

        function showDetails(item) {
            details = item;
            console.log('Showing details for:', item);
        }

        // Modify the checkRequestLimitAndShowModal function
        function checkRequestLimitAndShowModal(event) {
            event.preventDefault();

            // Show loading indicator
            Swal.fire({
                title: 'Checking...',
                text: 'Please wait while we verify your request eligibility',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            // Check if user can create more requests before showing modal
            fetch('/ServiceTrackerGithub/api/check-request-limit', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                // Close the loading indicator
                Swal.close();

                console.log("Check request limit response:", data);

                if (data.canCreateRequest) {
                    showDashboardModal();
                } else {
                    // Determine which limit was reached for appropriate messaging
                    let title, message, showViewButton = false, redirectURL;

                    if (data.unratedLimitReached) {
                        title = 'Please Rate Your Requests First';
                        message = data.message || 'You have 3 or more completed requests that need to be rated before you can create a new request.';
                        showViewButton = true;
                        redirectURL = '{{ route("completed") }}';
                    } else if (data.pendingLimitReached) {
                        title = 'Maximum Pending Requests Reached';
                        message = data.message || 'You have reached the maximum amount of pending requests (3).';
                    } else {
                        title = 'Unable to Create Request';
                        message = data.message || 'You cannot create a new request at this time.';
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: title,
                        text: message,
                        confirmButtonColor: '#007A33',
                        showCancelButton: showViewButton,
                        cancelButtonText: 'View Unrated Requests',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // If they click "View Unrated Requests", redirect them to completed requests page
                        if (result.dismiss === Swal.DismissReason.cancel && showViewButton) {
                            window.location.href = redirectURL;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    text: 'There was a problem checking your request eligibility.',
                    confirmButtonColor: '#007A33'
                });
            });
        }

        function showDashboardModal() {
            document.getElementById('dashboardModal').style.display = 'flex';
        }

        function hideDashboardModal() {
            document.getElementById('dashboardModal').style.display = 'none';
        }

        function initializeChart() {
            const ctx = document.getElementById("summaryChart").getContext("2d");

            // Add custom screen width check for chart responsiveness
            const getChartPadding = () => {
                const width = window.innerWidth;
                if (width >= 1024 && width <= 1199) {
                    // Specific padding for exactly 1024px (laptop)
                    return {
                        top: 2,
                        bottom: 2,
                        left: 2,
                        right: 2
                    };
                } else if (width >= 1200 && width <= 1366) {
                    // Slightly larger padding for larger screens but not full desktop
                    return {
                        top: 5,
                        bottom: 5,
                        left: 5,
                        right: 5
                    };
                } else if (width < 768) {
                    // Mobile screens
                    return {
                        top: 10,
                        bottom: 10,
                        left: 10,
                        right: 10
                    };
                } else {
                    // Desktop/larger screens
                    return {
                        top: 20,
                        bottom: 20,
                        left: 20,
                        right: 20
                    };
                }
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                layout: {
                    padding: getChartPadding()
                }
            };

            const completedPercentage = {{ $completedPercentage }};
            const ongoingPercentage = {{ $ongoingPercentage }};
            const pickedPercentage = {{ $pickedPercentage }};

            new Chart(ctx, {
                type: "doughnut",
                data: {
                    datasets: [{
                            data: [100 - completedPercentage, completedPercentage], // Outer ring
                            backgroundColor: ["#E5E4E2", "#3B4E57"], // Dark Blue (Visible)
                            borderWidth: 3,
                            cutout: "50%",
                            borderRadius: 10,
                        },
                        {
                            data: [100 - ongoingPercentage, ongoingPercentage], // Second ring
                            backgroundColor: ["#E5E4E2", "#914D3A"], // Brown (Visible)
                            borderWidth: 3,
                            cutout: "50%",
                            borderRadius: 10,
                        },
                        {
                            data: [100 - pickedPercentage, pickedPercentage], // Third ring
                            backgroundColor: ["#E5E4E2", "#F4B861"], // Light Brown/Orange (Visible)
                            borderWidth: 3,
                            cutout: "50%",
                            borderRadius: 10,
                        },
                    ]
                },
                options: chartOptions
            });

            window.addEventListener('resize', function() {
                chartOptions.layout.padding = getChartPadding();
            });
        }

        // Add this function to calculate perPage based on screen width
        function getPerPageCount() {
            const width = window.innerWidth;
            if (width < 640) { // mobile
                return 5;
            } else if (width < 1024) { // tablet
                return 6;
            } else if (width < 1280) { // laptop
                return 5;
            } else { // desktop
                return 10;
            }
        }

        // Add resize listener to update perPage when screen size changes
        window.addEventListener('resize', function() {
            const oldPerPage = perPage;
            perPage = getPerPageCount();

            if (oldPerPage !== perPage) {
                // Reset to first page and re-render if items per page changed
                currentPage = 1;
                if (activeTable) {
                    renderTableData(activeTable);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize from date picker
            flatpickr("#from-date", {
                dateFormat: "F j, Y", // Changes format to "April 9, 2025"
                maxDate: "today",
                onChange: function(selectedDates, dateStr) {
                    // Update the minimum date of the "to" date picker
                    toPicker.set('minDate', selectedDates[0]);
                }
            });

            // Initialize to date picker
            const toPicker = flatpickr("#to-date", {
                dateFormat: "F j, Y", // Changes format to "April 9, 2025"
                maxDate: "today",
                onChange: function(selectedDates, dateStr) {
                    // Optional: Add any logic when "to" date changes
                }
            });
        });
    </script>
</x-layout>
