<x-layout>
    <!-- TITLE -->
    <div class="title flex flex-col sm:flex-row items-start sm:items-center justify-between w-full sm:w-[64%] mb-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-2 mb-2 sm:mb-0">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Ongoing Services</h2>
        </div>

        <!-- Search Bar -->
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto font-roboto-text">
            <div class="relative text-xs w-full sm:w-auto font-roboto-text">
                <input type="text" id="search-input" placeholder="SEARCH"
                    class="pr-10 pl-4 py-2 w-full sm:w-80 h-7 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#007A33] focus:outline-none"
                    value="{{ request('search') }}">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                </svg>
            </div>

            {{-- @if (Auth::check() && Auth::user()->role_id == DB::table('lib_roles')->where('role_name', 'Super Administrator')->value('id'))
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
            @endif --}}
        </div>
    </div>
    <!-- Add JavaScript to trigger the dynamic request -->
    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            // Get the value of the search input
            let searchValue = this.value;

            // Get the current URL parameters
            let urlParams = new URLSearchParams(window.location.search);

            // Update or add the 'search' parameter
            if (searchValue) {
                urlParams.set('search', searchValue);
            } else {
                urlParams.delete('search');
            }

            // Redirect to the new URL with the updated search query
            window.location.search = urlParams.toString();
        });
    </script>
    <!-- SHARED ALPINE SCOPE -->
    <div x-data="{
        selectedStatus: 'ongoing',
        details: null,
        get paginatedData() {
            return this.data.filter(item => this.selectedStatus === 'ongoing' ? item.status === 'Ongoing' : item.status === 'Paused')
                .slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage);
        },
        totalPages() {
            return Math.ceil(this.data.filter(item => this.selectedStatus === 'ongoing' ? item.status === 'Ongoing' : item.status === 'Paused').length / this.perPage);
        }
    }" class="flex flex-col lg:flex-row gap-3 mt-3 lg:h-[600px] w-full" x-ref="mainContainer">

        <!-- PARENT CONTAINER (Ensure it stacks elements vertically) -->
        <div class="w-full lg:w-[64%] flex flex-col lg:h-[590px] xl:h-[780px] font-roboto-text" x-data="tableData"
            x-init="$watch('currentPage', () => { paginatedData }); $watch('selectedStatus', (value) => { $refs.mainContainer.selectedStatus = value; })">
            <!-- STATUS BAR -->
            <div class="flex flex-wrap w-full">
                <!-- Ongoing Services -->
                <div class="flex items-center px-4 py-2 rounded-t-lg cursor-pointer transition-all"
                    :class="selectedStatus === 'ongoing' ? 'bg-white' : 'bg-gray'" @click="selectedStatus = 'ongoing'">
                    <p class="text-xs font-bold uppercase"
                        :class="selectedStatus === 'ongoing' ? 'text-[#007A33]' : 'text-black'">
                        Ongoing Services
                    </p>
                    <p class="ml-2 text-xs font-bold text-white px-2 py-1 rounded-lg"
                        :class="selectedStatus === 'ongoing' ? 'bg-[#007A33]' : 'bg-[#14213D]'"
                        x-text="data.filter(item => item.status === 'Ongoing').length">
                    </p>
                </div>

                <!-- Paused Services -->
                <div class="flex items-center px-4 py-2 rounded-t-lg cursor-pointer transition-all"
                    :class="selectedStatus === 'paused' ? 'bg-white' : 'bg-gray'" @click="selectedStatus = 'paused'">
                    <p class="text-xs font-bold uppercase"
                        :class="selectedStatus === 'paused' ? 'text-[#007A33]' : 'text-black'">
                        Paused Services
                    </p>
                    <p class="ml-2 text-xs font-bold text-white px-2 py-1 rounded-lg"
                        :class="selectedStatus === 'paused' ? 'bg-[#007A33]' : 'bg-[#14213D]'"
                        x-text="data.filter(item => item.status === 'Paused').length">
                    </p>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div
                class="bg-white shadow-md rounded-b-lg p-2 w-full flex flex-col overflow-hidden font-roboto-text lg:h-[590px] xl:h-[780px]">
                <!-- Filters -->
                <div class="flex flex-wrap items-center justify-between gap-2 p-2 rounded-lg">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-gray-500 text-xs font-medium">FROM</span>
                        <div class="relative">
                            <input type="text" id="from-date" value="{{ request('from_date') }}"
                                placeholder="Select date"
                                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                        </div>
                        <span class="text-gray-500 text-xs font-medium">TO</span>
                        <div class="relative">
                            <input type="text" id="to-date" value="{{ request('to_date') }}"
                                placeholder="Select date"
                                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
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
                        <select name="station_id" id="station-select"
                            class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                            <option value="">PHILRICE CES</option>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}"
                                    {{ request('station_id') == $station->id ? 'selected' : '' }}>
                                    {{ $station->station_abbr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="overflow-auto flex-grow min-h-[430px]">
                    <table class="w-full mt-2 lg:text-xs xl:text-sm text-left table-fixed">
                        <thead class="border-b border-t border-gray-400">
                            <tr class="text-left font-roboto-text">
                                <th class="py-2 w-[8%]">No.
                                    <button @click="sortTable('id')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                            class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </th>
                                <th class="py-2 pl-4 w-[18%]">Service Category
                                    <button @click="sortTable('category')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                            class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </th>
                                <th class="py-2 w-[15%]">Date Requested
                                    <button @click="sortTable('date_requested')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                            class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </th>
                                <th class="py-2 w-[15%]">Subject
                                    <button @click="sortTable('subject')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                                <th class="py-2 pl-4 w-[15%]">Technician/s
                                    <button @click="sortTable('technicians')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                                <th class="py-2 w-[10%]">Status
                                    <button @click="sortTable('status')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                                <th class="py-2 w-[15%]">Date Updated
                                    <button @click="sortTable('date_updated')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="ongoing-table-body" class="min-h-[400px]">
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr class="border-b border-gray-400 hover:bg-gray-100 cursor-pointer text-left align-middle"
                                    @click="details = { ...item }">
                                    <td class="py-4" x-text="item.id"></td>
                                    <td class="py-4 pl-4" x-text="item.category"></td>
                                    <td class="py-4">
                                        <span x-text="item.date_requested"></span><br>
                                        <span x-text="item.time_requested"></span>
                                    </td>
                                    <td class="py-4 truncate max-w-[150px] overflow-hidden" x-text="item.subject">
                                    </td>
                                    <td class="pt-5 pl-4 flex justify-start items-center align-middle">
                                        <img src="https://via.placeholder.com/30" alt="Technician"
                                            class="w-6 h-6 rounded-full">
                                    </td>
                                    <td class="py-4 font-bold text-black" x-text="item.status"></td>
                                    <td class="py-4" x-text="item.date_updated"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                @include('ICT Main.entries')
            </div>
        </div>

        <!-- SIDE PANEL -->
        <div x-show="details"
            class="w-full lg:w-[35%] bg-white shadow-lg rounded-lg p-4 h-auto lg:h-[590px] xl:h-[780px] overflow-y-auto flex flex-col font-roboto-text"
            x-data="{ showMessageForm: false, showDetailsView: false, showUpdateStatus: false }" x-cloak>
            <template x-if="details && !showMessageForm && !showUpdateStatus">
                <div class="flex flex-col ">
                    <!-- HEADER -->
                    <div class="flex justify-between items-center border-b pb-2">
                        <h2 class="font-bold text-lg" x-text="details.id"></h2>
                        <button @click="details = null; showDetailsView = false"
                            class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <template x-if="!showDetailsView">
                        <div class="flex flex-col justify-between lg:h-[521px] xl:h-[710px] ">
                            <div>
                                <div class="mt-3 text-sm">
                                    <p class="text-xs text-gray-400">Date Requested: <span
                                            x-text="details.date_requested"></span>
                                    </p>
                                    <p class="text-xs text-gray-400">Requested Date of Completion: <span
                                            x-text="details.date_completion"></span></p>
                                </div>

                                <div class="flex flex-row items-center space-x-2">
                                    <p class="py-2 text-xs">
                                        <strong>Status:</strong>
                                        <span class="font-bold text-black-600" x-text="details.status"></span>
                                        <span class="font-bold text-black-600">service</span> by
                                    </p>
                                    <img src="https://via.placeholder.com/30" alt="Technician"
                                        class="w-4 h-4 rounded-full">
                                </div>

                                <p class="text-xs text-black">Working Time: <span x-text="details.working_time"
                                        class="font-bold"></span>
                                </p>

                                <!-- SUBJECT -->
                                <div class="bg-gray-100 p-2 mt-3 rounded">
                                    <p class="text-xs"><strong>Subject:</strong> <span class="font-bold"
                                            x-text="details.subject"></span></p>
                                    <p class="text-xs text-gray-500">Description: <span class="text-xs"
                                            x-text="details.description"></span></p>
                                    <div class="text-right">
                                        <a href="#" class="text-[10px] text-green-600" id="more_details"
                                            @click.prevent="showDetailsView = true">See request
                                            details</a>
                                    </div>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="mt-3">
                                    <button @click="showMessageForm = true"
                                        class="bg-[#45CF7F] text-[#007A33] px-4 py-1 rounded-md w-full text-xs font-semibold">
                                        MESSAGE CLIENT
                                    </button>
                                </div>

                                <!-- STATUS HISTORY -->
                                <div class="mt-3 flex-grow">
                                    <h3 class="text-lg font-bold text-black">Status History</h3>
                                    <div class="mt-4 space-y-2">
                                        <template
                                            x-for="history in [
                                { date: '02/14/2025', time: '10:00AM', status: 'Pending', technician: null },
                                { date: '02/14/2025', time: '2:15PM', status: 'Picked', technician: 'Ranniel Lauriaga' }
                            ]"
                                            :key="history.date + history.time">
                                            <div class="flex space-x-10">
                                                <!-- Left: Date & Time -->
                                                <div class="text-xs text-gray-600">
                                                    <p x-text="history.date"></p>
                                                    <p x-text="history.time"></p>
                                                </div>
                                                <!-- Right: Status & Technician -->
                                                <div class="text-xs text-black">
                                                    <p><strong>Status:</strong> <span x-text="history.status"></span>
                                                    </p>
                                                    <template x-if="history.technician">
                                                        <p><strong>Technician:</strong> <span
                                                                x-text="history.technician"></span>
                                                        </p>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Start Service Button (Now at the bottom) -->
                            <div class="mt-auto">
                                <button @click="showUpdateStatus = true"
                                    class="bg-[#007A33] text-white px-4 py-1 rounded-md w-full text-xs font-semibold">UPDATE
                                    STATUS</button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="showUpdateStatus">
                <div class="flex flex-col flex-grow overflow-y-auto scroll-hidden max-h-[90vh]"
                    x-data="{
                        status: $refs.mainContainer?.selectedStatus || 'ongoing',
                        init() {
                            // Set initial status from parent selected status
                            this.status = $refs.mainContainer?.selectedStatus || 'ongoing';

                            // Watch for parent status changes
                            this.$watch('$refs.mainContainer.selectedStatus', value => {
                                console.log('Parent status changed to:', value);
                            });
                        },
                        get currentTab() {
                            return $refs.mainContainer?.selectedStatus || 'ongoing';
                        }
                    }">
                    <!-- HEADER -->
                    <div class="flex justify-between items-center border-b pb-2">
                        <h2 class="font-bold text-lg" x-text="details.id"></h2>
                        <button @click="showUpdateStatus = false" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex space-x-1 pb-2 mt-2">
                        <!-- Back Button -->
                        <button @click="showUpdateStatus = false" class="text-green-700 hover:text-green-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Title -->
                        <h2 class="font-bold text-lg flex-grow">Update Status</h2>
                    </div>

                    <!-- Status Selection -->
                    <div class="mt-1">
                        <p class="font-bold">Status</p>
                        <div class="flex mt-2">
                            <!-- Ongoing - Disabled when in ongoing tab -->
                            <button @click="status = 'ongoing'"
                                :class="status === 'ongoing' ? 'bg-[#007A33]' : 'bg-[#0B1F3D]'"
                                :disabled="currentTab === 'ongoing'"
                                class="text-white px-2 py-3 text-xs flex-1 flex items-center justify-center space-x-1"
                                :style="currentTab === 'ongoing' ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                                <div class="flex flex-col items-center">
                                    <img src="{{ url('public/svg/ongoing.svg') }}" alt="ongoing"
                                        class="size-5 filter-white pb-1">
                                    <span>ONGOING</span>
                                </div>
                            </button>

                            <!-- Paused - Disabled when in paused tab -->
                            <button @click="status = 'paused'"
                                :class="status === 'paused' ? 'bg-[#007A33]' : 'bg-[#0B1F3D]'"
                                :disabled="currentTab === 'paused'"
                                class="text-white px-2 py-3 text-xs flex-1 flex items-center justify-center space-x-1"
                                :style="currentTab === 'paused' ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                                <div class="flex flex-col items-center">
                                    <img src="{{ url('public/svg/paused.svg') }}" alt="paused"
                                        class="size-5 filter-white pb-1">
                                    <span>PAUSED</span>
                                </div>
                            </button>

                            <!-- Denied (always enabled) -->
                            <button @click="status = 'denied'"
                                :class="status === 'denied' ? 'bg-[#007A33]' : 'bg-[#0B1F3D]'"
                                class="text-white px-2 py-3 text-xs flex-1 flex items-center justify-center space-x-1">
                                <div class="flex flex-col items-center">
                                    <img src="{{ url('public/svg/denied.svg') }}" alt="denied"
                                        class="size-5 filter-white pb-1">
                                    <span>DENIED</span>
                                </div>
                            </button>

                            <!-- Cancelled (always enabled) -->
                            <button @click="status = 'cancelled'"
                                :class="status === 'cancelled' ? 'bg-[#007A33]' : 'bg-[#0B1F3D]'"
                                class="text-white px-2 py-3 text-xs flex-1 flex items-center justify-center space-x-1">
                                <div class="flex flex-col items-center">
                                    <img src="{{ url('public/svg/cancelled.svg') }}" alt="cancelled"
                                        class="size-5 filter-white pb-1">
                                    <span>CANCELLED</span>
                                </div>
                            </button>

                            <!-- Completed - Disabled when in paused tab -->
                            <button @click="status = 'completed'"
                                :class="status === 'completed' ? 'bg-[#007A33]' : 'bg-[#0B1F3D]'"
                                :disabled="currentTab === 'paused'"
                                class="text-white px-2 py-3 text-xs flex-1 flex items-center justify-center space-x-1"
                                :style="currentTab === 'paused' ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                                <div class="flex flex-col items-center">
                                    <img src="{{ url('public/svg/completed.svg') }}" alt="completed"
                                        class="size-5 filter-white pb-1">
                                    <span>COMPLETED</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Technician List -->
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <p class="font-bold">Technician/s</p>
                            <p class="text-xs text-right text-green-600 cursor-pointer">Edit Technicians</p>
                        </div>

                        <div class="flex flex-col w-full pt-2 pl-2 pb-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-xs font-medium">Lead Technician</label>
                                </div>
                                <div class="relative w-[70%] pl-4">
                                    <select
                                        class="border border-gray-300 text-gray-700 bg-[#EEEEEE] text-xs pl-10 pr-3 py-4 rounded-lg w-full appearance-none">
                                        <option>John Doe</option>
                                    </select>
                                    <div
                                        class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center pl-4">
                                        <div class="w-6 h-6 bg-[#B0B0B0] rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approved By Field -->
                        <div class="flex flex-col w-full pb-5 pl-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-xs font-medium">Co worker</label>
                                </div>
                                <div class="relative w-[70%] pl-4">
                                    <select
                                        class="border border-gray-300 text-gray-700 text-xs bg-[#EEEEEE] pl-10 pr-3 py-4 rounded-lg w-full appearance-none">
                                        <option>John Doe</option>
                                    </select>
                                    <div
                                        class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center pl-4">
                                        <div class="w-6 h-6 bg-[#B0B0B0] rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentation Upload (ALWAYS VISIBLE) -->
                    <div class="mt-4 pb-1">
                        <p class="font-bold">Documentation</p>
                        <button
                            class="bg-[#45CF7F] text-[#007A33] px-4 py-1 rounded-md w-full mt-2 text-xs font-semibold">UPLOAD
                            PHOTO</button>
                    </div>

                    <!-- Technician Findings (Only Visible for Paused, Denied, Cancelled, Completed) -->
                    <div class="mt-4 max-h-[300px]"
                        x-show="
                            // Only show when:
                            // 1. If in ongoing tab: status is not ongoing
                            // 2. If in paused tab: status is not paused
                            (currentTab === 'ongoing' && status !== 'ongoing') ||
                            (currentTab === 'paused' && status !== 'paused')
                        "
                        x-transition.duration.300ms>
                        <p class="font-bold">Technician Findings</p>

                        <form x-ref="statusUpdateForm" @submit.prevent="validateAndSubmitForm"
                        :action="status === 'paused' ? '{{ route('request.paused') }}' :
                            status === 'denied' ? '{{ route('request.denied') }}' :
                            status === 'cancelled' ? '{{ route('request.cancelled') }}' :
                            status === 'ongoing' ? '{{ route('request.ongoing') }}' :
                            '{{ route('request.completed') }}'"
                        method="POST" x-data="{
                            validateAndSubmitForm() {
                                const form = $refs.statusUpdateForm;
                                const formData = new FormData(form);

                                // Check required fields
                                if (!formData.get('problem_id')) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please select a problem encountered',
                                        confirmButtonColor: '#007A33'
                                    });
                                    return;
                                }

                                if (!formData.get('action_id')) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please select an action taken',
                                        confirmButtonColor: '#007A33'
                                    });
                                    return;
                                }

                                if (!formData.get('remarks')) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please provide remarks',
                                        confirmButtonColor: '#007A33'
                                    });
                                    return;
                                }

                                // If validation passes, show confirmation dialog
                                Swal.fire({
                                    title: 'Update Status?',
                                    text: 'Are you sure you want to update the status?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#007A33',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, update it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.submitStatusForm();
                                    }
                                });
                            },
                            submitStatusForm() {
                                const form = $refs.statusUpdateForm;
                                const formData = new FormData(form);

                                // Log formData values for debugging
                                console.log('Form data:', {
                                    request_id: formData.get('request_id'),
                                    problem_id: formData.get('problem_id'),
                                    action_id: formData.get('action_id'),
                                    remarks: formData.get('remarks')
                                });

                                // Ensure request_id is correctly added to formData
                                formData.set('request_id', details.request_id);

                                fetch(form.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: formData
                                    })
                                    .then(async response => {
                                        // Handle both successful and error responses
                                        const data = await response.json();

                                        if (!response.ok) {
                                            throw new Error(data.message || 'Network response was not ok');
                                        }

                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Status Updated',
                                                text: data.message || 'The request status has been updated successfully',
                                                confirmButtonColor: '#007A33'
                                            }).then(() => {
                                                // Always reload after success
                                                window.location.reload();
                                            });
                                        } else {
                                            throw new Error(data.message || 'Update failed');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: error.message || 'There was a problem with the request. Please try again.',
                                            confirmButtonColor: '#007A33'
                                        }).then(() => {
                                            // Reload even on error since the update might have succeeded
                                            window.location.reload();
                                        });
                                    });
                            }
                        }">
                        @csrf
                        <input type="hidden" name="request_id" :value="details.request_id">
                        <input type="hidden" name="status" :value="status">


                            <!-- Problems Encountered -->

                            <p class="mt-2 text-sm text-gray-600">Problems Encountered</p>
                            <div x-data="{
                                problems: [],
                                search: '',
                                selectedProblem: null,
                                selectedProblemId: '',
                                isOpen: false,
                                async loadProblems() {
                                    try {
                                        const response = await fetch('/ServiceTrackerGithub/api/problems-by-category/0');
                                        if (!response.ok) throw new Error('Network response was not ok');
                                        const data = await response.json();
                                        this.problems = data;
                                    } catch (error) {
                                        console.error('Error loading problems:', error);
                                        this.problems = [];
                                    }
                                },
                                get filteredProblems() {
                                    return this.problems.filter(
                                        problem => problem.encountered_problem_name.toLowerCase().includes(this.search.toLowerCase())
                                    );
                                },
                                selectProblem(problem) {
                                    this.selectedProblem = problem;
                                    this.selectedProblemId = problem.id;
                                    this.search = problem.encountered_problem_name;
                                    this.isOpen = false;
                                },
                                clearSelection() {
                                    this.selectedProblem = null;
                                    this.selectedProblemId = '';
                                    this.search = '';
                                }
                            }" x-init="loadProblems()" class="relative">
                                <div class="flex">
                                    <input type="text" x-model="search" @focus="isOpen = true"
                                        @click.away="isOpen = false" placeholder="Search or select a problem"
                                        class="border rounded-md w-full px-2 py-1 text-sm">
                                    <input type="hidden" name="problem_id" x-model="selectedProblemId">
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="absolute right-0 top-0 px-2 py-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="clearSelection" x-show="selectedProblem"
                                        class="absolute right-7 top-0 px-2 py-1 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="isOpen"
                                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto"
                                    x-transition>
                                    <div x-show="filteredProblems.length === 0"
                                        class="px-4 py-2 text-sm text-gray-500">
                                        No problems found
                                    </div>
                                    <template x-for="problem in filteredProblems" :key="problem.id">
                                        <div @click="selectProblem(problem)"
                                            class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                                            x-text="problem.encountered_problem_name"></div>
                                    </template>
                                </div>
                            </div>

                            <!-- Actions Taken -->
                            <p class="mt-2 text-sm text-gray-600">Actions Taken</p>
                            <div x-data="{
                                actions: [],
                                search: '',
                                selectedAction: null,
                                selectedActionId: '',
                                isOpen: false,
                                async loadActions() {
                                    try {
                                        const categoryId = details?.category_id || 0;
                                        const response = await fetch(`/ServiceTrackerGithub/api/actions-by-category/${categoryId}`);
                                        if (!response.ok) throw new Error('Network response was not ok');
                                        const data = await response.json();
                                        this.actions = data;
                                    } catch (error) {
                                        console.error('Error loading actions:', error);
                                        this.actions = [];
                                    }
                                },
                                get filteredActions() {
                                    return this.actions.filter(
                                        action => action.action_name.toLowerCase().includes(this.search.toLowerCase())
                                    );
                                },
                                selectAction(action) {
                                    this.selectedAction = action;
                                    this.selectedActionId = action.id;
                                    this.search = action.action_name;
                                    this.isOpen = false;
                                },
                                clearSelection() {
                                    this.selectedAction = null;
                                    this.selectedActionId = '';
                                    this.search = '';
                                }
                            }" x-init="loadActions()" class="relative">
                                <div class="flex">
                                    <input type="text" x-model="search" @focus="isOpen = true"
                                        @click.away="isOpen = false" placeholder="Search or select an action"
                                        class="border rounded-md w-full px-2 py-1 text-sm">
                                    <input type="hidden" name="action_id" x-model="selectedActionId">
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="absolute right-0 top-0 px-2 py-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="clearSelection" x-show="selectedAction"
                                        class="absolute right-7 top-0 px-2 py-1 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="isOpen"
                                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto"
                                    x-transition>
                                    <div x-show="filteredActions.length === 0"
                                        class="px-4 py-2 text-sm text-gray-500">
                                        No actions found
                                    </div>
                                    <template x-for="action in filteredActions" :key="action.id">
                                        <div @click="selectAction(action)"
                                            class="px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer"
                                            x-text="action.action_name"></div>
                                    </template>
                                </div>
                            </div>
                            <!-- Remarks -->
                            <p class="mt-2 text-sm text-gray-600">Remarks</p>
                            <textarea class="border rounded-md w-full px-2 py-1 text-sm mb-2" rows="4" name="remarks"></textarea>

                            <!-- This button will be used instead of the global UPDATE STATUS button when in these statuses -->
                            <button type="submit"
                                class="mt-2 bg-[#007A33] text-white px-4 py-1 rounded-md w-full text-xs font-semibold">
                                <span x-text="'UPDATE TO ' + status.toUpperCase()"></span>
                            </button>
                        </form>
                    </div>

                    <!-- Update Status Button -->

                </div>
            </template>
            <template x-if="showDetailsView">
                <div class="flex flex-col flex-grow">
                    <!-- Back Arrow + Header -->
                    <div class="flex items-center space-x-2 pb-2 mt-3">
                        <button @click="showDetailsView = false" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3" stroke="green" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="font-bold text-lg">Request Details</h2>
                    </div>

                    <div class="bg-gray-100 p-3 rounded">
                        <p class="text-sm"><strong>Subject:</strong> <span class="font-bold"
                                x-text="details.subject"></span></p>
                        <p class="text-xs text-gray-500">Description: <span class="text-xs"
                                x-text="details.description"></span></p>
                    </div>
                    <!-- Request Information -->
                    <div class="mt-3 text-sm">
                        <p class="text-xs text-gray-400">Date Requested: <span x-text="details.date_requested"></span>
                        </p>
                        <p class="text-xs text-gray-400">Requested Date of Completion: <span
                                x-text="details.date_completion"></span></p>
                    </div>

                    <p class="text-xs text-gray-400">Location: <span x-text="details.office"></span></p>
                    <p class="text-xs text-gray-400">Contact details: <span x-text="details.contact"></span></p>

                    <!-- Service Category -->
                    <div class="mt-3">
                        <p class="text-[12px] text-gray-400">Service Category:</p>
                        <select class="border border-gray-300 text-gray-700 text-xs px-3 h-[20px] w-full rounded-md">
                            <option>Computer Related Services</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <p class="text-[12px] text-gray-400">Subcategory:</p>
                        <select class="border border-gray-300 text-gray-700 text-xs px-3 h-[20px] w-full rounded-md">
                            <option>Computer Repair</option>
                        </select>
                    </div>

                    <!-- Requester & Client -->
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-gray-400"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-600">Requester:</p>
                                <p class="text-sm font-medium text-gray-900" x-text="details.requester"></p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-gray-400"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-600">Actual Client:</p>
                                <p class="text-sm font-medium text-gray-900" x-text="details.client"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Request Button -->
                    <div class="mt-auto pt-2">
                        <button class="bg-green-700 text-white px-4 py-1 rounded-md w-full text-xs font-semibold">EDIT
                            REQUEST</button>
                    </div>
                </div>
            </template>


            <!-- Message Form Template -->
            <template x-if="details && showMessageForm">
                <div class="flex flex-col flex-grow">
                    <!-- HEADER -->
                    <div class="flex justify-between items-center border-b pb-2">
                        <h2 class="font-bold text-lg" x-text="details.id"></h2>
                        <button @click="details = null; showMessageForm = false"
                            class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- MESSAGE CLIENT HEADER -->
                    <div class="flex items-center mt-3">
                        <!-- Back Button -->
                        <button @click="showMessageForm = false" class="text-green-600 hover:text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <p class="text-black font-bold text-lg ml-2">Message Client</p>
                    </div>

                    <!-- FORM -->
                    <form @submit.prevent="sendMessage" class="mt-4 flex flex-col space-y-3">
                        <!-- Recipient Display -->
                        <div>
                            <label class="text-xs text-gray-400 font-medium">Recipient</label>
                            <input type="text" :value="details.requester || 'Unknown User'"
                                class="w-full border-2 border-gray-400 rounded-xl p-2 text-xs mt-1" readonly>
                            <input type="hidden" :value="details.requester_id" name="recipient_id">
                            <input type="hidden" :value="details.request_id" name="service_request_id">
                            <input type="hidden" :value="details.ticket_number" name="ticket_number">
                        </div>

                        <!-- Subject Input -->
                        <div>
                            <label class="text-xs text-gray-400 font-medium">Subject</label>
                            <input type="text" :value="details.subject"
                                class="w-full border-2 border-gray-400 rounded-xl p-2 text-xs mt-1" name="subject"
                                readonly>
                        </div>

                        <!-- Message Textarea -->
                        <div>
                            <label class="text-xs text-gray-400 font-medium">Message</label>
                            <textarea name="message" class="w-full border-2 border-gray-400 rounded-xl p-2 text-xs h-40 mt-1" required></textarea>
                        </div>

                        <!-- Send Button -->
                        <div class="mt-auto pt-2">
                            <button type="submit"
                                class="bg-[#007A33] text-white px-4 py-1 rounded-md w-full text-xs font-semibold">
                                SEND MESSAGE
                            </button>
                        </div>
                    </form>
                </div>
            </template>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get today's date for setting max date
            const today = new Date();

            // Initialize from-date picker
            const fromDatePicker = flatpickr("#from-date", {
                dateFormat: "F j Y", // Format: Month name Day Year (e.g., "April 12 2025")
                maxDate: today,
                altInput: true, // Use alternative input to display the formatted date
                altFormat: "F j Y", // Format for the visible input
                dateFormat: "Y-m-d", // Keep this format for the actual value (for the backend)
                onChange: function(selectedDates, dateStr) {
                    // Update to-date min when from-date changes
                    toDatePicker.set('minDate', dateStr);

                    // Trigger filter update
                    updateFilters();
                }
            });

            // Initialize to-date picker
            const toDatePicker = flatpickr("#to-date", {
                dateFormat: "F j Y", // Format: Month name Day Year (e.g., "April 12 2025")
                maxDate: today,
                altInput: true, // Use alternative input to display the formatted date
                altFormat: "F j Y", // Format for the visible input
                dateFormat: "Y-m-d", // Keep this format for the actual value (for the backend)
                onChange: function(selectedDates, dateStr) {
                    // Update from-date max when to-date changes
                    fromDatePicker.set('maxDate', dateStr || today);

                    // Trigger filter update
                    updateFilters();
                }
            });

            // Set initial restrictions based on existing values
            if (document.getElementById('to-date').value) {
                fromDatePicker.set('maxDate', document.getElementById('to-date').value);
            }

            if (document.getElementById('from-date').value) {
                toDatePicker.set('minDate', document.getElementById('from-date').value);
            }

            // Replace the old updateFilters function with this enhanced version
            window.updateFilters = function() {
                const fromDate = document.getElementById('from-date').value;
                const toDate = document.getElementById('to-date').value;
                const technicianId = document.getElementById('technician-select')?.value;
                const stationId = document.getElementById('station-select')?.value;

                const query = new URLSearchParams();

                if (fromDate) query.append('from_date', fromDate);
                if (toDate) query.append('to_date', toDate);
                if (technicianId) query.append('technician_id', technicianId);
                if (stationId) query.append('station_id', stationId);

                // Preserve search parameter if it exists
                const searchParam = new URLSearchParams(window.location.search).get('search');
                if (searchParam) query.append('search', searchParam);

                window.location.href = `{{ route('ongoing') }}?${query.toString()}`;
            };

            // Remove old event listeners since Flatpickr handles the changes now
            document.getElementById('technician-select')?.addEventListener('change', updateFilters);
            document.getElementById('station-select')?.addEventListener('change', updateFilters);
        });

        document.addEventListener("alpine:init", () => {
            Alpine.data("tableData", () => ({
                selectedStatus: "ongoing",
                currentPage: 1,
                perPage: getPerPageCount(),
                sortKey: '',
                sortAsc: true,
                data: @json($combinedRequests), // Ensure data is properly JSON encoded

                init() {
                    console.log('Initial data:', this.data); // Debug log
                    window.addEventListener('resize', () => {
                        const oldPerPage = this.perPage;
                        const newPerPage = getPerPageCount();
                        if (oldPerPage !== newPerPage) {
                            this.perPage = newPerPage;
                            this.currentPage = 1;
                        }
                    });
                },

                get paginatedData() {
                    let filteredData = this.data.filter(item =>
                        this.selectedStatus === 'ongoing' ?
                        item.status.toLowerCase() === 'ongoing' :
                        item.status.toLowerCase() === 'paused'
                    );

                    if (this.sortKey) {
                        filteredData.sort((a, b) => {
                            let valA = a[this.sortKey];
                            let valB = b[this.sortKey];

                            if (this.sortKey === 'date_requested') {
                                valA = new Date(valA);
                                valB = new Date(valB);
                            } else {
                                valA = String(valA).toLowerCase();
                                valB = String(valB).toLowerCase();
                            }

                            if (valA < valB) return this.sortAsc ? -1 : 1;
                            if (valA > valB) return this.sortAsc ? 1 : -1;
                            return 0;
                        });
                    }

                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return filteredData.slice(start, end);
                },

                // Computed: Total pages based on filtered data
                totalPages() {
                    return Math.ceil(this.data.filter(item =>
                        this.selectedStatus === 'ongoing' ? item.status === 'Ongoing' : item
                        .status === 'Paused'
                    ).length / this.perPage);
                },

                // Computed: Visible page numbers
                visiblePages() {
                    let total = this.totalPages();
                    let start = Math.max(1, this.currentPage - 2);
                    let end = Math.min(total, start + 3);

                    if (end - start < 4) {
                        start = Math.max(1, end - 3);
                    }

                    return Array.from({
                        length: end - start + 1
                    }, (_, i) => start + i);
                },

                // Actions: Change status filter
                changeStatus(status) {
                    this.selectedStatus = status;
                    this.currentPage = 1;
                },

                // Actions: Pagination
                nextPage() {
                    if (this.currentPage < this.totalPages()) {
                        this.currentPage++;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                // Actions: Sorting
                sortTable(key) {
                    if (this.sortKey === key) {
                        this.sortAsc = !this.sortAsc;
                    } else {
                        this.sortKey = key;
                        this.sortAsc = true;
                    }
                    this.currentPage = 1;
                }
            }));
        });

        function getPerPageCount() {
            const width = window.innerWidth;
            if (width < 640) { // mobile
                return 5;
            } else if (width < 1024) { // tablet
                return 6;
            } else if (width < 1280) { // laptop/lg screens
                return 7; // As per your requirement for lg screens
            } else { // xl screens and larger
                return 8; // As per your requirement for xl screens
            }
        }


        let sortDirection = true;

        function sortTable(column) {
            const tableBody = document.getElementById('ongoing-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const aText = a.querySelector(`[x-text="${column}"]`).textContent.trim();
                const bText = b.querySelector(`[x-text="${column}"]`).textContent.trim();

                if (column === 'date_requested') {
                    return sortDirection ?
                        new Date(aText) - new Date(bText) :
                        new Date(bText) - new Date(aText);
                }

                return sortDirection ?
                    aText.localeCompare(bText) :
                    bText.localeCompare(aText);
            });

            sortDirection = !sortDirection;

            rows.forEach(row => tableBody.appendChild(row));
        }
    </script>

    <script>
        function sendMessage(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            fetch('{{ route('message.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Message sent successfully',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Store the current scroll position
                                const scrollPosition = window.scrollY;

                                // Reload the page but prevent visible refreshing
                                document.body.style.opacity = '0.5';
                                document.body.style.transition = 'opacity 0.2s';

                                // Use location.reload(true) for a fresh reload from server
                                window.location.reload(true);

                                // When page reloads, this won't run, but if there's an issue:
                                setTimeout(() => {
                                    document.body.style.opacity = '1';
                                    window.scrollTo(0, scrollPosition);
                                }, 100);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to send message',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to send message',
                    });
                });
        }
    </script>
</x-layout>
