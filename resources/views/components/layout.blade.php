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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

        .font-roboto-button {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            ;
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
    </style>
</head>

<body x-data="{ sidebarOpen: false }" class="flex bg-[#F5F7FA]">
    {{-- HEADER --}}
    <div
        class="w-full bg-white text-gray-900 shadow-md p-4 h-[64px] flex justify-between items-center fixed top-0 left-0 z-10 max-h-screen">

        <!-- Background Image -->
        <img src="{{ url('public/images/headernew.png') }}" alt="Header Image"
            class="absolute h-full object-cover z-[-1]">

        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-600 focus:outline-none z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Text Content -->
        <div class="flex flex-row justify-between w-full items-center">
            <h3 class="font-bold text-[20px] leading-[37px] font-roboto-title relative z-10">
                <span class="hidden sm:inline">ICT Maintenance & Service Management System</span>
                <span class="sm:hidden">ICT MSMS</span>
            </h3>

            <div class="flex items-center space-x-4 h-full">
                <p class="text-gray-500 flex align-items-center">
                    <span class="font-light text-black">Mabuhay,</span>
                    <span class="font-bold text-black ml-1">{{ Auth::user()->name ?? 'Guest' }}!</span>
                </p>
                <div class="flex align-items-center pt-4">
                    <form method="POST" action="{{ route('logout') }}" class="flex align-items-center">
                        @csrf
                        <button type="submit" class="text-green-500 hover:text-green-700 transition-all duration-200">
                            <img src="{{ url('public/svg/exit.svg') }}" alt="Custom SVG" class="size-4 svg-green">
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed md:translate-x-0 transition-transform duration-300 md:w-[15%] w-[75%] bg-gray-900 text-white p-5 top-16 h-[calc(100vh-4rem)] flex flex-col justify-between z-50"
        style="background-image: url('{{ url('/public/images/Maintenance.png') }}'); background-repeat: no-repeat; background-size: cover;">

        <button @click="sidebarOpen = false" class="absolute top-2 right-2 text-gray-400 md:hidden">
            ✕
        </button>

        <!-- Navigation Menu -->
        <nav
            class="mt-1 sm:mt-2 lg:mt-3 xl:mt-4 flex flex-col space-y-0.5 sm:space-y-1 lg:space-y-1 xl:space-y-2 text-gray-300 font-roboto-text text-[10px] sm:text-xs">
            @php
                $menuItems = [
                    ['route' => 'dashboard', 'icon' => 'dashboard.svg', 'text' => 'Dashboard'],
                    ['route' => 'pending', 'icon' => 'pending.svg', 'text' => 'Pending Requests'],
                    ['route' => 'picked', 'icon' => 'picked.svg', 'text' => 'Picked Requests'],
                    ['route' => 'ongoing', 'icon' => 'ongoing.svg', 'text' => 'Ongoing Services'],
                    ['route' => 'completed', 'icon' => 'completed.svg', 'text' => 'Completed Services'],
                    ['route' => 'analytics', 'icon' => 'analytics.svg', 'text' => 'Analytics'],
                    ['route' => 'customer_feed', 'icon' => 'feedback.svg', 'text' => 'Feedback'],
                    ['route' => 'incident_reports', 'icon' => 'incidentReport.svg', 'text' => 'Incident Reports'],
                    ['route' => 'database_service', 'icon' => 'database.svg', 'text' => 'Database'],
                ];

                if (Auth::check() && optional(Auth::user()->role)->role_name === 'Super Administrator') {
                    $databaseIndex = collect($menuItems)->search(fn($item) => $item['route'] === 'database_service');

                    if ($databaseIndex !== false) {
                        array_splice($menuItems, $databaseIndex, 0, [
                            ['route' => 'technician.index', 'icon' => 'technicians.svg', 'text' => 'Technician'],
                            ['route' => 'request.index', 'icon' => 'request.svg', 'text' => 'Requests'],
                        ]);
                    }
                }
            @endphp

            @foreach ($menuItems as $item)
                <div class="flex items-center space-x-1 sm:space-x-1 lg:space-x-1.5 xl:space-x-2">
                    <img src="{{ url('public/svg/' . $item['icon']) }}" alt="{{ $item['text'] }}"
                        class="size-2.5 sm:size-3 lg:size-3 xl:size-4 transition-all duration-300
        {{ request()->routeIs($item['route']) ? 'filter-orange' : 'filter-white' }}">

                    <a href="{{ route($item['route']) }}"
                        class="py-0.5 sm:py-1 lg:py-1 xl:py-2 px-0.5 sm:px-1 lg:px-1 xl:px-2 rounded transition-all duration-300
        {{ request()->routeIs($item['route']) ? 'text-[#FCA311]' : 'text-gray-300 hover:text-orange-300' }}">
                        {{ $item['text'] }}
                    </a>
                </div>
            @endforeach
        </nav>
        <div class="text-center text-white mt-1 sm:mt-1 lg:mt-2 xl:mt-4 w-[100%] font-roboto-footer">
            <p class="text-[6px] sm:text-[7px] lg:text-[8px] xl:text-[9px]"><strong>© 2025 PhilRice - Information
                    Systems Division</strong></p>
            <p class="text-[6px] sm:text-[7px] lg:text-[8px] xl:text-[9px]">All rights reserved.</p>
            <a href="#"
                class="text-[#FCA311] hover:underline text-[6px] sm:text-[7px] lg:text-[8px] xl:text-[9px]"
                onclick="showModal(event)">Learn More About This System</a>
        </div>
    </div>

    <div class="md:ml-[15%] ml-0 mt-16 px-6 lg:py-4 xl:pt-3  w-full md:w-[85%] relative">
        {{ $slot }}

        <!-- Modal -->
        <div id="aboutModal" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>About the System</h2>
                    <button onclick="hideModal()">✕</button>
                </div>
                <div class="modal-body">
                    <h3 class="font-bold text-xl pb-1">System Overview</h3>
                    <p class="text-xs font-roboto-text">
                        Name: ICT Maintenance & Service Management System<br>
                        Purpose: This system is designed to track, manage, and analyze service requests efficiently
                        within PhilRice, ensuring timely resolution and performance monitoring.
                    </p>
                    <h3 class="font-bold pt-3 text-lg">Version and Development</h3>
                    <p class="text-xs py-1 font-roboto-text">
                        Developed By: Information Systems Division – PhilRice</p>

                    <div>
                        <span class="pt-3 font-bold">2025 Version (Current Release)</span><br>
                        <span class="pl-5 font-roboto-text text-xs">Project Lead:</span><br>
                        <span class="pl-5 font-roboto-text text-xs">Developers:</span><br>
                        <span class="pl-5 font-roboto-text text-xs">UX/UI Designers:</span><br>
                    </div>

                    <div class="mt-2">
                        <span class="font-bold pt-4">Previous Versions</span><br>
                        <span class="pl-5 font-roboto-text text-xs">Project Lead:</span><br>
                        <span class="pl-5 font-roboto-text text-xs">Developers:</span><br>
                    </div>

                    <h3 class="font-bold mt-4 text-xl font-roboto-text">Contact & Support</h3>
                    <p class="text-xs font-roboto-text pt-3">
                        For technical issues or feedback, contact: <a
                            href="mailto:isdsupport@mail.philrice.gov.ph">isdsupport@mail.philrice.gov.ph</a>
                    </p>
                    <p class="text-xs mt-4 text-center font-roboto-text"><span class="font-bold">© 2025 PhilRice -
                            Information Systems Division</span>. All rights reserved.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Color Bar -->
        <div class="fixed bottom-0 left-0 md:left-[15%] w-full md:w-[85%] flex">
            <div class="w-1/5 h-5 bg-[#0F8C3F]"></div>
            <div class="w-1/5 h-5 bg-[#3B4E57]"></div>
            <div class="w-1/5 h-5 bg-[#914D3A]"></div>
            <div class="w-1/5 h-5 bg-[#F4B861]"></div>
            <div class="w-1/5 h-5 bg-[#7A4923]"></div>
        </div>
    </div>

    <script>
        // Existing modal code
        function showModal(event) {
            event.preventDefault();
            document.getElementById('aboutModal').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('aboutModal').style.display = 'none';
        }
    </script>

</body>

</html>
