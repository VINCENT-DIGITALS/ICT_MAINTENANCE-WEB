<x-layout>
    <div
        class="title flex flex-col sm:flex-row items-start sm:items-center justify-between xl:w-[64%] lg:w-[67%] md:w-full mb-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-2 mb-2 sm:mb-0 xl:w-[30%] lg:w-[50%] md:w-full">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Picked Requests</h2>
        </div>

        <!-- Search Bar -->
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto pl-2 font-roboto-text">
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
                   class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] xl:w-[31.5%] lg:w-[93%]  rounded-md focus:ring focus:ring-green-500">
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
    <!-- WRAPPER WITH FLEXIBLE WIDTHS -->
    <!-- WRAPPER WITH FIXED WIDTHS -->
    <div x-data="{
        details: null, // ✅ Move details here so both table and side panel can access it
        get paginatedData() {
            let start = (this.currentPage - 1) * this.perPage;
            let end = start + this.perPage;
            return this.data.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.data.length / this.perPage);
        }
    }" class="flex flex-col lg:flex-row gap-4 mt-3 h-auto lg:h-[600px] w-full">
        <!-- TABLE SECTION -->
        <div class="bg-white shadow-md rounded-lg p-4 w-full lg:w-[65%] xl:w-[64%] flex flex-col h-auto lg:h-[590px] xl:h-[780px] overflow-hidden font-roboto-text"
            x-data="tableData" x-init="$watch('currentPage', () => { paginatedData })">
            <!-- Filters -->
            <div class="flex flex-wrap items-center justify-between gap-2 p-2 rounded-lg">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-500 text-xs font-medium">FROM</span>
                    <input type="text" id="from-date" placeholder="Select date" value="{{ request('from_date') }}"
                        class="flatpickr border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    <span class="text-gray-500 text-xs font-medium">TO</span>
                    <input type="text" id="to-date" placeholder="Select date" value="{{ request('to_date') }}"
                        class="flatpickr border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                </div>
                <div class="flex flex-wrap items-center gap-2">
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
            </div>

            <!-- Table -->
            <div class="overflow-auto flex-grow">
                <table class="w-full mt-2 lg:text-xs xl:text-sm text-left table-fixed">
                    <thead class="border-b border-t border-gray-400">
                        <tr>
                            <th class="py-2 w-[5%]">No.
                                <button @click="sortTable('id')"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="gray" class="size-3">
                                        <path fill-rule="evenodd"
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </th>
                            <th class="py-2 w-[18%]">Service Category
                                <button @click="sortTable('category')"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="gray" class="size-3">
                                        <path fill-rule="evenodd"
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </th>
                            <th class="py-2 w-[15%]">Date Requested
                                <button @click="sortTable('date_requested')"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="gray" class="size-3">
                                        <path fill-rule="evenodd"
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </th>
                            <th class="py-2 w-[25%]">Subject
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
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1-1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in paginatedData" :key="index">
                            <tr class="border-b hover:bg-gray-100 border-gray-400 cursor-pointer text-left"
                                @click="details = { ...item }">
                                <td class="py-4" x-text="item.id"></td>
                                <td class="py-4" x-text="item.category"></td>
                                <td class="py-4">
                                    <span x-text="item.date_requested"></span><br>
                                    <span x-text="item.time_requested"></span>
                                </td>
                                <td class="py-4 truncate max-w-[150px] overflow-hidden" x-text="item.subject"></td>
                                <td class="py-4 flex justify-center">
                                    <img src="https://via.placeholder.com/30" alt="Technician"
                                        class="w-6 h-6 rounded-full">
                                </td>
                                <td class="py-4 font-bold">Picked</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Footer with Entry Count & Pagination -->
            @include('ICT Main.entries')
        </div>

        <!-- SIDE PANEL -->
        <div x-show="details"
            class="w-full lg:w-[35%] bg-white shadow-lg rounded-lg p-4 h-auto lg:h-[590px] xl:h-[780px] font-roboto-text"
            x-cloak>
            <div x-data="{ showEquipmentInfo: false }">
                <template x-if="details && !showEquipmentInfo">
                    <div class="flex flex-col  justify-between xl:h-[750px]">
                        <div class="space-y-3">
                            <!-- HEADER -->
                            <div>
                                <div class="flex justify-between items-center border-b pb-2">
                                    <h2 class="font-bold text-lg" x-text="details.id"></h2>
                                    <button @click="details = null" class="text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex flex-row items-center space-x-2">
                                    <p class="py-2 text-xs">
                                        <strong>Status:</strong> <span class="font-bold text-green-600"
                                            x-text="details.status"></span> by
                                    </p>
                                    <img src="https://via.placeholder.com/30" alt="Technician"
                                        class="w-6 h-6 rounded-full">
                                </div>
                                <p class="text-xs text-gray-400">Date updated: <span
                                        x-text="details.date_updated"></span>
                                </p>
                            </div>

                            <!-- SUBJECT -->
                            <div class="bg-gray-100 p-3 mt-1 rounded">
                                <p class="text-xs"><strong>Subject:</strong> <span class="font-bold"
                                        x-text="details.subject"></span></p>
                                <p class="text-xs text-gray-500">Description: <span class="text-xs"
                                        x-text="details.description"></span></p>
                            </div>

                            <!-- DATE REQUESTED & COMPLETION -->
                            <div class="mt-2 text-sm">
                                <p class="text-xs text-gray-400">Date Requested: <span
                                        x-text="details.date_requested"></span>
                                    <span x-text="details.time_requested"></span>
                                </p>
                                <p class="text-xs text-gray-400">Requested Date of Completion: <span
                                        x-text="details.date_completion"></span></p>
                            </div>

                            <div class="mt-3 text-sm">
                                <p class="text-xs text-gray-400">Location: <span x-text="details.office"></span></p>
                                <p class="text-xs text-gray-400">Contact details: <span
                                        x-text="details.contact"></span>
                                </p>
                            </div>

                            <div class="mt-3 ">
                                <p class="text-[12px] text-gray-400">Service Category: </p>
                                <div
                                    class="border border-gray-300 text-gray-700 text-xs px-3 py-1.5 h-[30px] w-full rounded-md focus:ring focus:ring-green-500 flex items-center">
                                    <span
                                        x-text="details.category ? details.category : 'No Category available'"></span>
                                </div>
                            </div>

                            <div class="mt-3 ">
                                <p class="text-[12px] text-gray-400">Subcategory: </p>
                                <div
                                    class="border border-gray-300 text-gray-700 text-xs px-3 py-1.5 h-[30px] w-full rounded-md focus:ring focus:ring-green-500 flex items-center">
                                    <span
                                        x-text="details.subcategory ? details.subcategory : 'No subcategory available'"></span>
                                </div>
                            </div>

                            <div class="mt-4 space-y-4">
                                <!-- Requester -->
                                <div class="flex items-center space-x-3">
                                    <img src="https://via.placeholder.com/50" alt=""
                                        class="w-12 h-12 rounded-full bg-gray-400">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-600">Requester:</p>
                                        <p class="text-xs font-medium text-gray-900" x-text="details.requester"></p>
                                    </div>
                                </div>

                                <!-- Actual Client -->
                                <div class="flex items-center space-x-3">
                                    <img src="https://via.placeholder.com/50" alt=""
                                        class="w-12 h-12 rounded-full bg-gray-400">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-600">Actual Client:</p>
                                        <p class="text-xs font-medium text-gray-900" x-text="details.actual_client">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="flex flex-col space-y-2 justify-self-end">
                            <div class="text-right">
                                <a href="#" @click.prevent="showEquipmentInfo = true"
                                    class="text-green-600 text-[9px] font-semibold hover:underline">View Equipment
                                    Info</a>
                            </div>
                            <button
                                class="bg-[#45CF7F] text-[#007A33] px-4 py-1 rounded-md w-full text-xs font-semibold">VIEW
                                PDF</button>
                            <button class="bg-[#007A33] text-white px-4 py-1 rounded-md w-full text-xs font-semibold"
                                id="pickServiceBtn" :data-id="details.serviceRequestID">PICK
                                SERVICE</button>
                        </div>
                    </div>
                </template>
                <template x-if="showEquipmentInfo">
                    <div class="flex flex-col h-full">
                        <!-- MAIN HEADER -->
                        <div class="flex justify-between items-center border-b pb-2">
                            <h2 class="font-bold text-lg" x-text="details.id"></h2>
                            <button @click="showEquipmentInfo = false" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- HEADER WITH BACK BUTTON -->
                        <div class="flex items-center space-x-2 mt-3">
                            <button @click="showEquipmentInfo = false"
                                class="text-green-600 text-sm font-semibold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <h2 class="font-bold text-lg">Equipment Info</h2>
                        </div>

                        <!-- EQUIPMENT DETAILS -->
                        <div class="mt-4 text-gray-700">
                            <p class="text-xs text-[#707070]">Serial Number: ################</p>
                            <p class="text-xs text-[#707070]">Accountable: Luis Alejandre Tamani</p>
                            <p class="text-xs text-[#707070]">Division: Information Systems Division</p>
                            <p class="text-xs text-[#707070]">Date Acquired: January 5, 2019</p>
                        </div>

                        <!-- ITEM DESCRIPTION -->
                        <div class="mt-4">
                            <p class="text-xs text-[#707070]">Item Description:</p>
                            <p class="text-xs text-black leading-tight">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy euismod tempor
                                incididunt ut labore et dolore magna aliquam erat, sed diam voluptua. At vero eos et
                                accusam et...
                            </p>
                        </div>

                        <!-- SERVICE HISTORY -->
                        <div class="mt-6">
                            <h3 class="font-bold text-lg">Service History</h3>
                            <div class="mt-2">
                                <p class="text-xs font-bold"><span x-text="details.id"></span> Computer Repair</p>
                                <p class="text-xs text-[#707070]">
                                    Request Date: February 15, 2025, 10:30 AM<br>
                                    Completion Date: February 18, 2025, 2:45 PM<br>
                                    Technician: Ranniel Lauriga
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Define today's date first
            const today = new Date();

            // Initialize flatpickr
            const fromDatePicker = flatpickr("#from-date", {
                maxDate: today,
                altInput: true, // Use alternative input to display the formatted date
                altFormat: "F j Y", // Format for the visible input (e.g., "April 12 2025")
                dateFormat: "Y-m-d", // Format for the actual value (for the backend)
                onChange: function(selectedDates, dateStr) {
                    if (toDatePicker && selectedDates.length > 0) {
                        // Update to-date min when from-date changes
                        toDatePicker.set('minDate', dateStr);
                    }
                    // Trigger filter update
                    updateFilters();
                }
            });

            // Initialize to-date picker
            const toDatePicker = flatpickr("#to-date", {
                maxDate: today,
                altInput: true, // Use alternative input to display the formatted date
                altFormat: "F j Y", // Format for the visible input (e.g., "April 12 2025")
                dateFormat: "Y-m-d", // Format for the actual value (for the backend)
                onChange: function(selectedDates, dateStr) {
                    if (fromDatePicker && selectedDates.length > 0) {
                        // Update from-date max when to-date changes
                        fromDatePicker.set('maxDate', dateStr);
                    } else {
                        // Reset to today if no date is selected
                        fromDatePicker.set('maxDate', today);
                    }
                    // Trigger filter update
                    updateFilters();
                }
            });

            // Set initial min/max dates for the pickers
            if (fromDatePicker && toDatePicker) {
                const fromDateValue = document.getElementById('from-date').value;
                const toDateValue = document.getElementById('to-date').value;

                if (fromDateValue) {
                    toDatePicker.set('minDate', fromDateValue);
                }

                if (toDateValue) {
                    fromDatePicker.set('maxDate', toDateValue);
                } else {
                    fromDatePicker.set('maxDate', today);
                }
            }

            // Remove duplicate event listeners since Flatpickr handles the changes
            document.getElementById('technician-select')?.addEventListener('change', updateFilters);
            document.getElementById('station-select')?.addEventListener('change', updateFilters);
        });

        // Keep updateFilters function as is
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

            // Preserve search parameter if it exists
            const searchParam = new URLSearchParams(window.location.search).get('search');
            if (searchParam) query.append('search', searchParam);

            window.location.href = `{{ route('picked') }}?${query.toString()}`;
        }

        // Remove these event listeners as they conflict with Flatpickr
        // document.getElementById('from-date').addEventListener('change', updateFilters);
        // document.getElementById('to-date').addEventListener('change', updateFilters);

        document.getElementById('technician-select')?.addEventListener('change', updateFilters);
        document.getElementById('station-select')?.addEventListener('change', updateFilters);
        document.addEventListener("alpine:init", () => {
            Alpine.data("tableData", () => ({
                selectedStatus: "picked",
                currentPage: 1,
                perPage: 7,
                sortKey: '',
                sortAsc: true,

                data: [
                    @foreach ($pickedRequests as $pickedRequest)
                        {
                            serviceRequestID: '{{ $pickedRequest->id }}',
                            id: '{{ optional($pickedRequest->ticket)->ticket_full ?? 'N/A' }}',
                            subject: '{{ $pickedRequest->request_title }}',
                            description: '{{ $pickedRequest->request_description }}',
                            category: '{{ $pickedRequest->category->category_name }}',
                            subcategory: '{{ $pickedRequest->subcategory ? $pickedRequest->subcategory->sub_category_name : 'No Subcategory' }}',
                            office: '{{ $pickedRequest->location }}',
                            status: '{{ $pickedRequest->latestStatus?->status?->status_name ?? 'Picked' }}',
                            date_requested: '{{ \Carbon\Carbon::parse($pickedRequest->created_at)->format('M-d-Y h:i A') }}',
                            date_updated: '{{ \Carbon\Carbon::parse($pickedRequest->updated_at)->format('M-d-Y') }}',
                            date_completion: 'N/A',
                            contact: '{{ $pickedRequest->local_no }}',
                            requester: '{{ optional(\App\Models\User::where('philrice_id', $pickedRequest->requester_id)->first())->name ?? $pickedRequest->requester_id }}',

                            actual_client: 'N/A'
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ],

                get paginatedData() {
                    // Filtered by status
                    let filteredData = this.data.filter(item =>
                        this.selectedStatus === "picked" ? item.status === "Picked" : item
                        .status === "Paused"
                    );

                    // Sort
                    if (this.sortKey) {
                        filteredData.sort((a, b) => {
                            let valA = a[this.sortKey];
                            let valB = b[this.sortKey];

                            // Convert to date if sorting a date field
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

                    // Paginate
                    let start = (this.currentPage - 1) * this.perPage;
                    let end = start + this.perPage;
                    return filteredData.slice(start, end);
                },

                totalPages() {
                    return Math.ceil(this.data.filter(item =>
                        this.selectedStatus === 'picked' ? item.status === 'Picked' : item
                        .status === 'Paused'
                    ).length / this.perPage);
                },

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

                changeStatus(status) {
                    this.selectedStatus = status;
                    this.currentPage = 1;
                },

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

        $(document).on('click', '#pickServiceBtn', function() {
            const requestId = $(this).data('id');

            // Show confirmation dialog with SweetAlert
            Swal.fire({
                title: 'Confirm',
                text: "Are you sure you want to change this request to Ongoing?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007A33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    $.ajax({
                        url: `/ServiceTrackerGithub/picked/changeToOngoing/${requestId}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#007A33'
                            }).then(() => {
                                // Reload the page after clicking OK
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            // Show error message using SweetAlert
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update request. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#007A33'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</x-layout>
