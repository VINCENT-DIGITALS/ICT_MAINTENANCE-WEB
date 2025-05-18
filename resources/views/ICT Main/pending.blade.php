<x-layout>
    <head>
        <!-- ...existing head content... -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <!-- TITLE -->
    <div class="title flex flex-col sm:flex-row items-start sm:items-center justify-between lg:w-[64%] md:w-full mb-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-2 mb-2 sm:mb-0">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Pending Requests</h2>
        </div>

        <!-- Search Bar -->
        <div class="relative text-xs w-full sm:w-auto font-roboto-text">
            <input type="text" id="search-input" placeholder="SEARCH"
                class="pr-10 pl-4 py-2 w-full sm:w-80 h-7 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#007A33] focus:outline-none"
                value="{{ request('search') }}">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
            </svg>
        </div>

    </div>

    <!-- WRAPPER WITH FLEXIBLE WIDTHS -->
    <div x-data="{
        details: null,
        get paginatedData() {
            let start = (this.currentPage - 1) * this.perPage;
            let end = start + this.perPage;
            return this.data.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.data.length / this.perPage);
        }
    }"
        class="flex flex-col lg:flex-row gap-3 mt-3 mb-3 h-auto lg:h-[550px] xl:h-[600px] w-full">
        <!-- TABLE SECTION -->
        <div class="bg-white shadow-md rounded-lg p-4 w-full xl:w-[64%] lg:w-[60%] flex flex-col h-auto lg:h-[590px] xl:h-[780px] overflow-hidden"
            x-data="tableHandler()" x-init="init()">

            <!-- Filters -->
            <div class="flex flex-wrap items-center justify-between gap-2 p-2 rounded-lg font-roboto-text">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-500 text-xs font-medium">FROM</span>
                    <input type="text" id="from-date" placeholder="Select date" value="{{ request('from_date') }}"
                        class="flatpickr border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    <span class="text-gray-500 text-xs font-medium">TO</span>
                    <input type="text" id="to-date" placeholder="Select date" value="{{ request('to_date') }}"
                        class="flatpickr border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
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


            <!-- Table -->
            <div class="overflow-auto flex-grow">
                <table class="w-full mt-2 lg:text-xs xl:text-sm text-left table-fixed">
                    <thead class="border-b border-t border-gray-400">
                        <tr class="font-roboto-text">
                            <th class="py-2 w-[5%]">No.
                                <button @click="sortTable('id')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                                        class="size-3">
                                        <path fill-rule="evenodd"
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </th>
                            <th class="py-2 w-[18%]">Service Category
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
                            <th class="py-2 w-[25%]">Subject
                                <button @click="sortTable('subject')"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="gray" class="size-3">
                                        <path fill-rule="evenodd"
                                            d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </th>
                            <th class="py-2 w-[15%]">Office
                                <button @click="sortTable('office')"><svg xmlns="http://www.w3.org/2000/svg"
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
                        </tr>
                    </thead>
                    <tbody id="pending-table-body">
                        <template x-for="(item, index) in paginatedData" :key="index">
                            <tr class="border-b border-gray-400 hover:bg-gray-100 cursor-pointer text-left font-roboto-text"
                                @click="details = { ...item }">
                                <td class="py-4" x-text="item.id"></td>
                                <td class="py-4" x-text="item.category"></td>
                                <td class="py-4">
                                    <span x-text="item.date_requested"></span><br>
                                    <span x-text="item.time_requested"></span>
                                </td>
                                <td class="py-4 truncate max-w-[150px] overflow-hidden" x-text="item.subject"></td>
                                <td class="py-4" x-text="item.office"></td>
                                <td class="py-4 font-bold">Pending</td>
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
            class="w-full lg:w-[35%] bg-white shadow-lg rounded-lg p-4 h-auto lg:h-[590px] xl:h-[780px]" x-cloak>
            <div x-data="{ showEquipmentInfo: false }">
                <template x-if="details && !showEquipmentInfo">
                    <div class="flex flex-col justify-between space-y-1 xl:h-[750px]">
                        <!-- HEADER -->
                        <div class="font-roboto-text">
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
                            <!-- STATUS & DATE UPDATED -->
                            <p class="py-2 text-xs">Status: <span class="font-bold text-black-600"
                                    x-text="details.status"></span></p>

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
                                        x-text="details.date_requested">
                                    </span><span x-text="details.time_requested"></p>
                                <p class="text-xs text-gray-400">Requested Date of Completion: <span
                                        x-text="details.date_completion"></span></p>
                            </div>

                            <div class="mt-1 text-sm">
                                <p class="text-xs text-gray-400">Location: <span x-text="details.office"></span></p>
                                <p class="text-xs text-gray-400">Contact details: <span
                                        x-text="details.contact"></span>
                                </p>
                            </div>

                            <div class="mt-3 ">
                                <p class="text-[12px] text-gray-400">Service Category:</p>
                                <div class="border border-gray-300 text-gray-700 text-xs px-3 py-1.5 h-[30px] w-full rounded-md focus:ring focus:ring-green-500 flex items-center">
                                    <span x-text="details.category ? details.category : 'No Category available'"></span>
                                </div>
                            </div>

                            <div class="mt-3 ">
                                <p class="text-[12px] text-gray-400">Subcategory: </p>
                                <div class="border border-gray-300 text-gray-700 text-xs px-3 py-1.5 h-[30px] w-full rounded-md focus:ring focus:ring-green-500 flex items-center">
                                    <span x-text="details.subcategory ? details.subcategory : 'No subcategory available'"></span>
                                </div>
                            </div>

                            <div class="mt-4 space-y-4">
                                <!-- Requester -->
                                <div class="flex items-center space-x-3">
                                    <img src="https://via.placeholder.com/50" alt=""
                                        class="w-12 h-12 rounded-full bg-gray-400">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-600">Requester:</p>
                                        <p class="text-xs font-medium text-gray-900" x-text="details.requester">
                                        </p>
                                    </div>
                                </div>

                                <!-- Actual Client -->
                                <div class="flex items-center space-x-3">
                                    <img src="https://via.placeholder.com/50" alt=""
                                        class="w-12 h-12 rounded-full bg-gray-400">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-600">Actual Client:</p>
                                        <p class="text-xs font-medium text-gray-900"
                                            x-text="details.actual_client"></p>
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

            window.location.href = `{{ route('pending') }}?${query.toString()}`;
        }

        document.getElementById('technician-select')?.addEventListener('change', updateFilters);
        document.getElementById('station-select')?.addEventListener('change', updateFilters);

        document.addEventListener("alpine:init", () => {
            Alpine.data("tableHandler", () => ({
                sortKey: '',
                sortAsc: true,
                currentPage: 1,
                perPage: getPerPageCount(),
                paginatedData: [],
                data: [
                    @foreach ($pendingRequests as $pendingRequest)
                        {
                            serviceRequestID: '{{ $pendingRequest->id }}',
                            id: '{{ optional($pendingRequest->ticket)->ticket_full ?? 'N/A' }}',
                            subject: `{{ $pendingRequest->request_title }}`,
                            description: `{{ $pendingRequest->request_description }}`,
                            category: `{{ $pendingRequest->category->category_name }}`,
                            subcategory: `{{ optional($pendingRequest->subcategory)->sub_category_name ?? 'N/A' }}`,
                            requester: `{{ optional($pendingRequest->requester)->name ?? 'Unknown' }}`,
                            actual_client: `{{ optional($pendingRequest->endUser)->name ?? 'Same as requester' }}`,
                            office: `{{ $pendingRequest->location }}`,
                            status: '{{ $pendingRequest->latestStatus?->status?->status_name ?? 'Pending' }}',
                            date_requested: '{{ \Carbon\Carbon::parse($pendingRequest->created_at)->format('Y-m-d') }}',
                            time_requested: '{{ \Carbon\Carbon::parse($pendingRequest->created_at)->format('h:i A') }}',
                            date_completion: '{{ $pendingRequest->request_completion ? \Carbon\Carbon::parse($pendingRequest->request_completion)->format('Y-m-d') : 'Not specified' }}',
                            contact: '{{ $pendingRequest->local_no ?? 'Not provided' }}'
                        },
                    @endforeach
                ],

                get totalData() {
                    return this.data;
                },

                init() {
                    this.updatePaginatedData();
                },

                sortTable(key) {
                    if (this.sortKey === key) {
                        this.sortAsc = !this.sortAsc;
                    } else {
                        this.sortKey = key;
                        this.sortAsc = true;
                    }

                    this.data.sort((a, b) => {
                        let valA = a[key];
                        let valB = b[key];

                        if (key === 'date_requested') {
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

                    this.currentPage = 1;
                    this.updatePaginatedData();
                },

                updatePaginatedData() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    this.paginatedData = this.data.slice(start, end);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.updatePaginatedData();
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.updatePaginatedData();
                    }
                },

                totalPages() {
                    return Math.ceil(this.data.length / this.perPage);
                },

                // Add this function for pagination visibility
                visiblePages() {
                    const totalPages = this.totalPages();
                    const current = this.currentPage;
                    const pages = [];

                    // Logic for determining which page buttons to show
                    if (totalPages <= 5) {
                        // Show all pages if total pages are 5 or less
                        for (let i = 1; i <= totalPages; i++) {
                            pages.push(i);
                        }
                    } else {
                        // Always include first page
                        pages.push(1);

                        // Calculate start and end of middle pages
                        let startPage = Math.max(2, current - 1);
                        let endPage = Math.min(totalPages - 1, current + 1);

                        // Adjust if current page is near the beginning
                        if (current <= 3) {
                            endPage = 4;
                        }

                        // Adjust if current page is near the end
                        if (current >= totalPages - 2) {
                            startPage = totalPages - 3;
                        }

                        // Add ellipsis after first page if needed
                        if (startPage > 2) {
                            pages.push('...');
                        }

                        // Add middle pages
                        for (let i = startPage; i <= endPage; i++) {
                            pages.push(i);
                        }

                        // Add ellipsis before last page if needed
                        if (endPage < totalPages - 1) {
                            pages.push('...');
                        }

                        // Always include last page
                        pages.push(totalPages);
                    }

                    return pages;
                }
            }));

            function getPerPageCount() {
                const width = window.innerWidth;
                if (width < 640) { // mobile
                    return 5;
                } else if (width < 1024) { // tablet
                    return 6;
                } else if (width < 1280) { // laptop/lg screens
                    return 7; // As per your requirement for lg screens
                } else { // xl screens and larger
                    return 9; // As per your requirement for xl screens
                }
            }
        });
    </script>
</x-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define today's date
        const today = new Date();

        // Initialize flatpickr for both date inputs
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

        // Set initial min/max dates for the pickers once they're both initialized
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

        // Make sure the flatpickr library is loaded
        if (!window.flatpickr) {
            console.error('Flatpickr library is not loaded. Please include it in your page.');

            // Add Flatpickr CSS and JS dynamically if not already loaded
            if (!document.querySelector('link[href*="flatpickr.min.css"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
                document.head.appendChild(link);
            }

            if (!window.flatpickr) {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
                script.onload = function() {
                    // Reinitialize the date pickers once the script is loaded
                    initializeDatePickers();
                };
                document.head.appendChild(script);
            }
        }
    });

    // Define updateFilters function if it's not already defined elsewhere
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

        window.location.href = window.location.pathname + '?' + query.toString();
    }

    // Update only for the select elements since date inputs are now handled by flatpickr
    document.getElementById('technician-select')?.addEventListener('change', updateFilters);
    document.getElementById('station-select')?.addEventListener('change', updateFilters);

    $(document).on('click', '#pickServiceBtn', function() {
        const requestId = $(this).data('id');

        // Show confirmation dialog
        Swal.fire({
            title: 'Confirm',
            text: "Are you sure you want to pick this service request?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007A33',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, pick it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request
                $.ajax({
                    url: `/ServiceTrackerGithub/pending/changeToPicked/${requestId}`,
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
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to pick service request. Please try again.',
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
