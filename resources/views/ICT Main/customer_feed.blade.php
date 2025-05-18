<x-layout>
    <div class="flex flex-col sm:flex-row w-full justify-between mb-4">
        <div class="flex items-center mb-3 sm:mb-0">
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Feedback</h2>
        </div>

        <div id="filter-form" class="flex flex-wrap items-center gap-2 bg-[#F5F7FA] p-2 rounded-lg font-roboto-text">
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

            <!-- All Technicians Dropdown -->
            <select id="technician-select" name="technician_id"
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                <option value="">ALL TECHNICIANS</option>
                @foreach ($technicians as $technician)
                    <option value="{{ $technician->philrice_id }}">{{ $technician->name }}</option>
                @endforeach
            </select>

            <select id="category-select" name="category_id"
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                <option value="">ALL SERVICES CATEGORY</option>
                @foreach ($categories as $id => $category)
                    <option value="{{ $id }}">{{ $category }}</option>
                @endforeach
            </select>

            <!-- PhilRice CES Dropdown -->
            <select
                class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                <option>PHILRICE CES</option>
            </select>
        </div>
    </div>

    <div class="p-1 font-roboto-text">
        <!-- Main Container -->
        <div class="flex flex-col lg:flex-row gap-4 mt-2">
            <!-- Left Side (Pie Chart) -->
            <div class="flex-1 bg-white xl:w-[60%] lg:w-full shadow-md rounded-lg p-3 sm:p-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                    <h2 class="text-lg font-semibold mb-2 sm:mb-0" id="chart-title">Customer Satisfaction Survey - Overall Rating</h2>
                    <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-lg self-start sm:self-center" id="download-chart">
                        <svg width="18px" height="18px" viewBox="0 0 14 19" xmlns="http://www.w3.org/2000/svg"
                            fill="white">
                            <g transform="translate(0,0.5)">
                                <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                            </g>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500" id="date-range">January 1, 2025 to February 28, 2025</p>
                <p class="text-xs text-gray-500" id="respondent-count">No. of Respondents: <span id="total-responses">{{ $feedbackStats['total_responses'] }}</span></p>
                <div class="flex justify-center">
                    <!-- Adjust the heights to be more consistent across screen sizes -->
                    <div class="w-[60%] h-[300px] md:h-[350px] lg:h-[400px] xl:h-[650px] flex flex-row justify-center items-center">
                        <canvas id="pieChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Side (Summary Cards) -->
            <div class="flex flex-col xl:w-[50%] lg:w-1/2">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex flex-col gap-2 w-full xl:w-[50%] sm:w-1/2 lg:w-[300px]">

                        <div class="overall-rating-card bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition"
                            data-value="{{ $feedbackStats['overall_rating']['percentage'] }}">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Overall Rating</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <span id="overall-response-count" class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold">
                                    <span class="rating-percentage">{{ $feedbackStats['overall_rating']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['overall_rating']['label'] }}</span>
                                </p>
                            </div>
                        </div>


                        <div class="bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition summary-card"
                            data-value="{{ $feedbackStats['dimensions']['responsiveness']['percentage'] }}" data-dimension="responsiveness">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Responsiveness</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    <span class="rating-percentage">{{ $feedbackStats['dimensions']['responsiveness']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['dimensions']['responsiveness']['label'] }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition summary-card"
                            data-value="{{ $feedbackStats['dimensions']['outcome']['percentage'] }}" data-dimension="outcome">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Outcome</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    <span class="rating-percentage">{{ $feedbackStats['dimensions']['outcome']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['dimensions']['outcome']['label'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 w-full sm:w-1/2 xl:w-[50%] lg:w-[300px] ">

                        <div class="bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition summary-card"
                            data-value="{{ $feedbackStats['dimensions']['realiability_quality']['percentage'] }}" data-dimension="realiability_quality">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Realiability and Quality</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    <span class="rating-percentage">{{ $feedbackStats['dimensions']['realiability_quality']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['dimensions']['realiability_quality']['label'] }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition summary-card"
                            data-value="{{ $feedbackStats['dimensions']['assurance_integrity']['percentage'] }}" data-dimension="assurance_integrity">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Assurance and Integrity</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    <span class="rating-percentage">{{ $feedbackStats['dimensions']['assurance_integrity']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['dimensions']['assurance_integrity']['label'] }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-4 border hover:border-green-600 transition summary-card"
                            data-value="{{ $feedbackStats['dimensions']['access_facility']['percentage'] }}" data-dimension="access_facility">
                            <div class="flex flex-row items-center justify-between">
                                <h3 class="font-semibold text-gray-700">Access and Facility</h3>
                                <div class="flex flex-row items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="grey"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">{{ $feedbackStats['total_responses'] }}/{{ $feedbackStats['total_responses'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    <span class="rating-percentage">{{ $feedbackStats['dimensions']['access_facility']['percentage'] }}%</span>
                                    <span class="text-xs sm:text-sm font-normal rating-label">{{ $feedbackStats['dimensions']['access_facility']['label'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Satisfaction Survey Table - Fix the height for consistent display -->
                <div class="bg-white shadow-md rounded-lg p-3 sm:p-4 mt-3 h-auto sm:h-auto md:h-auto xl:h-[450px]">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-0">
                        <h2 class="text-lg font-semibold mb-2 sm:mb-0">Customer Satisfaction Survey</h2>
                        <button class="flex items-center justify-center bg-green-700 text-white p-2 rounded-lg self-start sm:self-center" id="download-table">
                            <svg width="18px" height="18px" viewBox="0 0 14 19" xmlns="http://www.w3.org/2000/svg"
                                fill="white">
                                <g transform="translate(0,0.5)">
                                    <path d="M14,6H10V0H4V6H0L7,13L14,6ZM0,15V17H14V15H0Z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">No. of Respondents: <span id="table-responses">{{ $feedbackStats['total_responses'] }}</span></p>
                    <p class="text-xs text-gray-500" id="technician-filter-text">All Technicians</p>

                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-xs text-left" id="feedback-table">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="px-2 sm:px-4 py-2">Category</th>
                                    <th class="px-2 sm:px-4 py-2">Poor</th>
                                    <th class="px-2 sm:px-4 py-2">Fair</th>
                                    <th class="px-2 sm:px-4 py-2">Good</th>
                                    <th class="px-2 sm:px-4 py-2">Very Good</th>
                                    <th class="px-2 sm:px-4 py-2">Excellent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b" id="row-realiability_quality">
                                    <td class="px-2 sm:px-4 py-2 font-semibold">Reliability and Quality</td>
                                    <td class="px-2 sm:px-4 py-2" id="realiability_quality-1">{{ $feedbackStats['dimensions']['realiability_quality']['distribution'][1]['count'] }} ({{ $feedbackStats['dimensions']['realiability_quality']['distribution'][1]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="realiability_quality-2">{{ $feedbackStats['dimensions']['realiability_quality']['distribution'][2]['count'] }} ({{ $feedbackStats['dimensions']['realiability_quality']['distribution'][2]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="realiability_quality-3">{{ $feedbackStats['dimensions']['realiability_quality']['distribution'][3]['count'] }} ({{ $feedbackStats['dimensions']['realiability_quality']['distribution'][3]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="realiability_quality-4">{{ $feedbackStats['dimensions']['realiability_quality']['distribution'][4]['count'] }} ({{ $feedbackStats['dimensions']['realiability_quality']['distribution'][4]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="realiability_quality-5">{{ $feedbackStats['dimensions']['realiability_quality']['distribution'][5]['count'] }} ({{ $feedbackStats['dimensions']['realiability_quality']['distribution'][5]['percentage'] }}%)</td>
                                </tr>
                                <tr class="border-b" id="row-responsiveness">
                                    <td class="px-2 sm:px-4 py-2 font-semibold">Responsiveness</td>
                                    <td class="px-2 sm:px-4 py-2" id="responsiveness-1">{{ $feedbackStats['dimensions']['responsiveness']['distribution'][1]['count'] }} ({{ $feedbackStats['dimensions']['responsiveness']['distribution'][1]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="responsiveness-2">{{ $feedbackStats['dimensions']['responsiveness']['distribution'][2]['count'] }} ({{ $feedbackStats['dimensions']['responsiveness']['distribution'][2]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="responsiveness-3">{{ $feedbackStats['dimensions']['responsiveness']['distribution'][3]['count'] }} ({{ $feedbackStats['dimensions']['responsiveness']['distribution'][3]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="responsiveness-4">{{ $feedbackStats['dimensions']['responsiveness']['distribution'][4]['count'] }} ({{ $feedbackStats['dimensions']['responsiveness']['distribution'][4]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="responsiveness-5">{{ $feedbackStats['dimensions']['responsiveness']['distribution'][5]['count'] }} ({{ $feedbackStats['dimensions']['responsiveness']['distribution'][5]['percentage'] }}%)</td>
                                </tr>
                                <tr class="border-b" id="row-assurance_integrity">
                                    <td class="px-2 sm:px-4 py-2 font-semibold">Assurance and Integrity</td>
                                    <td class="px-2 sm:px-4 py-2" id="assurance_integrity-1">{{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][1]['count'] }} ({{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][1]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="assurance_integrity-2">{{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][2]['count'] }} ({{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][2]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="assurance_integrity-3">{{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][3]['count'] }} ({{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][3]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="assurance_integrity-4">{{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][4]['count'] }} ({{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][4]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="assurance_integrity-5">{{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][5]['count'] }} ({{ $feedbackStats['dimensions']['assurance_integrity']['distribution'][5]['percentage'] }}%)</td>
                                </tr>
                                <tr class="border-b" id="row-outcome">
                                    <td class="px-2 sm:px-4 py-2 font-semibold">Outcome</td>
                                    <td class="px-2 sm:px-4 py-2" id="outcome-1">{{ $feedbackStats['dimensions']['outcome']['distribution'][1]['count'] }} ({{ $feedbackStats['dimensions']['outcome']['distribution'][1]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="outcome-2">{{ $feedbackStats['dimensions']['outcome']['distribution'][2]['count'] }} ({{ $feedbackStats['dimensions']['outcome']['distribution'][2]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="outcome-3">{{ $feedbackStats['dimensions']['outcome']['distribution'][3]['count'] }} ({{ $feedbackStats['dimensions']['outcome']['distribution'][3]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="outcome-4">{{ $feedbackStats['dimensions']['outcome']['distribution'][4]['count'] }} ({{ $feedbackStats['dimensions']['outcome']['distribution'][4]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="outcome-5">{{ $feedbackStats['dimensions']['outcome']['distribution'][5]['count'] }} ({{ $feedbackStats['dimensions']['outcome']['distribution'][5]['percentage'] }}%)</td>
                                </tr>
                                <tr class="border-b" id="row-access_facility">
                                    <td class="px-2 sm:px-4 py-2 font-semibold">Access and Facility</td>
                                    <td class="px-2 sm:px-4 py-2" id="access_facility-1">{{ $feedbackStats['dimensions']['access_facility']['distribution'][1]['count'] }} ({{ $feedbackStats['dimensions']['access_facility']['distribution'][1]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="access_facility-2">{{ $feedbackStats['dimensions']['access_facility']['distribution'][2]['count'] }} ({{ $feedbackStats['dimensions']['access_facility']['distribution'][2]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="access_facility-3">{{ $feedbackStats['dimensions']['access_facility']['distribution'][3]['count'] }} ({{ $feedbackStats['dimensions']['access_facility']['distribution'][3]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="access_facility-4">{{ $feedbackStats['dimensions']['access_facility']['distribution'][4]['count'] }} ({{ $feedbackStats['dimensions']['access_facility']['distribution'][4]['percentage'] }}%)</td>
                                    <td class="px-2 sm:px-4 py-2" id="access_facility-5">{{ $feedbackStats['dimensions']['access_facility']['distribution'][5]['count'] }} ({{ $feedbackStats['dimensions']['access_facility']['distribution'][5]['percentage'] }}%)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Add Flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                // Trigger filter update
                fetchFilteredData();
            });

            document.getElementById('reset-to-date').addEventListener('click', function() {
                toDatePicker.clear();
                // Trigger filter update
                fetchFilteredData();
            });

            // Get initial data from PHP
            let feedbackStats = {!! json_encode($feedbackStats) !!};

            // Initialize Pie Chart with responsive options
            const ctx = document.getElementById("pieChart").getContext("2d");
            let pieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ["Excellent", "Very Good", "Good", "Fair", "Poor"],
                    datasets: [{
                        data: [
                            feedbackStats.rating_distribution.excellent || 0,
                            feedbackStats.rating_distribution.very_good || 0,
                            feedbackStats.rating_distribution.good || 0,
                            feedbackStats.rating_distribution.fair || 0,
                            feedbackStats.rating_distribution.poor || 0
                        ],
                        backgroundColor: ["#3F5F75", "#A85B42", "#FFC573", "#A87033", "#0F8C3F"]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            left: window.innerWidth < 640 ? 10 : 20,
                            right: window.innerWidth < 640 ? 10 : 20
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                boxWidth: 15,
                                padding: 10,
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        }
                    }
                }
            });

            // Function to update the colors of cards based on percentage
            function updateCardColors() {
                document.querySelectorAll(".summary-card, .overall-rating-card").forEach(card => {
                    let percentage = parseInt(card.getAttribute("data-value"));
                    let color = getRatingColor(percentage);
                    let label = getRatingLabel(percentage);

                    let percentageElement = card.querySelector(".rating-percentage");
                    let labelElement = card.querySelector(".rating-label");

                    if (percentageElement) percentageElement.style.color = color;
                    if (labelElement) {
                        labelElement.textContent = label;
                        labelElement.style.color = color;
                    }
                });
            }

            // Get rating color based on percentage
            function getRatingColor(percentage) {
                if (percentage >= 90) return "#3F5F75"; // Excellent - Dark Blue
                if (percentage >= 80) return "#A85B42"; // Very Good - Brown
                if (percentage >= 70) return "#FFC573"; // Good - Light Brown/Orange
                if (percentage >= 60) return "#A87033"; // Fair - Dark Orange
                return "#0F8C3F"; // Poor - Green
            }

            // Get rating label based on percentage
            function getRatingLabel(percentage) {
                if (percentage >= 90) return "Excellent";
                if (percentage >= 80) return "Very Good";
                if (percentage >= 70) return "Good";
                if (percentage >= 60) return "Fair";
                if (percentage > 0) return "Poor";
                return "N/A";
            }

            // Function to update pie chart with current data
            function updatePieChart() {
                pieChart.data.datasets[0].data = [
                    feedbackStats.rating_distribution.excellent || 0,
                    feedbackStats.rating_distribution.very_good || 0,
                    feedbackStats.rating_distribution.good || 0,
                    feedbackStats.rating_distribution.fair || 0,
                    feedbackStats.rating_distribution.poor || 0
                ];
                pieChart.update();
            }

            // Function to update card data
            function updateCards() {
                // Update overall rating card
                let overallCard = document.querySelector(".overall-rating-card");
                overallCard.setAttribute("data-value", feedbackStats.overall_rating.percentage);
                overallCard.querySelector(".rating-percentage").textContent = feedbackStats.overall_rating.percentage + "%";

                // Update dimension cards
                document.querySelectorAll(".summary-card").forEach(card => {
                    const dimension = card.getAttribute("data-dimension");
                    if (dimension && feedbackStats.dimensions[dimension]) {
                        card.setAttribute("data-value", feedbackStats.dimensions[dimension].percentage);
                        card.querySelector(".rating-percentage").textContent = feedbackStats.dimensions[dimension].percentage + "%";
                    }
                });

                // Update response count display
                document.querySelectorAll("#total-responses, #table-responses").forEach(el => {
                    el.textContent = feedbackStats.total_responses;
                });

                // Update technician filter text
                const techSelect = document.getElementById('technician-select');
                const techName = techSelect.options[techSelect.selectedIndex].text;
                document.getElementById('technician-filter-text').textContent =
                    techSelect.value ? techName : 'All Technicians';

                // Update table cells with distribution data
                for (const dimension in feedbackStats.dimensions) {
                    for (let rating = 1; rating <= 5; rating++) {
                        const cell = document.getElementById(`${dimension}-${rating}`);
                        if (cell) {
                            const count = feedbackStats.dimensions[dimension].distribution[rating].count;
                            const percentage = feedbackStats.dimensions[dimension].distribution[rating].percentage;
                            cell.textContent = `${count} (${percentage}%)`;
                        }
                    }
                }

                // Apply colors based on percentages
                updateCardColors();
            }

            // Initial update of card colors
            updateCardColors();

            // Handle filter changes
            const filterControls = [
                document.getElementById('from-date'),
                document.getElementById('to-date'),
                document.getElementById('technician-select'),
                document.getElementById('category-select')
            ];

            filterControls.forEach(control => {
                if (control) {
                    control.addEventListener('change', fetchFilteredData);
                }
            });

            // Function to fetch filtered data from the server
            function fetchFilteredData() {
                const filters = {
                    from_date: document.getElementById('from-date').value,
                    to_date: document.getElementById('to-date').value,
                    technician_id: document.getElementById('technician-select').value,
                    category_id: document.getElementById('category-select').value,
                    _token: "{{ csrf_token() }}"
                };

                // Show loading state
                document.querySelectorAll('.rating-percentage').forEach(el => {
                    el.textContent = "Loading...";
                });

                // Make AJAX request to get filtered data
                fetch("{{ route('customer_feed.filtered') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(filters)
                })
                .then(response => response.json())
                .then(data => {
                    feedbackStats = data;
                    updateCards();
                    updatePieChart();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to load data. Please try again.');
                });
            }

            // Card click handler to show details in pie chart
            document.querySelectorAll(".summary-card").forEach(card => {
                card.addEventListener("click", function() {
                    const dimension = this.getAttribute("data-dimension");
                    const title = this.querySelector("h3").textContent.trim();
                    document.getElementById("chart-title").textContent = `Customer Satisfaction Survey - ${title}`;

                    // Update chart to show distribution for this dimension
                    if (dimension && feedbackStats.dimensions[dimension]) {
                        const distribution = feedbackStats.dimensions[dimension].distribution;
                        pieChart.data.datasets[0].data = [
                            distribution[5].count, // Excellent (5)
                            distribution[4].count, // Very Good (4)
                            distribution[3].count, // Good (3)
                            distribution[2].count, // Fair (2)
                            distribution[1].count  // Poor (1)
                        ];
                        pieChart.update();
                    }
                });
            });

            // Reset chart to show overall distribution when Overall Rating card is clicked
            document.querySelector(".overall-rating-card").addEventListener("click", function() {
                document.getElementById("chart-title").textContent = "Customer Satisfaction Survey - Overall Rating";
                updatePieChart();
            });

            // Improved responsive handling for the chart
            function resizeChart() {
                const container = document.querySelector('#pieChart').parentNode;
                const containerHeight = container.offsetHeight;

                // Adjust legend position based on available height
                pieChart.options.plugins.legend.position =
                    containerHeight < 300 ? 'right' : 'bottom';

                pieChart.options.plugins.legend.labels.font.size =
                    window.innerWidth < 640 ? 10 : 12;

                pieChart.update();
            }

            // Add enhanced window resize event
            window.addEventListener('resize', resizeChart);

            // Initial call to resize chart
            resizeChart();

            // Download chart as image
            document.getElementById('download-chart').addEventListener('click', function() {
                const chartContainer = document.querySelector('.flex-1.bg-white');
                html2canvas(chartContainer).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jspdf.jsPDF({
                        orientation: 'landscape',
                        unit: 'mm'
                    });

                    const imgWidth = 250;
                    const imgHeight = canvas.height * imgWidth / canvas.width;

                    pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
                    pdf.save('customer_satisfaction_chart.pdf');
                });
            });

            // Download table as PDF
            document.getElementById('download-table').addEventListener('click', function() {
                const tableContainer = document.querySelector('.bg-white.shadow-md.rounded-lg.p-3.sm\\:p-4.mt-3');
                html2canvas(tableContainer).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jspdf.jsPDF({
                        orientation: 'portrait',
                        unit: 'mm'
                    });

                    const imgWidth = 170;
                    const imgHeight = canvas.height * imgWidth / canvas.width;

                    pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
                    pdf.save('customer_satisfaction_table.pdf');
                });
            });
        });
    </script>
</x-layout>
