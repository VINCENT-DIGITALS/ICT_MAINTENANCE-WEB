<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>ICT Main</title>
    <style>
        .filter-white {
            filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
        }

        .filter-orange {
            filter: invert(58%) sepia(72%) saturate(1345%) hue-rotate(12deg) brightness(102%) contrast(96%);
        }

        #chart-container {
            width: 100%;
            max-width: 900px;
            /* Adjust width as needed */
            height: 500px;
            /* Reduce height */
            margin: auto;
            /* Center the chart */
        }

        /* Custom scrollbar for Webkit browsers */
        ::-webkit-scrollbar {
            width: 6px;
            /* Adjust width to make it thinner */
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Light background */
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c4c4c4;
            /* Scrollbar color */
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9e9e9e;
            /* Darker color on hover */
        }


        .filter.invert {
            filter: invert(1);
        }

        .svg-green {
            filter: brightness(0) saturate(100%) invert(39%) sepia(100%) saturate(1000%) hue-rotate(90deg) brightness(90%) contrast(90%);
        }

        .svg-green2 {
            filter: brightness(0) saturate(100%) invert(14%) sepia(94%) saturate(6500%) hue-rotate(130deg) brightness(90%) contrast(110%);
        }

        .font-roboto-header {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            font-size: 25px;
            line-height: 37px;
        }

        .font-roboto-title {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            font-size: 25px;
            line-height: 37px;
        }


        .font-roboto-text {
            font-family: 'Roboto', sans-serif;
            font-weight: normal;
        }

        .font-roboto-footer {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            font-size: 9px;
        }

        .font-roboto-modal {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
        }

        .scroll-hidden::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar */
        }

        .scroll-hidden {
            -ms-overflow-style: none;
            /* Hide scrollbar in IE and Edge */
            scrollbar-width: none;
            /* Hide scrollbar in Firefox */
            overflow-y: scroll;
            /* Keep scrolling enabled */
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 80%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 10px;
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: bold;
        }

        .modal-header button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #555;
        }

        .modal-header button:hover {
            color: #000;
        }

        .modal-body {
            margin-top: 15px;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        .modal-body a {
            color: #007A33;
            text-decoration: underline;
        }

        /* Enhanced sidebar styling */
        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .request-pill {
            transition: all 0.2s ease;
        }

        .request-pill:hover {
            transform: translateX(5px);
        }

        /* Table enhancements */
        .table-container {
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            height: 87%;
            display: flex;
            flex-direction: column;
            position: relative;
            /* Set relative positioning for the container */
            height: 100%;
            /* Ensure the container takes full height */
        }

        .table-container table {
            table-layout: fixed;
            /* Ensure consistent column widths */
            width: 100%;
            /* Full width for the table */
            border-collapse: collapse;
            /* Ensure borders collapse for alignment */
            flex: 1;
            /* Allow the table to grow and fill the container */

            flex-direction: column;
        }

        .table-container thead {
            position: sticky;
            /* Make the header sticky */
            top: 0;
            /* Stick to the top of the container */
            z-index: 10;
            /* Ensure it stays above the body content */
            background-color: white;
            /* Match the table background */
            flex-shrink: 0;
            /* Prevent the header from shrinking */
        }

        .table-container th {
            text-align: left;
            /* Align header text to the left */
            padding: 0.5rem;
            /* Add padding for better readability */
            border-bottom: 1px solid #e5e7eb;
            /* Add a border for separation */
        }

        .table-container td {
            padding: 0.5rem;
            /* Add padding for table cells */
            border-bottom: 1px solid #e5e7eb;
            /* Add a border for separation */
        }

        .table-container tbody {
            flex: 1;
            /* Allow the body to take up available space */
            overflow-y: auto;
            /* Enable scrolling for the table body */
        }

        .table-container tfoot {
            position: sticky;
            /* Make the footer sticky */
            bottom: 0;
            /* Stick to the bottom of the container */
            z-index: 10;
            /* Ensure it stays above other content */
            background-color: white;
            /* Match the table background */
            /* Add a border for separation */
            flex-shrink: 0;
            /* Prevent the footer from shrinking */
            margin-top: auto;
            /* Push the footer to the bottom */
        }

        .table-container tfoot td {
            background-color: white;
            /* Ensure consistent background color */
        }

        .table-header {
            background-color: #f9fafb;
        }

        .table-row:hover {
            background-color: #f9fafb;
        }

        /* Button styling */
        .btn-primary {
            background-color: #007A33;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #006128;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Search field enhancement */
        .search-input {
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
        }

        .search-input:focus {
            border-color: #007A33;
            box-shadow: 0 0 0 3px rgba(0, 122, 51, 0.1);
            outline: none;
        }

        /* Modal improvements */
        .modal-container {
            animation: fadeIn 0.2s ease;
        }

        .modal-content {
            animation: slideUp 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Added styles for top panel */
        .top-panel {
            background-color: #1e293b;
            /* Dark blue background */
            color: white;
            padding: 1rem;
            background-image: url('{{ url('/public/images/Maintenance.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .service-pill {
            transition: all 0.2s ease;
            flex: 0 0 auto;
            width: 20%;
            /* Adjust width to content */
            margin: 0.25rem;
            height: 10%;
            /* Add some spacing */
        }

        .service-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: flex-start;
            /* Align items to the start */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .service-pill {
                width: auto;
                /* Adjust width to content */
                max-width: none;
            }
        }
    </style>
</head>

<body>
    <!-- Top Service Requests Panel -->
    <div class="w-full top-panel h-[30%]">
        <div class="flex flex-col md:flex-row justify-start gap-4 lg:text-xs xl:text-lg">
            <!-- Now Serving Section -->
            <div class=" md:w-full lg:w-[180%] xl:w-full">
                <h3 class="text-xl text-white font-roboto-title mb-2">Now Serving</h3>
                <div class="service-container ">
                    @forelse($nowServing as $request)

                        <div class="service-pill bg-[#007A33] text-slate-900 text-white py-1 px-4 rounded-full flex items-center">
                            <span class="font-medium">{{ $request['ticket_full'] }}</span>
                        </div>
                    @empty
                        @for ($i = 0; $i < 4; $i++)
                            <div
                                class="service-pill bg-[#007A33] text-slate-900 text-white py-1 px-2 rounded-full flex justify-between items-center">
                                <span class="font-medium">SR-{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</span>

                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- Next Customer Section -->
            <div class="md:w-full lg:w-[150%] xl:w-full">
                <h3 class="text-xl text-white font-roboto-title mb-2">Next Customer</h3>
                <div class="service-container ">
                    @forelse($nextCustomer as $request)
                        @if ($loop->index < 7)
                            <div
                                class="service-pill bg-[#FCA311] text-slate-900 text-white py-1 px-4 rounded-full flex justify-between items-center">
                                <span class="font-medium">{{ $request['ticket_full'] }}</span>
                            </div>
                        @endif
                    @empty
                        @for ($i = 0; $i < 4; $i++)
                            <div
                                class="service-pill bg-[#FCA311] text-slate-900 text-white py-1 px-2 rounded-full flex justify-between items-center">
                                <span class="font-medium">SR-{{ str_pad($i + 5, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area - Now full width -->
    <div class="px-3 pb-3 bg-gray-50 min-h-screen">
        <!-- Header - Enhanced with Back Button -->
        <div class="mb-2 flex justify-between items-center">
        </div>

        <!-- Action Buttons and Search - Enhanced -->
        <div class="flex justify-between items-center mb-2  p-2">
            <button onclick="showDashboardModal()"
                class="btn-primary hover:bg-green-800 text-white px-5 py-2 rounded-md flex items-center">
                Add service request
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <div class="relative">
                <input type="text" id="search-input" placeholder="Search requests..."
                    class="search-input border border-gray-300 rounded-md px-4 py-2 w-80 focus:ring-2 focus:ring-green-200">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Service Request Table - Enhanced -->
        <div class="table-container font-roboto-footer bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm"
            x-data="paginationData" x-init="loadData()">
            <table>
                <!-- Table Headers -->
                <thead>
                    <tr class="table-header border-b font-roboto-text">
                        <th class="p-2 text-sm text-left font-medium text-gray-600">No.</th>
                        <th class="p-2 text-sm text-left font-medium text-gray-600">Category</th>
                        <th class="p-2 text-sm text-left font-medium text-gray-600">Request Details</th>
                        <th class="p-2 text-sm text-left font-medium text-gray-600">Other info</th>
                        <th class="p-2 text-sm text-left font-medium text-gray-600">Status</th>
                        <th class="p-2 text-sm text-left font-medium text-gray-600">Evaluation</th>
                    </tr>
                </thead>
                <tbody class="h-full">
                    <!-- Dynamic Table Content - Uses current page data -->
                    <template x-for="(request, index) in getCurrentPageData()" :key="index">
                        <tr class="table-row hover:bg-gray-50 text-xs"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">
                            <td class="p-2 text-xs font-semibold" x-text="request.ticketId"></td>
                            <td class="p-2">
                                <div class="text-xs font-semibold" x-text="request.category"></div>
                                <div class="text-xs text-gray-500" x-text="request.subcategory"></div>
                            </td>
                            <td class="p-2" colspan="1">
                                <div>
                                    <span class="font-semibold">Subject:</span> <span class="text-gray-500"
                                        x-text="request.subject"></span>
                                </div>
                                <div>
                                    <span class="font-semibold">Description:</span> <span class="text-gray-500"
                                        x-text="request.description"></span>
                                </div>
                                <div>
                                    <span class="font-semibold">Location:</span> <span class="text-gray-500"
                                        x-text="request.location"></span>
                                </div>
                                <div>
                                    <span class="font-semibold">Date Requested:</span> <span class="text-gray-500"
                                        x-text="request.dateRequested"></span>
                                </div>
                                <div>
                                    <span class="font-semibold">Requested Completion Date:</span> <span
                                        class="text-gray-500" x-text="request.completionDate"></span>
                                </div>
                            </td>
                            <td class="p-2">
                                <div>
                                    <span class="font-semibold">Problems encountered:</span>
                                    <span class="text-gray-500" x-html="decodeHtml(request.problems)"></span>
                                </div>
                                <div class="mt-2">
                                    <span class="font-semibold">Actions Taken:</span>
                                    <span class="text-gray-500" x-html="decodeHtml(request.actions)"></span>
                                </div>
                                <div class="mt-2">
                                    <span class="font-semibold">Remarks:</span>
                                    <span class="text-gray-500" x-html="decodeHtml(request.remarks)"></span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span :class="getStatusClass(request.status)"
                                    class="text-white text-xs font-semibold px-3 py-1 rounded-full"
                                    x-text="request.status"></span>
                            </td>
                            <td class="p-2">
                                <div x-data="{ showEvalModal: false, currentRequest: null }">
                                    <!-- Modified rating display with conditional button styling -->
                                    <div
                                         :class="request.ratingText !== 'Not yet rated' ?
                                                'text-gray-400' :
                                                (request.status === 'Completed' ?
                                                    'bg-green-100 text-green-600 border border-green-300 rounded-md px-3 py-1.5 inline-block cursor-pointer hover:bg-green-200 transition-all text-center' :
                                                    'text-gray-400')"
                                         @click="if(request.ratingText === 'Not yet rated' && request.status === 'Completed') {
                                                    showEvalModal = true;
                                                    currentRequest = request
                                                }">
                                        <span x-text="request.ratingText || 'Not yet rated'" class="text-sm"></span>
                                    </div>

                                    <!-- Rest of the modal code remains unchanged -->
                                    <div x-show="showEvalModal"
                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                                         @click.self="showEvalModal = false">
                                        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl overflow-hidden" @click.stop>
                                            <div class="p-6">
                                                <div class="flex justify-between items-center border-b pb-3">
                                                    <h2 class="text-xl font-bold">Service Request Evaluation</h2>
                                                    <button @click="showEvalModal = false" class="text-gray-500 hover:text-gray-700">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form class="mt-4 space-y-4" @submit.prevent="submitEvaluation($event)">
                                                    <input type="hidden" name="request_id" :value="currentRequest.id">
                                                    <input type="hidden" name="evaluator_emp_id" value="{{ auth()->user()->philrice_id }}">

                                                    <!-- Subject & Body -->
                                                    <div class="space-y-3">
                                                        <input type="text" name="evaluation_subject" placeholder="Subject" class="w-full p-2 text-sm border rounded-md">
                                                        <textarea name="evaluation_body" placeholder="Overall evaluation comments..." rows="2" class="w-full p-2 text-sm border rounded-md"></textarea>
                                                    </div>

                                                    <!-- Rating Sections -->
                                                    <div class="space-y-6">
                                                        <!-- Timeliness -->
                                                        <div class="border rounded-lg p-4">
                                                            <h3 class="font-semibold mb-2">Realiability and Quality</h3>
                                                            <div class="flex items-center space-x-4">
                                                                <template x-for="i in 5">
                                                                    <div class="flex items-center">
                                                                        <input type="radio" :name="'realiability_quality'" :value="i" :id="'time'+i" class="accent-green-600">
                                                                        <label :for="'time'+i" class="ml-1" x-text="i"></label>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                            <textarea name="quality_remark" class="mt-2 w-full p-2 border rounded-md text-sm" placeholder="Comments on Realiability and quality..."></textarea>
                                                        </div>

                                                        <!-- Quality -->
                                                        <div class="border rounded-lg p-4">
                                                            <h3 class="font-semibold mb-2">Responsiveness</h3>
                                                            <div class="flex items-center space-x-4">
                                                                <template x-for="i in 5">
                                                                    <div class="flex items-center">
                                                                        <input type="radio" :name="'responsiveness'" :value="i" :id="'qual'+i" class="accent-green-600">
                                                                        <label :for="'qual'+i" class="ml-1" x-text="i"></label>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                            <textarea name="responsiveness_remark" class="mt-2 w-full p-2 border rounded-md text-sm" placeholder="Comments on Responsiveness..."></textarea>
                                                        </div>

                                                        <!-- Courtesy -->
                                                        <div class="border rounded-lg p-4">
                                                            <h3 class="font-semibold mb-2">Outcome</h3>
                                                            <div class="flex items-center space-x-4">
                                                                <template x-for="i in 5">
                                                                    <div class="flex items-center">
                                                                        <input type="radio" :name="'outcome'" :value="i" :id="'cour'+i" class="accent-green-600">
                                                                        <label :for="'cour'+i" class="ml-1" x-text="i"></label>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                            <textarea name="timeliness_remark" class="mt-2 w-full p-2 border rounded-md text-sm" placeholder="Comments on Outcome..."></textarea>
                                                        </div>

                                                        <!-- Additional Sections -->
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="border rounded-lg p-4">
                                                                <h3 class="font-semibold mb-2">Assurance & Integrity</h3>
                                                                <div class="flex items-center space-x-4">
                                                                    <template x-for="i in 5">
                                                                        <div class="flex items-center">
                                                                            <input type="radio" :name="'assurance_integrity'" :value="i" :id="'assure'+i" class="accent-green-600">
                                                                            <label :for="'assure'+i" class="ml-1" x-text="i"></label>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                                <textarea name="integrity_remark" class="mt-2 w-full p-2 border rounded-md text-sm" placeholder="Comments on Assurance & Integrity..."></textarea>
                                                            </div>

                                                            <div class="border rounded-lg p-4">
                                                                <h3 class="font-semibold mb-2">Access & Facility</h3>
                                                                <div class="flex items-center space-x-4">
                                                                    <template x-for="i in 5">
                                                                        <div class="flex items-center">
                                                                            <input type="radio" :name="'access_facility'" :value="i" :id="'access'+i" class="accent-green-600">
                                                                            <label :for="'access'+i" class="ml-1" x-text="i"></label>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                                <textarea name="access_remark" class="mt-2 w-full p-2 border rounded-md text-sm" placeholder="Comments on Access & Facility..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="flex justify-end space-x-3 mt-6">
                                                        <button type="button" @click="showEvalModal = false"
                                                                class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                                            Submit Evaluation
                                                        </button>
                                                    </div>
                                                </form>
                                                <script>
                                                    function submitEvaluation(event) {
                                                        const form = event.target;
                                                        const formData = new FormData(form);
                                                        const data = {};
                                                        formData.forEach((value, key) => data[key] = value);

                                                        // Show loading state
                                                        Swal.fire({
                                                            title: 'Submitting...',
                                                            text: 'Please wait while we process your evaluation',
                                                            icon: 'info',
                                                            allowOutsideClick: false,
                                                            showConfirmButton: false,
                                                            willOpen: () => {
                                                                Swal.showLoading();
                                                            }
                                                        });

                                                        fetch('/ServiceTrackerGithub/submit-evaluation', {
                                                            method: 'POST',
                                                            headers: {
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                'Content-Type': 'application/json',
                                                                'Accept': 'application/json'
                                                            },
                                                            body: JSON.stringify(data)
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                Swal.fire({
                                                                    title: 'Success!',
                                                                    text: 'Evaluation submitted successfully',
                                                                    icon: 'success',
                                                                    confirmButtonColor: '#007A33'
                                                                }).then(() => {
                                                                    window.location.reload();
                                                                });
                                                            } else {
                                                                Swal.fire({
                                                                    title: 'Error!',
                                                                    text: data.message || 'An error occurred while submitting the evaluation',
                                                                    icon: 'error',
                                                                    confirmButtonColor: '#007A33'
                                                                });
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            Swal.fire({
                                                                title: 'Error!',
                                                                text: 'An error occurred while submitting the evaluation',
                                                                icon: 'error',
                                                                confirmButtonColor: '#007A33'
                                                            });
                                                        });
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <!-- Empty state when no data is available -->
                    <template x-if="getCurrentPageData().length === 0">
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                No service requests available for this page
                            </td>
                        </tr>
                    </template>
                </tbody>

                <tfoot class="mt-auto">
                    <!-- Pagination - Enhanced with Alpine.js -->
                    <tr>
                        <td colspan="6" class="bg-white p-2">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span
                                    x-text="`Showing ${getCurrentPageData().length ? (currentPage - 1) * perPage + 1 : 0} to ${Math.min(currentPage * perPage, totalItems)} of ${totalItems} entries`">
                                    Showing 1 to 5 of entries
                                </span>

                                <div class="flex justify-end items-center w-auto">
                                    <!-- Previous Button (Hidden on First Page) -->
                                    <template x-if="currentPage > 1">
                                        <button @click="prevPage()"
                                            class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition">
                                            ❮
                                        </button>
                                    </template>

                                    <!-- Page Numbers -->
                                    <template x-for="page in visiblePages()" :key="page">
                                        <button @click="currentPage = page"
                                            class="py-0.5 px-1.5 text-xs font-semibold transition"
                                            :class="currentPage === page ? 'bg-green-600 text-white' :
                                                'bg-white text-gray-700 hover:bg-gray-200'"
                                            x-text="page">
                                        </button>
                                    </template>

                                    <!-- Next Button (Hidden on Last Page) -->
                                    <template x-if="currentPage < totalPages()">
                                        <button @click="nextPage()"
                                            class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition">
                                            ❯
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Enhanced Modal -->
        <div id="dashboardModal" style="display: none;"
            class="modal-container fixed top-0 left-0 w-full h-full bg-black bg-opacity-70 flex justify-center items-center z-[9999] p-4">
            <div
                class="modal-content bg-white w-[700px] max-w-[1000px] pt-4 px-4 rounded-lg shadow-lg max-h-[90vh] overflow-auto">
                <div class="sticky top-0 bg-white flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="font-bold text-xl text-gray-800">Add New Request</h2>
                    <button onclick="hideDashboardModal()"
                        class="text-gray-500 hover:text-gray-700 text-xl hover:bg-gray-100 rounded-full h-8 w-8 flex items-center justify-center">✕</button>
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
                                <label class="block text-xs font-medium text-[#707070] pb-1">Location</label>
                                <select name="location" class="w-full border border-gray-300 text-xs rounded-lg p-2">
                                    <option>ISD Office, 2nd Floor, Main Bldg.</option>
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
                    <div class="mt-8 flex justify-center w-full space-x-3 mb-4">
                        <button type="button" onclick="hideDashboardModal()"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg w-1/3 text-sm font-medium hover:bg-gray-300 transition">
                            CANCEL
                        </button>
                        <button type="submit"
                            class="bg-[#007A33] text-white px-4 py-2 rounded-lg w-2/3 text-sm font-medium hover:bg-[#006128] transition shadow-sm">
                            ADD NEW REQUEST
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
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
        document.addEventListener('alpine:init', () => {
            Alpine.data('paginationData', () => ({
                currentPage: 1,
                perPage: 5, // Set back to 5 items per page
                totalItems: 0,
                allData: [],
                searchTerm: '', // Add searchTerm property
                // Add decodeHtml function to properly handle HTML entities
                decodeHtml(html) {
                    if (!html) return '';
                    const textarea = document.createElement('textarea');
                    textarea.innerHTML = html;
                    return textarea.value;
                },
                // Initialize data
                loadData() {
                    // Populate with data from the requests sent from controller
                    this.allData = [
                        @foreach($requests as $request)
                        {
                            id: {{ $request->id }}, // Add this line
                            ticketId: '{!! $request->ticket_full !!}',
                            category: '{!! optional($request->category)->category_name ?? "Unknown" !!}',
                            subcategory: '{!! optional($request->subcategory)->sub_category_name ?? "" !!}',
                            subject: '{!! $request->request_title !!}',
                            description: '{!! $request->request_description !!}',
                            location: '{!! $request->location !!}',
                            dateRequested: '{!! $request->created_at ? $request->created_at->format("M d, Y") : "" !!}',
                            completionDate: '{!! $request->request_completion ?? "None"  !!}',
                            problems: '{!! addslashes($request->problem_name) !!}',
                            actions: '{!! addslashes($request->action_name) !!}',
                            remarks: '{!! addslashes($request->remarks) !!}',
                            currentStatus: '{!! $request->current_status !!}',
                            status: '{!! $request->status_name !!}', // Now using the status_name from the relationship
                            statusAbbr: '{!! $request->status_abbr !!}', // Adding status abbreviation from relationship
                            rating: {{ $request->rating ?? 'null' }},
                            ratingText: '{!! $request->rating_text ?? "Not yet rated" !!}'
                        },
                        @endforeach
                    ];

                    console.log("Loaded data:", this.allData); // Add this for debugging
                    this.totalItems = this.allData.length;

                    // Add event listener for search input
                    document.getElementById('search-input').addEventListener('input', (e) => {
                        this.searchTerm = e.target.value.toLowerCase();
                        this.currentPage = 1; // Reset to first page when searching
                    });
                },

                // Get filtered data based on search term
                getFilteredData() {
                    if (!this.searchTerm) {
                        return this.allData;
                    }

                    return this.allData.filter(item => {
                        // Search in multiple fields
                        return (
                            item.ticketId?.toLowerCase().includes(this.searchTerm) ||
                            item.category?.toLowerCase().includes(this.searchTerm) ||
                            item.subcategory?.toLowerCase().includes(this.searchTerm) ||
                            item.subject?.toLowerCase().includes(this.searchTerm) ||
                            item.description?.toLowerCase().includes(this.searchTerm) ||
                            item.location?.toLowerCase().includes(this.searchTerm) ||
                            item.problems?.toLowerCase().includes(this.searchTerm) ||
                            item.actions?.toLowerCase().includes(this.searchTerm) ||
                            item.remarks?.toLowerCase().includes(this.searchTerm) ||
                            item.status?.toLowerCase().includes(this.searchTerm)
                        );
                    });
                },

                // Get current page data with search filtering
                getCurrentPageData() {
                    const filteredData = this.getFilteredData();
                    const startIndex = (this.currentPage - 1) * this.perPage;
                    const endIndex = startIndex + this.perPage;
                    return filteredData.slice(startIndex, endIndex);
                },

                // Calculate total pages based on filtered data
                totalPages() {
                    return Math.ceil(this.getFilteredData().length / this.perPage);
                },

                // Get visible page numbers (shows up to 5 page numbers)
                visiblePages() {
                    let total = this.totalPages();
                    let start = Math.max(1, this.currentPage - 2);
                    let end = Math.min(total, start + 4);

                    if (end - start < 4 && end < total) {
                        end = Math.min(total, start + 4);
                    }
                    if (end - start < 4) {
                        start = Math.max(1, end - 4);
                    }

                    return Array.from({
                        length: end - start + 1
                    }, (_, i) => start + i);
                },

                // Go to previous page
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                // Go to next page
                nextPage() {
                    if (this.currentPage < this.totalPages()) {
                        this.currentPage++;
                    }
                },

                // Get status color class
                getStatusClass(status) {
                    switch (status) {
                        case 'Evaluated':
                            return 'bg-green-600';
                        case 'Pending':
                            return 'bg-[#A87033]';
                        case 'Ongoing':
                            return 'bg-[#A85B42]';
                        case 'Picked':
                            return 'bg-[#FFC573]';
                        case 'Paused':
                            return 'bg-[#14213D]';
                        case 'Completed':
                            return 'bg-[#3F5F75]';
                        case 'Denied':
                            return 'bg-[#6C757D]';
                        case 'Canceled':
                        case 'Cancelled':
                            return 'bg-[#6C757D]';
                        default:
                            return 'bg-gray-500';
                    }
                },

                // Get rating color class
                getRatingColorClass(rating) {
                    if (!rating) return '';
                    if (rating >= 90) return 'text-green-600';
                    if (rating >= 80) return 'text-amber-500';
                    return 'text-amber-400';
                }
            }));
        });

        function showDashboardModal() {
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
                console.log('Check request limit response:', data);

                if (data.canCreateRequest) {
                    document.getElementById('dashboardModal').style.display = 'flex';
                    document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
                } else {
                    // Determine which limit was reached for appropriate messaging
                    let title, message, showViewButton = false;

                    if (data.unratedLimitReached) {
                        title = 'Please Rate Your Requests First';
                        message = 'You have 3 or more completed requests that need to be rated before you can create a new request.';
                        showViewButton = true;
                    } else if (data.pendingLimitReached) {
                        title = 'Maximum Pending Requests Reached';
                        message = 'You have reached the maximum amount of pending requests (3).';
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
                            window.location.href = '{{ route("completed") }}';
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // If there's an error, allow showing the modal (fallback behavior)
                document.getElementById('dashboardModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }

        function hideDashboardModal() {
            document.getElementById('dashboardModal').style.display = 'none';
            document.body.style.overflow = ''; // Re-enable scrolling
        }
    </script>
</body>

</html>

