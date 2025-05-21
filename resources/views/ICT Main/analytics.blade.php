<x-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Add Flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   <!-- Add PDF export libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="flex flex-col sm:flex-row w-full justify-between font-roboto-text">
        <div class="flex items-center mb-3 sm:mb-0">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Analytics</h2>
        </div>

        <div class="flex flex-wrap items-center gap-2 bg-[#F5F7FA] p-2 rounded-lg">
            <!-- FROM Label -->
            <span class="text-gray-500 text-xs font-medium">FROM</span>

            <!-- From Date Picker with Reset Button -->
            <div class="relative">
                <input type="text" id="from-date" name="from_date" placeholder="Select date"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500 flatpickr-date pr-8">
                <button type="button" id="reset-from-date" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- TO Label -->
            <span class="text-gray-500 text-xs font-medium">TO</span>

            <!-- To Date Picker with Reset Button -->
            <div class="relative">
                <input type="text" id="to-date" name="to_date" placeholder="Select date"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500 flatpickr-date pr-8">
                <button type="button" id="reset-to-date" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- All SERVICE CATEGORY Dropdown -->
            <select id="category-filter"
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                <option value="">ALL SERVICE CATEGORY</option>
                @foreach ($categories as $id => $category)
                    <option value="{{ $id }}">{{ $category }}</option>
                @endforeach
            </select>

            <!-- PHILRICE CES Dropdown -->
            <select id="location-filter"
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500"
                onchange="refreshAnalyticsData()">
                <option value="PHILRICE CES">PHILRICE CES</option>
            </select>

            <!-- ALL TECHNICIANS Dropdown -->
            @if (Auth::check() &&
                    Auth::user()->role_id == DB::table('lib_roles')->where('role_name', 'Super Administrator')->value('id'))
                <!-- ALL TECHNICIANS Dropdown (Visible Only for Super Admin) -->
                <select id="technician-filter"
                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    <option value="">ALL TECHNICIANS</option>
                    @foreach ($technicians as $technician)
                        <option value="{{ $technician->philrice_id }}">{{ $technician->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    @php
        $pendingCount = $pendingRequestsCount;
        $pickedCount = $pickedRequestsCount;
        $ongoingCount = $ongoingRequestsCount;
        $completedCount = $completedRequestsCount;
        $totalRequests = $pendingCount + $pickedCount + $ongoingCount + $completedCount;

        // Avoid division by zero
        $completedPercentage = $totalRequests > 0 ? ($completedCount / $totalRequests) * 100 : 0;
        $ongoingPercentage = $totalRequests > 0 ? ($ongoingCount / $totalRequests) * 100 : 0;
        $pickedPercentage = $totalRequests > 0 ? ($pickedCount / $totalRequests) * 100 : 0;
        $pendingPercentage = $totalRequests > 0 ? ($pendingCount / $totalRequests) * 100 : 0;
    @endphp
    <div class="pt-1 pb-7 flex flex-col lg:flex-row gap-4 font-roboto-text ">
        <!-- Service Request Counter -->
        <div class="flex flex-col space-y-3 w-full lg:w-[49%]">
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 w-full h-auto lg:h-[550px]">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-0">
                    <h2 class="text-xl font-bold mb-2 sm:mb-0">Service Request Counter</h2>
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="text-[10px] text-gray-500 text-right">
                            <p>January 1, 2025 to February 28, 2025</p>
                            <p class="text-gray-400">All Service Category | PhilRice CES</p>
                        </div>

                        <div class="bg-gray-400 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="pl-0 sm:pl-2">
                            <button
                                class="flex justify-center bg-green-700 text-xs text-center text-white py-1 rounded-lg w-[30px] ">
                                <svg width="12px" height="19px" viewBox="0 0 14 19"
                                    xmlns="http://www.w3.org/2000/svg" fill="white">
                                    <g transform="translate(0,0.5)">
                                        <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="chart-container" class="h-[350px] md:h-[370px] lg:h-[440px] w-full overflow-hidden">
                    <canvas id="serviceRequestChart"></canvas>
                </div>
            </div>

            {{-- AVERAGE TURN AROUND TIME --}}
            <div
                class="bg-white shadow rounded-lg w-full h-auto py-4 lg:h-[100px] flex flex-col lg:flex-row items-center justify-between px-4 lg:px-5">
                <!-- Left Section -->
                <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                    <div>
                        <h2 class="text-lg font-bold">Average Turnaround Time</h2>
                        <div class="flex items-center space-x-2 text-gray-500 text-xs">
                            <!-- Gray Circle -->
                            <div class="bg-gray-400 rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex flex-col text-[10px]">
                                <p>January 1, 2025 to February 28, 2025</p>
                                <span class="text-gray-400">All Service Category | PhilRice CES</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $averageTurnaroundTimeFormatted }}</h3>
                    <!-- Download Button -->
                    <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-lg">
                        <svg width="18px" height="18px" viewBox="0 0 14 19" xmlns="http://www.w3.org/2000/svg"
                            fill="white">
                            <g transform="translate(0,0.5)">
                                <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                            </g>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BAR CHART PER DIVISION --}}
            <div class="bg-white shadow rounded-lg w-full p-3 sm:p-4 h-auto lg:h-[550px] xl:h-[540px] ">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-0">
                    <h2 class="text-xl font-bold mb-2 sm:mb-0">Service Requests by Office (Top 10)</h2>

                    <div class="flex flex-wrap items-center gap-2">
                        <div class="text-[10px] text-gray-500 text-right">
                            <p>January 1, 2025 to February 28, 2025</p>
                            <p class="text-gray-400">All Service Category | PhilRice CES</p>
                        </div>

                        <div class="bg-gray-400 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-lg">
                            <svg width="16px" height="16px" viewBox="0 0 14 19" xmlns="http://www.w3.org/2000/svg"
                                fill="white">
                                <g transform="translate(0,0.5)">
                                    <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="mt-3 h-[350px] md:h-[400px] lg:h-[450px] w-full overflow-auto">
                    <canvas id="serviceRequestsBar"></canvas>
                </div>
            </div>
        </div>

        {{-- technician findings and summary chart --}}
        <div class="flex flex-col space-y-3 w-full lg:w-[49%] mb-2">
            <!-- Technician Findings Overview -->
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 xl:p-3 relative h-auto lg:h-[290px] overflow-hidden">
                <!-- Title -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-0">
                    <h2 class="text-lg font-bold mb-2 sm:mb-0">Technician Findings Overview</h2>
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="text-[10px] text-gray-500 text-right">
                            <p>January 1, 2025 to February 28, 2025</p>
                            <p class="text-gray-400">Computer Related Services</p>
                        </div>
                        <div class="bg-gray-400 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="pl-0 sm:pl-2">
                            <button
                                class="flex justify-center bg-green-700 text-xs text-center text-white py-1 rounded-lg w-[30px] ">
                                <svg width="12px" height="19px" viewBox="0 0 14 19"
                                    xmlns="http://www.w3.org/2000/svg" fill="white">
                                    <g transform="translate(0,0.5)">
                                        <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Two-Column Layout -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-xs overflow-y-auto max-h-[200px]">
                    <!-- Most Common Problems Encountered -->
                    <div>
                        <h3 class="mb-2 xl:text-lg"><strong>Most Common Problems Encountered</strong></h3>
                        <ul class="space-y-2">
                            @forelse($duplicateProblemsCollection->take(7) as $problem)
                                <li class="flex justify-between">
                                    <span>{{ $problem->encountered_problem_name }}</span>
                                    <span>{{ $problem->duplicate_count }}</span>
                                </li>
                            @empty
                                <li class="flex justify-between">
                                    <span>No duplicate problems found</span>
                                    <span>0</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Actions Taken -->
                    <div>
                        <h3 class="mb-2 xl:text-lg"><strong>Actions Taken</strong></h3>
                        <ul class="space-y-2">
                            @forelse($actionsData as $action)
                                <li class="flex justify-between">
                                    <span>{{ $action->action_name }}</span>
                                    <span class="font-medium">{{ $action->action_count }}</span>
                                </li>
                            @empty
                                <li class="flex justify-between">
                                    <span>No actions data available</span>
                                    <span class="font-bold">0</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Summary -->
            <div class="bg-white shadow rounded-lg p-3 sm:p-4">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-0">
                    <!-- Left Section: Title -->
                    <h2 class="text-lg font-bold mb-2 sm:mb-0">Summary</h2>

                    <!-- Right Section: Date, Gray Circle, Download Button -->
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="text-[10px] text-gray-500 text-right">
                            <p>January 1, 5 to February 28, 2025</p>
                            <p class="text-gray-400">All Service Category | PhilRice CES</p>
                        </div>

                        <!-- Gray Circle -->
                        <div class="bg-gray-400 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Download Button -->
                        <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-full">
                            <svg width="16px" height="16px" viewBox="0 0 14 19"
                                xmlns="http://www.w3.org/2000/svg" fill="white">
                                <g transform="translate(0,0.5)">
                                    <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Main Content (Chart + Total Requests) -->
                <div class="flex flex-col md:flex-row gap-3 h-auto md:h-[288px] mt-2">
                    <!-- Summary Chart Section -->
                    <div class="flex flex-col items-center flex-1 space-y-1">
                        <div class="w-full xl:w-[55%] md:w-[80%] flex justify-center mt-2">
                            <canvas id="summaryChart"></canvas>
                        </div>

                        <div class="flex flex-row justify-around w-full text-xs sm:text-sm">

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

                    <!-- Divider Line for larger screens -->
                    <div class="hidden md:block w-px bg-gray-300"></div>
                    <!-- Horizontal divider for mobile -->
                    <hr class="md:hidden border-gray-300" />

                    <!-- Total Requests Section -->
                    <div class="flex-1 max-h-[200px] md:max-h-[280px] overflow-y-auto pr-1">
                        <h3 class="text-sm font-bold">Total Requests</h3>
                        <p class="text-2xl font-bold mt-1">{{ $totalRequests }}</p>
                        <ul class="mt-2 space-y-1 text-xs">
                            @foreach ($totalServiceRequests->take(7) as $request)
                                <li class="flex justify-between py-1">
                                    <span>{{ $request->category_name }}</span>
                                    <span>{{ $request->request_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg w-full h-auto lg:h-[550px] xl:h-[540px] p-3 sm:p-4 overflow-y-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-0 w-full">
                    <div>
                        <h2 class="text-xl font-bold mb-2 sm:mb-0">Average Resolution Time by Service Category</h2>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="text-[10px] text-gray-500 text-right">
                            <p>January 1, 2025 to February 28, 2025</p>
                            <p class="text-gray-400">All Service Category | PhilRice CES</p>
                        </div>

                        <div class="bg-gray-400 rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-lg">
                            <svg width="16px" height="16px" viewBox="0 0 14 19" xmlns="http://www.w3.org/2000/svg"
                                fill="white">
                                <g transform="translate(0,0.5)">
                                    <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Chart -->
                <div class="mt-2 h-[350px] md:h-[400px] lg:h-[450px] w-full overflow-x-auto">
                    <canvas id="resolutionTimeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Flatpickr with configuration
            const maxDate = new Date();

            // Configure the "from-date" flatpickr
            const fromDatePicker = flatpickr("#from-date", {
                dateFormat: "Y-m-d",
                maxDate: maxDate, // Disables dates from tomorrow onwards
                disableMobile: true,
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    // When a "from" date is selected, update the min date of "to-date" picker
                    if (selectedDates.length > 0) {
                        toDatePicker.set('minDate', dateStr);
                    }
                }
            });

            // Configure the "to-date" flatpickr
            const toDatePicker = flatpickr("#to-date", {
                dateFormat: "Y-m-d",
                maxDate: maxDate,
                disableMobile: true,
                allowInput: true
            });

            // Add reset functionality to date pickers
            document.getElementById('reset-from-date').addEventListener('click', function() {
                fromDatePicker.clear();
                // Also clear the minDate constraint on the to-date picker
                toDatePicker.set('minDate', null);
                // You might want to trigger a data refresh here
            });

            document.getElementById('reset-to-date').addEventListener('click', function() {
                toDatePicker.clear();
                // You might want to trigger a data refresh here
            });

            // Service Request Counter (Line Chart)
            var ctx1 = document.getElementById("serviceRequestChart").getContext("2d");

            // Pass Laravel data to JavaScript
            var datasets = @json($categoryData);

            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                        "Dec"
                    ],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Ensures proportional scaling
                    plugins: {
                        legend: {
                            position: "bottom",
                            align: "start",
                            labels: {
                                padding: 20,
                                boxWidth: 15
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Summary (Doughnut Chart)
            const ctx = document.getElementById("summaryChart").getContext("2d");
            const completedPercentage = {{ $completedPercentage }};
            const ongoingPercentage = {{ $ongoingPercentage }};
            const pickedPercentage = {{ $pickedPercentage }};
            const pendingPercentage = {{ $pendingPercentage }};
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    datasets: [{
                            data: [100 - completedPercentage, completedPercentage], // Outer ring
                            backgroundColor: ["#F3F4F6", "#3B4E57"], // Dark Blue + Light Gray
                            borderWidth: 3,
                            cutout: "35%",
                            borderRadius: 10,
                        },
                        {
                            data: [100 - ongoingPercentage, ongoingPercentage], // Second ring
                            backgroundColor: ["#F3F4F6", "#914D3A"], // Brown + Light Gray
                            borderWidth: 3,
                            cutout: "35%",
                            borderRadius: 10,

                        },
                        {
                            data: [100 - pickedPercentage, pickedPercentage], // Third ring
                            backgroundColor: ["#F3F4F6", "#F4B861"], // Light Brown/Orange + Light Gray
                            borderWidth: 3,
                            cutout: "35%",
                            borderRadius: 10,

                        },
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }, // Hide legend for cleaner look
                    },
                    layout: {
                        padding: 20 // Adjust padding for better spacing
                    }
                }
            });

            const ctx2 = document.getElementById("serviceRequestsBar").getContext("2d");

            // Fetch service requests by office data
            fetch('/ServiceTrackerGithub/analytics/requests-by-office')
                .then(response => response.json())
                .then(data => {
                    new Chart(ctx2, {
                        type: "bar",
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            indexAxis: "y", // Makes it a horizontal bar chart
                            responsive: true,
                            maintainAspectRatio: false,
                            barThickness: 15,
                            scales: {
                                x: {
                                    ticks: {
                                        display: false
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: "#000",
                                        autoSkip: false,
                                        callback: function(value, index) {
                                            // Get the label text
                                            let label = this.getLabelForValue(value);
                                            // Truncate if longer than 20 characters
                                            return label.length > 20 ? label.substring(0, 18) + '...' : label;
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function(tooltipItems) {
                                            // Return full office name in tooltip
                                            return data.labels[tooltipItems[0].dataIndex];
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching office data:', error);

                    // Fallback to dummy data if fetch fails to maintain appearance
                    new Chart(ctx2, {
                        type: "bar",
                        data: {
                            labels: Array(15).fill("1 Division"), // Fallback to dummy labels
                            datasets: [{
                                label: "Requests",
                                data: Array(20).fill(25), // Fallback to dummy data
                                backgroundColor: "#1E293B", // Dark blue color
                            }]
                        },
                        options: {
                            indexAxis: "y",
                            responsive: true,
                            maintainAspectRatio: false,
                            barThickness: 15,
                            scales: {
                                x: {
                                    ticks: {
                                        display: false
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: "#000",
                                        autoSkip: false,
                                        callback: function(value, index) {
                                            let label = this.getLabelForValue(value);
                                            return label.length > 20 ? label.substring(0, 18) + '...' : label;
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                });

            // Convert Blade data to JavaScript variables
            const categories = @json($categories); // Keeps the associative array (id => name)
            const averageTimes = @json($averageTimes); // Keeps average resolution times

            // Extract only category names for the chart labels
            const categoryNames = Object.values(categories);

            // Extract numeric values for the chart (convert time to hours if needed)
            const averageTimeValues = Object.values(averageTimes).map(time => {
                if (typeof time === "string") {
                    const match = time.match(/(\d+)\s*hrs\s*(\d+)?\s*mins?/);
                    if (match) {
                        const hours = parseInt(match[1]) || 0;
                        const minutes = parseInt(match[2]) || 0;
                        return hours + minutes / 60; // Convert to decimal hours
                    }
                    return 0; // Default if parsing fails
                }
                return time; // Already a number
            });

            const ctx3 = document.getElementById("resolutionTimeChart").getContext("2d");

            // Initialize empty chart first (will be updated with data)
            let resolutionTimeChart = new Chart(ctx3, {
                type: "bar",
                data: {
                    labels: [],
                    datasets: [{
                        label: "Average Resolution Time (hrs)",
                        data: [],
                        backgroundColor: "#1E293B",
                    }]
                },
                options: {
                    indexAxis: "y",
                    responsive: true,
                    maintainAspectRatio: false,
                    barThickness: 10,
                    barPercentage: 0.7,
                    categoryPercentage: 0.9,
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value) {
                                    return value + " hrs"; // Display as hours
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        },
                        y: {
                            ticks: {
                                color: "#000",
                                align: "start",
                                callback: function(value, index) {
                                    let label = this.getLabelForValue(value);
                                    return label.length > 20 ? label.substring(0, 20) + "..." : label;
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    // Will be replaced with actual formatted time from API
                                    return `${context.raw} hours`;
                                }
                            }
                        }
                    }
                }
            });

            // Fetch turnaround time data from our new API endpoint
            fetch('/ServiceTrackerGithub/analytics/turnaround-times-by-category')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update chart with the data
                        resolutionTimeChart.data.labels = data.labels;
                        resolutionTimeChart.data.datasets[0].data = data.data;

                        // Update the tooltip callback to use formatted times
                        resolutionTimeChart.options.plugins.tooltip.callbacks.label = function(context) {
                            const index = context.dataIndex;
                            return `Average: ${data.formattedTimes[index]}`;
                        };

                        resolutionTimeChart.update();
                    } else {
                        console.error('Error loading turnaround time data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching turnaround time data:', error);
                });

            // Add responsive adjustments for laptop screens
            function adjustForScreenSize() {
                const width = window.innerWidth;
                const isLaptop = width >= 1024 && width <= 1366;

                if (isLaptop) {
                    // Adjust legend positions and font sizes for laptop screens
                    Chart.defaults.font.size = 10;
                } else {
                    Chart.defaults.font.size = 12;
                }
            }
                    
            // PDF download functionality for all download buttons
            document.querySelectorAll('.flex button svg[viewBox="0 0 14 19"]').forEach(button => {
                const parentButton = button.closest('button');
                if (parentButton) {
                    parentButton.addEventListener('click', function() {
                        // Find the container to capture (parent card of the button)
                        const container = this.closest('.bg-white');
                        if (!container) return;
                        
                        // Get chart title or container data to use in filename
                        let filename = 'analytics_chart';
                        const titleElement = container.querySelector('h2, h3');
                        if (titleElement) {
                            filename = titleElement.textContent.trim().toLowerCase().replace(/\s+/g, '_');
                        }
                        
                        // Determine orientation based on container dimensions
                        const isWide = container.offsetWidth > container.offsetHeight;
                        const orientation = isWide ? 'landscape' : 'portrait';
                        
                        html2canvas(container).then(canvas => {
                            const imgData = canvas.toDataURL('image/png');
                            const pdf = new jspdf.jsPDF({
                                orientation: orientation,
                                unit: 'mm'
                            });
                            
                            const imgWidth = orientation === 'landscape' ? 250 : 170;
                            const imgHeight = canvas.height * imgWidth / canvas.width;
                            
                            pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
                            pdf.save(`${filename}.pdf`);
                        });
                    });
                }
            });

            // Call on load and resize
            adjustForScreenSize();
            window.addEventListener('resize', adjustForScreenSize);

            // Add event listener to technician filter dropdown
            const technicianFilter = document.getElementById('technician-filter');
            if (technicianFilter) {
                technicianFilter.addEventListener('change', function() {
                    updateAverageTurnaroundTime();

                    // Also update the resolution chart by category for this technician
                    updateResolutionTimeChart();
                });
            }

            // Function to update average turnaround time based on selected technician
            function updateAverageTurnaroundTime() {
                const technicianId = technicianFilter ? technicianFilter.value : '';
                const turnaroundTimeDisplay = document.querySelector('.text-3xl.font-bold.text-gray-900');
                const turnaroundTimeSection = turnaroundTimeDisplay.closest('.bg-white');
                const subtitle = turnaroundTimeSection.querySelector('.text-[10px]');

                // Show loading indicator
                turnaroundTimeDisplay.textContent = 'Loading...';

                let endpoint = '/ServiceTrackerGithub/analytics/average-turnaround-time';

                // If technician is selected, use specific endpoint with the technician's ID
                if (technicianId) {
                    endpoint = `/ServiceTrackerGithub/analytics/turnaround-time/${technicianId}`;
                }

                // Fetch turnaround time data
                fetch(endpoint)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Turnaround time data:", data); // Debug output

                            // Update the displayed turnaround time
                            turnaroundTimeDisplay.textContent = data.average_turnaround_time;

                            // Update subtitle for the turnaround section
                            if (technicianId) {
                                // Find technician name from dropdown
                                const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                                const technicianName = selectedOption.textContent;

                                // Update both date and category/technician info
                                const dateInfo = subtitle.querySelector('p:first-child');
                                if (dateInfo) dateInfo.textContent = 'Technician-specific data';

                                const categoryInfo = subtitle.querySelector('span.text-gray-400');
                                if (categoryInfo) categoryInfo.textContent = `Technician: ${technicianName} | PhilRice CES`;
                            } else {
                                // Reset to default display
                                const dateInfo = subtitle.querySelector('p:first-child');
                                if (dateInfo) dateInfo.textContent = 'January 1, 2025 to February 28, 2025';

                                const categoryInfo = subtitle.querySelector('span.text-gray-400');
                                if (categoryInfo) categoryInfo.textContent = 'All Service Category | PhilRice CES';
                            }
                        } else {
                            turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                            console.error('Error loading turnaround time:', data.message);
                        }
                    })
                    .catch(error => {
                        turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                        console.error('Error fetching turnaround time data:', error);
                    });
            }

            // Function to update Resolution Time by Category chart
            function updateResolutionTimeChart() {
                const technicianId = technicianFilter ? technicianFilter.value : '';

                let endpoint = '/ServiceTrackerGithub/analytics/turnaround-times-by-category';

                // If technician is selected, use specific endpoint
                if (technicianId) {
                    endpoint = `/ServiceTrackerGithub/analytics/turnaround-time-by-category/${technicianId}`;
                }

                fetch(endpoint)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // For technician-specific data, convert format
                            let chartLabels = [];
                            let chartData = [];
                            let formattedTimes = [];

                            if (technicianId && data.categories) {
                                // Process technician-specific data format
                                data.categories.forEach(cat => {
                                    chartLabels.push(cat.category_name);
                                    chartData.push(cat.avg_seconds / 3600); // Convert to hours
                                    formattedTimes.push(cat.avg_turnaround_time);
                                });
                            } else {
                                // Existing format for all technicians
                                chartLabels = data.labels;
                                chartData = data.data;
                                formattedTimes = data.formattedTimes;
                            }

                            // Update chart with the data
                            resolutionTimeChart.data.labels = chartLabels;
                            resolutionTimeChart.data.datasets[0].data = chartData;

                            // Update chart title based on selection
                            const chartTitle = document.querySelector(".bg-white:last-child h2.text-xl");
                            if (chartTitle) {
                                if (technicianId) {
                                    const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                                    const technicianName = selectedOption.textContent;
                                    chartTitle.textContent = `Resolution Time by Category for ${technicianName}`;
                                } else {
                                    chartTitle.textContent = "Average Resolution Time by Service Category";
                                }
                            }

                            // Update the tooltip callback to use formatted times
                            resolutionTimeChart.options.plugins.tooltip.callbacks.label = function(context) {
                                const index = context.dataIndex;
                                return `Average: ${formattedTimes[index] || 'N/A'}`;
                            };

                            resolutionTimeChart.update();
                        } else {
                            console.error('Error loading resolution time data:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching resolution time data:', error);
                    });
            }

            // ...existing code...
        });

        function loadLocationChart() {
            // Get date filter values if they exist
            const fromDate = document.getElementById('from-date').value || null;
            const toDate = document.getElementById('to-date').value || null;

            // Build query string for filters
            let queryParams = [];
            if (fromDate) queryParams.push(`start_date=${fromDate}`);
            if (toDate) queryParams.push(`end_date=${toDate}`);

            const queryString = queryParams.length > 0 ? `?${queryParams.join('&')}` : '';

            // Show loading state
            const ctx2 = document.getElementById("serviceRequestsBar").getContext("2d");
            if (window.serviceRequestsBarChart) {
                window.serviceRequestsBarChart.destroy();
            }

            fetch(`/ServiceTrackerGithub/analytics/requests-by-office${queryString}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Add a note about the top 10 limitation in the tooltip
                    const tooltipTitle = function(tooltipItems) {
                        return data.labels[tooltipItems[0].dataIndex];
                    };

                    window.serviceRequestsBarChart = new Chart(ctx2, {
                        type: "bar",
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            indexAxis: "y",
                            responsive: true,
                            maintainAspectRatio: false,
                            barThickness: 15,
                            scales: {
                                // ...existing code...
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        title: tooltipTitle
                                    }
                                }
                            }
                        }
                    });
                })
                // ...existing code...
        }
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // ... existing initialization code ...

        // Manually trigger the technician filter function once to ensure it works
        const technicianFilter = document.getElementById('technician-filter');
        if (technicianFilter) {
            // Add a debug log to check if filter is found
            console.log("Technician filter found:", technicianFilter);

            technicianFilter.addEventListener('change', function() {
                console.log("Technician selected:", this.value);
                updateAverageTurnaroundTime();
                updateResolutionTimeChart();
            });

            // Test if routes are working by console logging response
            fetch('/ServiceTrackerGithub/analytics/average-turnaround-time')
                .then(response => response.json())
                .then(data => console.log("API endpoint test:", data))
                .catch(error => console.error("API endpoint error:", error));
        } else {
            console.error("Technician filter element not found!");
        }

        // Function to update average turnaround time based on selected technician
        function updateAverageTurnaroundTime() {
            const technicianId = technicianFilter ? technicianFilter.value : '';
            const turnaroundTimeDisplay = document.querySelector('.text-3xl.font-bold.text-gray-900');

            console.log("Updating turnaround time for technician:", technicianId);

            // Show loading indicator
            if (turnaroundTimeDisplay) {
                turnaroundTimeDisplay.textContent = 'Loading...';

                let endpoint = '/ServiceTrackerGithub/analytics/average-turnaround-time';

                // If technician is selected, use specific endpoint
                if (technicianId) {
                    endpoint = `/ServiceTrackerGithub/analytics/turnaround-time/${technicianId}`;
                }

                console.log("Fetching from endpoint:", endpoint);

                // Fetch turnaround time data
                fetch(endpoint)
                    .then(response => {
                        console.log("Response status:", response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log("Turnaround time data received:", data);

                        if (data.success) {
                            // Update the displayed turnaround time
                            turnaroundTimeDisplay.textContent = data.average_turnaround_time;

                            // Update the subtitle text for the turnaround section
                            // Fix: Use valid CSS selectors that don't rely on Tailwind classes directly
                            const subtitleSection = turnaroundTimeDisplay.closest('.bg-white');
                            if (subtitleSection) {
                                // Find the subtitle container (more specific selector)
                                const subtitleContainer = subtitleSection.querySelector('.flex.items-center .flex.flex-col');
                                if (subtitleContainer) {
                                    if (technicianId) {
                                        // Find technician name from dropdown
                                        const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                                        const technicianName = selectedOption.textContent;

                                        // Update the paragraph and span elements directly
                                        const paragraphs = subtitleContainer.querySelectorAll('p');
                                        if (paragraphs.length > 0) {
                                            paragraphs[0].textContent = 'Technician-specific data';
                                        }

                                        const spans = subtitleContainer.querySelectorAll('span');
                                        if (spans.length > 0) {
                                            // Match the format in both scripts: "Technician: Name | PhilRice CES"
                                            spans[0].textContent = `Technician: ${technicianName} | PhilRice CES`;

                                            // Add requests processed info if available
                                            if (data.requests_processed) {
                                                const requestCount = parseInt(data.requests_processed);
                                                const requestText = requestCount === 1 ? "1 request processed" : `${requestCount} requests processed`;

                                                // Append request count to the span text
                                                spans[0].textContent += ` (${requestText})`;
                                            }
                                        }
                                    } else {
                                        // Reset to default display
                                        const paragraphs = subtitleContainer.querySelectorAll('p');
                                        if (paragraphs.length > 0) {
                                            paragraphs[0].textContent = 'January 1, 2025 to February 28, 2025';
                                        }

                                        const spans = subtitleContainer.querySelectorAll('span');
                                        if (spans.length > 0) {
                                            spans[0].textContent = 'All Service Category | PhilRice CES';
                                        }
                                    }
                                } else {
                                    console.error("Subtitle container not found");
                                }
                            } else {
                                console.error("Subtitle section not found");
                            }
                        } else {
                            turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                            console.error('Error loading turnaround time:', data.message);
                        }
                    })
                    .catch(error => {
                        turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                        console.error('Error fetching turnaround time data:', error);
                    });
            } else {
                console.error("Turnaround time display element not found!");
            }
        }

        // Function to update Resolution Time by Category chart
        function updateResolutionTimeChart() {
            // ... existing code ...
        }

        // ... existing code ...
    });
</script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // ... existing initialization code ...

        // Initialize all filters
        const technicianFilter = document.getElementById('technician-filter');
        const categoryFilter = document.getElementById('category-filter'); // New category filter

        // Listen for changes on the category dropdown
        if (categoryFilter) {
            console.log("Category filter found:", categoryFilter);

            categoryFilter.addEventListener('change', function() {
                console.log("Category selected:", this.value);
                // Update all visualizations when category changes
                updateAverageTurnaroundTime();
                updateResolutionTimeChart();
                updateOfficeChart();
            });
        } else {
            console.error("Category filter element not found!");
        }

        // ... existing technician filter code ...

        // Modify the updateAverageTurnaroundTime function to include category filter
        function updateAverageTurnaroundTime() {
            const technicianId = technicianFilter ? technicianFilter.value : '';
            const categoryId = categoryFilter ? categoryFilter.value : '';
            const turnaroundTimeDisplay = document.querySelector('.text-3xl.font-bold.text-gray-900');

            console.log("Updating turnaround time - Technician:", technicianId, "Category:", categoryId);

            // Show loading indicator
            if (turnaroundTimeDisplay) {
                turnaroundTimeDisplay.textContent = 'Loading...';

                // Build the URL with query parameters
                let endpoint = '/ServiceTrackerGithub/analytics/average-turnaround-time';
                const params = new URLSearchParams();

                if (technicianId) {
                    endpoint = `/ServiceTrackerGithub/analytics/turnaround-time/${technicianId}`;
                }

                if (categoryId) {
                    params.append('category_id', categoryId);
                }

                const queryString = params.toString() ? `?${params.toString()}` : '';
                const fullEndpoint = `${endpoint}${queryString}`;

                console.log("Fetching from endpoint:", fullEndpoint);

                // Fetch turnaround time data
                fetch(fullEndpoint)
                    .then(response => {
                        console.log("Response status:", response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log("Turnaround time data received:", data);

                        if (data.success) {
                            // Update the displayed turnaround time
                            turnaroundTimeDisplay.textContent = data.average_turnaround_time;

                            // Update the subtitle text for the turnaround section
                            const subtitleSection = turnaroundTimeDisplay.closest('.bg-white');
                            if (subtitleSection) {
                                const subtitleContainer = subtitleSection.querySelector('.flex.items-center .flex.flex-col');
                                if (subtitleContainer) {
                                    // Update subtitle based on selected filters
                                    updateSubtitleText(subtitleContainer, technicianId, categoryId, data);
                                } else {
                                    console.error("Subtitle container not found");
                                }
                            } else {
                                console.error("Subtitle section not found");
                            }
                        } else {
                            turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                            console.error('Error loading turnaround time:', data.message);
                        }
                    })
                    .catch(error => {
                        turnaroundTimeDisplay.textContent = '0 hrs 0 min';
                        console.error('Error fetching turnaround time data:', error);
                    });
            } else {
                console.error("Turnaround time display element not found!");
            }
        }

        // Helper function to update subtitle text based on filters
        function updateSubtitleText(subtitleContainer, technicianId, categoryId, data) {
            const paragraphs = subtitleContainer.querySelectorAll('p');
            const spans = subtitleContainer.querySelectorAll('span');

            if (paragraphs.length > 0 && spans.length > 0) {
                // Date range text always stays as "Filtered data" when any filter is applied
                if (technicianId || categoryId) {
                    paragraphs[0].textContent = 'Filtered data';
                } else {
                    paragraphs[0].textContent = 'January 1, 2025 to February 28, 2025';
                }

                // Build category/technician text
                let categoryText = 'All Service Category';
                if (categoryId) {
                    categoryText = categoryFilter.options[categoryFilter.selectedIndex].text;
                }

                let technicianText = '';
                if (technicianId) {
                    const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                    technicianText = ` | Technician: ${selectedOption.textContent}`;

                    // Add requests processed info if available
                    if (data.requests_processed) {
                        const requestCount = parseInt(data.requests_processed);
                        const requestText = requestCount === 1 ? "1 request processed" : `${requestCount} requests processed`;
                        technicianText += ` (${requestText})`;
                    }
                }

                spans[0].textContent = `${categoryText} | PhilRice CES${technicianText}`;
            }
        }

        // Modify the updateResolutionTimeChart function to include category filter
        function updateResolutionTimeChart() {
            const technicianId = technicianFilter ? technicianFilter.value : '';
            const categoryId = categoryFilter ? categoryFilter.value : '';

            let endpoint = '/ServiceTrackerGithub/analytics/turnaround-times-by-category';
            const params = new URLSearchParams();

            // If technician is selected, use specific endpoint
            if (technicianId) {
                endpoint = `/ServiceTrackerGithub/analytics/turnaround-time-by-category/${technicianId}`;
            }

            // Add category filter if selected
            if (categoryId) {
                params.append('category_id', categoryId);
            }

            const queryString = params.toString() ? `?${params.toString()}` : '';
            const fullEndpoint = `${endpoint}${queryString}`;

            console.log("Fetching resolution time chart data from:", fullEndpoint);

            fetch(fullEndpoint)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // For technician-specific data, convert format
                        let chartLabels = [];
                        let chartData = [];
                        let formattedTimes = [];

                        if (technicianId && data.categories) {
                            // Process technician-specific data format
                            data.categories.forEach(cat => {
                                // If category filter is applied, only show matching category
                                if (!categoryId || categoryId == cat.category_id) {
                                    chartLabels.push(cat.category_name);
                                    chartData.push(cat.avg_seconds / 3600); // Convert to hours
                                    formattedTimes.push(cat.avg_turnaround_time);
                                }
                            });
                        } else {
                            // Existing format for all technicians
                            if (categoryId) {
                                // Filter to show only the selected category
                                const index = data.labels.findIndex(label =>
                                    label === categoryFilter.options[categoryFilter.selectedIndex].text);

                                if (index !== -1) {
                                    chartLabels = [data.labels[index]];
                                    chartData = [data.data[index]];
                                    formattedTimes = [data.formattedTimes[index]];
                                } else {
                                    chartLabels = data.labels;
                                    chartData = data.data;
                                    formattedTimes = data.formattedTimes;
                                }
                            } else {
                                chartLabels = data.labels;
                                chartData = data.data;
                                formattedTimes = data.formattedTimes;
                            }
                        }

                        // Update chart with the data
                        resolutionTimeChart.data.labels = chartLabels;
                        resolutionTimeChart.data.datasets[0].data = chartData;

                        // Update chart title based on selection
                        const chartTitle = document.querySelector(".bg-white:last-child h2.text-xl");
                        if (chartTitle) {
                            let titleText = "Average Resolution Time by Service Category";

                            if (technicianId) {
                                const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                                titleText = `Resolution Time by Category for ${selectedOption.textContent}`;
                            }

                            if (categoryId) {
                                const selectedCategory = categoryFilter.options[categoryFilter.selectedIndex].text;
                                titleText += ` - ${selectedCategory}`;
                            }

                            chartTitle.textContent = titleText;
                        }

                        // Update the tooltip callback to use formatted times
                        resolutionTimeChart.options.plugins.tooltip.callbacks.label = function(context) {
                            const index = context.dataIndex;
                            return `Average: ${formattedTimes[index] || 'N/A'}`;
                        };

                        resolutionTimeChart.update();
                    } else {
                        console.error('Error loading resolution time data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching resolution time data:', error);
                });
        }

        // Function to update Office chart with filters
        function updateOfficeChart() {
            const technicianId = technicianFilter ? technicianFilter.value : '';
            const categoryId = categoryFilter ? categoryFilter.value : '';

            // Build query parameters
            const params = new URLSearchParams();
            if (categoryId) params.append('category_id', categoryId);
            if (technicianId) params.append('technician_id', technicianId);

            // Get date filter values if they exist
            const fromDate = document.getElementById('from-date').value || null;
            const toDate = document.getElementById('to-date').value || null;
            if (fromDate) params.append('start_date', fromDate);
            if (toDate) params.append('end_date', toDate);

            const queryString = params.toString() ? `?${params.toString()}` : '';

            // Get chart instance if it exists
            if (window.serviceRequestsBarChart) {
                window.serviceRequestsBarChart.destroy();
            }

            const ctx2 = document.getElementById("serviceRequestsBar").getContext("2d");

            console.log("Updating office chart with filters:", queryString);

            fetch(`/ServiceTrackerGithub/analytics/requests-by-office${queryString}`)
                .then(response => response.json())
                .then(data => {
                    window.serviceRequestsBarChart = new Chart(ctx2, {
                        type: "bar",
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            indexAxis: "y",
                            responsive: true,
                            maintainAspectRatio: false,
                            barThickness: 15,
                            scales: {
                                x: {
                                    ticks: {
                                        display: false
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: "#000",
                                        autoSkip: false,
                                        callback: function(value, index) {
                                            let label = this.getLabelForValue(value);
                                            return label.length > 20 ? label.substring(0, 18) + '...' : label;
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function(tooltipItems) {
                                            return data.labels[tooltipItems[0].dataIndex];
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Update all office chart headers to show filters
                    updateOfficeChartHeaders(technicianId, categoryId);
                })
                .catch(error => {
                    console.error("Error updating office chart:", error);
                });
        }

        // Update headers for office chart
        function updateOfficeChartHeaders(technicianId, categoryId) {
            const headers = document.querySelectorAll('.bg-white .text-[10px].text-gray-500.text-right');
            headers.forEach(header => {
                const categoryInfo = header.querySelector('.text-gray-400');
                if (categoryInfo) {
                    let categoryText = 'All Service Category';
                    if (categoryId) {
                        categoryText = categoryFilter.options[categoryFilter.selectedIndex].text;
                    }

                    let technicianText = '';
                    if (technicianId) {
                        const selectedOption = technicianFilter.options[technicianFilter.selectedIndex];
                        technicianText = ` | Technician: ${selectedOption.textContent}`;
                    }

                    categoryInfo.textContent = `${categoryText} | PhilRice CES${technicianText}`;
                }
            });
        }

        // ... existing code ...
    });
</script>
</x-layout>
