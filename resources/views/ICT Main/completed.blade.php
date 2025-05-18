<x-layout>
    <!-- TITLE -->
    <div class="title flex flex-col sm:flex-row items-start sm:items-center justify-between w-full sm:w-[64%] mb-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-2 mb-2 sm:mb-0">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Completed Services</h2>
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
        selectedStatus: 'completed', // Start with completed tab selected
        details: null,
        currentPage: 1,
        perPage: 7,
        data: [], // your data will be injected here

        decodeHtml(html) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = html;
            return textarea.value;
        },

        get paginatedData() {
            return this.data
                .filter(item => {
                    if (this.selectedStatus === 'completed') {
                        return item.statusFilter === 'Completed';
                    } else if (this.selectedStatus === 'evaluated') {
                        return item.statusFilter === 'Evaluated';
                    } else {
                        return item.statusFilter === 'Others';
                    }
                })
                .slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage);
        },

        totalPages() {
            // Updated to match the filtering logic above
            return Math.ceil(this.data.filter(item => {
                if (this.selectedStatus === 'completed') {
                    return item.statusFilter === 'Completed';
                } else if (this.selectedStatus === 'evaluated') {
                    return item.statusFilter === 'Evaluated';
                } else {
                    return item.statusFilter === 'Others';
                }
            }).length / this.perPage);
        }
    }" class="flex flex-col lg:flex-row gap-3 mt-3 h-auto lg:h-[600px] w-full">

        <!-- TABLE SECTION -->
        <div class="w-full lg:w-[64%] flex flex-col h-auto lg:h-[590px] xl:h-[780px] font-roboto-text"
            x-data="tableData" x-init="$watch('currentPage', () => { paginatedData })">
            <!-- STATUS BAR -->
            <div class="flex flex-wrap w-full">
                <!-- Completed Services -->
                <div class="flex items-center px-4 py-2 rounded-t-lg cursor-pointer transition-all"
                    :class="selectedStatus === 'completed' ? 'bg-white' : 'bg-gray'"
                    @click="selectedStatus = 'completed'">
                    <p class="text-xs font-bold uppercase"
                        :class="selectedStatus === 'completed' ? 'text-[#007A33]' : 'text-black'">
                        Completed Services
                    </p>
                    <p class="ml-2 text-xs font-bold text-white px-2 py-1 rounded-lg"
                        :class="selectedStatus === 'completed' ? 'bg-[#007A33]' : 'bg-[#14213D]'"
                        x-text="data.filter(item => item.statusFilter  === 'Completed').length">
                    </p>
                </div>


                <div class="flex items-center px-4 py-2 rounded-t-lg cursor-pointer transition-all"
                    :class="selectedStatus === 'evaluated' ? 'bg-white' : 'bg-gray'"
                    @click="selectedStatus = 'evaluated'">
                    <p class="text-xs font-bold uppercase"
                        :class="selectedStatus === 'evaluated' ? 'text-[#007A33]' : 'text-black'">
                        Evaluated
                    </p>
                    <p class="ml-2 text-xs font-bold text-white px-2 py-1 rounded-lg"
                        :class="selectedStatus === 'evaluated' ? 'bg-[#007A33]' : 'bg-[#14213D]'"
                        x-text="data.filter(item => item.statusFilter === 'Evaluated').length">
                    </p>
                </div>

                <!-- Others Services -->
                <div class="flex items-center px-4 py-2 rounded-t-lg cursor-pointer transition-all"
                    :class="selectedStatus === 'others' ? 'bg-white' : 'bg-gray'" @click="selectedStatus = 'others'">
                    <p class="text-xs font-bold uppercase"
                        :class="selectedStatus === 'others' ? 'text-[#007A33]' : 'text-black'">
                        Others
                    </p>
                    <p class="ml-2 text-xs font-bold text-white px-2 py-1 rounded-lg"
                        :class="selectedStatus === 'others' ? 'bg-[#007A33]' : 'bg-[#14213D]'"
                        x-text="data.filter(item => item.statusFilter  === 'Others').length">
                    </p>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-b-lg p-2 w-full flex flex-col overflow-hidden lg:h-[590px] xl:h-[780px]">
                <!-- Filters -->
                <div class="flex flex-wrap items-center justify-between gap-2 p-2 rounded-lg font-roboto-text">
                    <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-0">
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

                <div class="overflow-auto flex-grow min-h-[430px]">
                    <table class="w-full mt-2 lg:text-xs xl:text-sm text-left table-fixed font-roboto-text">
                        <!-- ✅ Added 'text-center' to the table to center all content -->
                        <thead class="border-b border-t border-gray-400">
                            <tr class="text-left">
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
                                <th class="py-2 w-[17%]">Service Category
                                    <button @click="sortTable('category')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                            class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </th>
                                <th class="py-2 pl-2 w-[17%]">Date Requested
                                    <button @click="sortTable('date_requested')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                            class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </th>
                                <th class="py-2 w-[10%]">Subject
                                    <button @click="sortTable('subject')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                                <th class="py-2 w-[15%]">Technician/s
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
                                <th class="py-2 w-[10%]">Rating
                                    <button @click="sortTable('rating')"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="gray" class="size-3">
                                            <path fill-rule="evenodd"
                                                d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg></button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="completed-table-body">
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr class="border-b hover:bg-gray-100 border-gray-400 cursor-pointer text-left"
                                    @click="details = { ...item }">
                                    <td class="py-3" x-text="item.id"></td>
                                    <td class="py-3" x-text="item.category"></td>
                                    <td class="py-3 pl-2">
                                        <span x-text="item.date_requested"></span><br>
                                        <span x-text="item.time_requested"></span>
                                    </td>
                                    <td class="py-3 pr-3 truncate max-w-[150px] overflow-hidden"
                                        x-text="item.subject">
                                    </td>
                                    <td class="py-3">
                                        <img src="https://via.placeholder.com/30" alt="Technician"
                                            class="w-6 h-6 rounded-full">
                                    </td>
                                    <td class="py-3 font-bold text-black" x-text="item.status"></td>
                                    <td class="py-3" x-text="item.date_updated"></td>
                                    <td class="py-3" x-text="item.rating"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                @include('ICT Main.entries')
            </div>
        </div>

        {{-- SIDE PANEL --}}
        <div x-show="details"
            class="w-full lg:w-[35%] bg-white shadow-lg rounded-lg p-4 h-auto lg:h-[590px] xl:h-[780px] font-roboto-text flex flex-col"
            x-data="{ showMessageForm: false, showDetailsView: false }" x-cloak>

            <!-- Details Panel -->
            <template x-if="details && !showMessageForm">
                <div class="flex flex-col">
                    <!-- HEADER -->
                    <div class="flex justify-between items-center border-b pb-2">
                        <h2 class="font-bold text-lg" x-text="details.id"></h2>
                        <button @click="details = null" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <template x-if="!showDetailsView">
                        <div class="flex flex-col justify-between lg:h-[521px] xl:h-[710px]">
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
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-xs text-black">Working Time: <span
                                                x-text="details.working_time" class="font-bold"></span>
                                        </p>

                                        <p class="text-xs ">Rating: <span x-text="details.rating"
                                                class="text-black font-bold"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs">Problems Encountered: <span
                                                x-text="details && decodeHtml(details.problem_name) || 'None'"
                                                class="text-black font-bold"></span>
                                        </p>

                                        <p class="text-xs">Actions Taken: <span
                                                x-text="details && decodeHtml(details.action_name) || 'None'"
                                                class="text-black font-bold"></span>
                                        </p>

                                        <p class="text-xs">Remarks: <span
                                                x-text="details && decodeHtml(details.remarks) || 'None'"
                                                class="text-black font-bold"></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- SUBJECT -->
                                <div class="bg-gray-100 p-3 mt-3 rounded">
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
                                            <div class="flex space-x-4">
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
                                <button
                                    class="bg-[#007A33] text-white px-4 py-1 rounded-md w-full text-xs font-semibold">VIEW
                                    PDF</button>
                            </div>
                        </div>
                    </template>
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

                </div>
            </template>

            <!-- Message Client Form -->
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
                    <form @submit.prevent="sendMessage" class="mt-4 flex flex-col space-y-3 flex-grow">
                        <!-- Recipient Display -->
                        <div>
                            <label class="text-xs text-gray-400 font-medium">Recipient</label>
                            <input type="text" :value="details.requester"
                                class="w-full border-2 border-gray-400 rounded-xl p-2 text-xs mt-1" readonly>
                            <input type="hidden" :value="details.requester_id" name="recipient_id">
                            <input type="hidden" :value="details.request_id" name="service_request_id">
                            <input type="hidden" :value="details.id" name="ticket_number">
                        </div>

                        <!-- Subject Input -->
                        <div>
                            <label class="text-xs text-gray-400 font-medium">Subject</label>
                            <input type="text" :value="details.subject"
                                class="w-full border-2 border-gray-400 rounded-xl p-2 text-xs mt-1" name="subject"
                                readonly>
                        </div>

                        <!-- Message Textarea -->
                        <div class="flex-grow">
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

            window.location.href = `{{ route('completed') }}?${query.toString()}`;
        }

        document.getElementById('from-date').addEventListener('change', updateFilters);
        document.getElementById('to-date').addEventListener('change', updateFilters);
        document.getElementById('technician-select')?.addEventListener('change', updateFilters);
        document.getElementById('station-select')?.addEventListener('change', updateFilters);

        document.addEventListener("alpine:init", () => {
            Alpine.data("tableData", () => ({
                selectedStatus: "completed",
                currentPage: 1,
                perPage: 9,
                sortKey: '',
                sortAsc: true,



                data: [
                    @foreach ($requests as $completedRequest)
                        {
                            id: '{{ optional($completedRequest->ticket)->ticket_full ?? 'N/A' }}',
                            subject: '{{ $completedRequest->request_title }}',
                            description: '{{ $completedRequest->request_description }}',
                            category: '{{ $completedRequest->category->category_name }}',
                            office: '{{ $completedRequest->location }}',
                            status: '{{ $completedRequest->statusLabel }}',
                            statusFilter: '{{ $completedRequest->status_abbr === 'EVL' ? 'Evaluated' : ($completedRequest->is_others ? 'Others' : 'Completed') }}',
                            date_requested: '{{ \Carbon\Carbon::parse($completedRequest->created_at)->format('M-d-Y h:i A') }}',
                            date_updated: '{{ \Carbon\Carbon::parse($completedRequest->updated_at)->format('M-d-Y') }}',
                            date_completion: 'N/A',
                            contact: '{{ $completedRequest->local_no }}',
                            requester: '{{ optional($completedRequest->requester)->name ?? 'Unknown User' }}',
                            requester_id: {{ optional($completedRequest->requester)->id ?? 'null' }},
                            request_id: {{ $completedRequest->id }},
                            actual_client: 'N/A',
                            rating: '{{ $completedRequest->rating ?? 'N/A' }}',
                            // Add these new fields
                            problem_name: '{{$completedRequest->problem_name}}',
                            action_name: '{{$completedRequest->action_name}}',

                            remarks: '{{ addslashes(App\Models\RequestStatusHistory::latestForStatus(
                                $completedRequest->id,
                                $completedRequest->is_others ?
                                    ($completedRequest->status_abbr === 'DND' ? 'denied' :
                                    ($completedRequest->status_abbr === 'CCL' ? 'cancelled' : 'completed')) :
                                    'completed'
                            )?->remarks ?? 'None') }}'
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ],


                // Computed: Get filtered, sorted, and paginated data
                // Computed: Get filtered, sorted, and paginated data
                get paginatedData() {
                    let filteredData = this.data.filter(item => {
                        if (this.selectedStatus === "completed") {
                            return item.statusFilter === "Completed";
                        } else if (this.selectedStatus === "evaluated") {
                            return item.statusFilter === "Evaluated";
                        } else {
                            return item.statusFilter === "Others";
                        }
                    });




                    if (this.sortKey) {
                        filteredData.sort((a, b) => {
                            let valA = a[this.sortKey];
                            let valB = b[this.sortKey];

                            if (this.sortKey.includes("date")) {
                                valA = new Date(valA);
                                valB = new Date(valB);
                            } else {
                                valA = valA.toString().toLowerCase();
                                valB = valB.toString().toLowerCase();
                            }

                            if (valA < valB) return this.sortAsc ? -1 : 1;
                            if (valA > valB) return this.sortAsc ? 1 : -1;
                            return 0;
                        });
                    }

                    let start = (this.currentPage - 1) * this.perPage;
                    let end = start + this.perPage;
                    return filteredData.slice(start, end);
                },



                // Computed: Total pages based on filtered data
                totalPages() {
                    return Math.ceil(this.data.filter(item => {
                        if (this.selectedStatus === "completed") {
                            return item.statusFilter === "Completed";
                        } else if (this.selectedStatus === "evaluated") {
                            return item.statusFilter === "Evaluated";
                        } else {
                            return item.statusFilter === "Others";
                        }
                    }).length / this.perPage);

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

        function sendMessage(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            fetch('{{ route('completed.message.send') }}', {
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

        let sortDirection = true;

        function sortTable(column) {
            const tableBody = document.getElementById('completed-table-body');
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-layout>
