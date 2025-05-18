<x-layout>
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div x-data="{ isAddingIncident: false }">
        <!-- TITLE -->
        <div class="title flex flex-col sm:flex-row items-start sm:items-center justify-between w-full xl:w-[] mb-4">
            <!-- Left Section -->
            <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title mb-3 sm:mb-0">Incident Reports</h2>

            <!-- Search Bar & Dropdown -->
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto mb-3 sm:mb-0 font-roboto-text">
                <div class="relative text-xs w-full sm:w-auto">
                    <input type="text" placeholder="Search..."
                        class="pl-10 pr-4 py-2 w-full sm:w-80 h-6 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#007A33] focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-4 text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                    </svg>
                </div>

                @if (Auth::check() &&
                        Auth::user()->role_id == DB::table('lib_roles')->where('role_name', 'Super Administrator')->value('id'))
                    <!-- ALL TECHNICIANS Dropdown (Visible Only for Super Admin) -->
                    <select
                        class="border border-gray-300 text-gray-700 text-xs px-3 h-[25px] rounded-lg focus:ring focus:ring-green-500">
                        <option>ALL TECHNICIANS</option>
                        @foreach ($technicians as $technician)
                            <option value="{{ $technician->philrice_id }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                @endif

                <button @click="details = null; isAddingIncident = true"
                    class="bg-[#007A33] text-white text-xs py-1 rounded-lg w-[100px] sm:w-[280px] md:w-[370px] xl:w-[465px]  font-semibold">
                    ADD NEW INCIDENT
                </button>
            </div>
        </div>


        <!-- Shared Alpine Scope -->
        <div x-data="{
            details: null
        }"
            class="flex flex-col lg:flex-row gap-4 mt-3 h-auto lg:h-[590px] xl:h-[650px] w-full font-roboto-text">

            <!-- Table Section -->
            <div x-data="tableData" x-init="init()"
                class="bg-white shadow-md rounded-lg p-3 sm:p-4 w-full lg:w-[70%] flex flex-col h-auto lg:h-[590px] xl:h-[780px] overflow-hidden">
                <!-- Filters -->
                <div class="flex flex-wrap items-center justify-between p-2 rounded-lg gap-2">
                    <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-0">
                        <span class="text-gray-500 text-xs font-medium">FROM</span>
                        <input type="text" id="from-date" placeholder="Select Date"
                            class="flatpickr-input border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                        <span class="text-gray-500 text-xs font-medium">TO</span>
                        <input type="text" id="to-date" placeholder="Select Date"
                            class="flatpickr-input border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <select
                            class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                            <option>ALL TECHNICIANS</option>
                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->philrice_id }}">{{ $technician->name }}</option>
                            @endforeach
                        </select>
                        <select
                            class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                            <option>PHILRICE CES</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-auto flex-grow">
                    <table class="w-full mt-2 text-xs text-center table-auto">
                        <thead class="border-b bg-gray-100">
                            <tr class="text-left text-gray-600">
                                <th class="py-2 pl-4">No.</th>
                                <th class="py-2">Nature of Incident</th>
                                <th class="py-2">Date Reported</th>
                                <th class="py-2">Incident Name</th>
                                <th class="py-2">Reported by</th>
                                <th class="py-2">Priority Level</th>
                                <th class="py-2 pr-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr class="border-b hover:bg-gray-100 cursor-pointer text-left"
                                    @click="details = { ...item }">
                                    <td class="py-4 pl-4" x-text="item.id"></td>
                                    <td class="py-4" x-text="item.incident_nature"></td>
                                    <td class="py-4">
                                        <span x-text="$store.utils.formatDate(item.date_reported)"></span>
                                    </td>
                                    <td class="py-4 truncate max-w-[150px] overflow-hidden" x-text="item.incident_name">
                                    </td>
                                    <td class="py-4 flex justify-center">
                                        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-xs text-gray-700"
                                            x-text="$store.utils.getInitials(item.reporter_name)"></div>
                                    </td>
                                    <td class="py-4 font-bold" x-text="item.priority_level"></td>
                                    <td class="py-4 pr-4 font-medium">
                                        <span x-text="item.status"></span> <!-- Ensure the status column is displayed -->
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('ICT Main.entries')
            </div>


            <!-- Side Panel -->
            <div class="w-full lg:w-[30%] flex flex-col h-auto lg:h-[590px] xl:h-[780px]">
                <!-- Incident Details Container -->
                <div x-show="details || isAddingIncident"
                    class="w-full bg-white shadow-lg rounded-lg px-3 py-4 flex-1 flex flex-col h-auto lg:h-[590px] xl:h-[780px]"
                    x-cloak>
                    <!-- Incident Details -->
                    <div x-data="{ isEditing: false, isResolved: false }">
                        <div class="">
                                                        <template x-if="details && !isEditing && !isResolved && !isAddingIncident">
                                <div class="flex flex-col lg:h-[550px] xl:h-[750px]">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between border-b pb-2">
                                        <div class="flex items-center space-x-2">
                                            <h2 class="font-bold text-lg" x-text="details.id"></h2>
                                            <div
                                                class="px-3 py-1 text-xs font-bold text-white bg-[#007A33] rounded-full">
                                                <span class="uppercase" x-text="details.priority_level"></span> PRIORITY
                                            </div>
                                        </div>
                                        <button @click="details = null"
                                            class="text-gray-400 hover:text-gray-600 text-lg">
                                            ✕
                                        </button>
                                    </div>

                                    <!-- Incident Information -->
                                    <div class="bg-[#EEEEEE] p-3 mt-3 rounded-lg">
                                        <p class="text-xs font-bold">Subject: <span
                                                x-text="details.subject || 'N/A'"></span></p>
                                        <p class="text-xs text-gray-500">Description: <span
                                                x-text="details.description     || 'No description provided'"></span>
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs flex flex-col space-y-2">
                                        <div>
                                            <p class="text-gray-600"><span>Nature of Incident:</span>
                                                <span x-text="details.incident_nature"></span>
                                            </p>
                                            <p class="text-gray-600"><span>Date Reported:</span>
                                                <span
                                                    x-text="details.date_reported ? $store.utils.formatDate(details.date_reported) : 'Not specified'"></span>
                                            </p>
                                            <p class="text-gray-600"><span>Date of Incident:</span>
                                                <span
                                                    x-text="details.incident_date ? $store.utils.formatDate(details.incident_date) : 'Not specified'"></span>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Location of Incident: <span
                                                    x-text="details.location"></span></p>
                                            <p class="text-gray-600">Impact/s: <span
                                                    x-text="details.impact || 'Not specified'"></span></p>
                                            <p class="text-gray-600">Affected Area/s: <span
                                                    x-text="details.affected_areas || 'Not specified'"></span></p>
                                        </div>
                                    </div>

                                    <!-- Reporter Section -->
                                    <div class="mt-4 flex items-center space-x-3">
                                        <div class="size-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xl"
                                            x-text="$store.utils.getInitials(details.reporter_name)"></div>
                                        <div>
                                            <p class="text-xs text-[#000000]">Reported by:</p>
                                            <p class="text-xs text-[#000000]" x-text="details.reporter_name"></p>
                                            <p class="text-xs text-[#000000]"
                                                x-text="details.reporter_position || 'Position not specified'"></p>
                                        </div>
                                    </div>

                                    <!-- Verification/Approval Section -->
                                    <div class="mt-4 text-xs" x-show="details.verifier_name || details.approver_name">
                                        <p class="font-semibold mb-1">Verification & Approval:</p>
                                        <div class="pl-2">
                                            <p x-show="details.verifier_name" class="text-gray-700">Verified by: <span
                                                    x-text="details.verifier_name"></span></p>
                                            <p x-show="details.approver_name" class="text-gray-700">Approved by: <span
                                                    x-text="details.approver_name"></span></p>
                                        </div>
                                    </div>

                                    <!-- Edit Report -->
                                    <div class="mt-2 text-right">
                                        <a href="#" @click.prevent="isEditing = true"
                                            class="text-green-600 text-[10px] font-semibold hover:underline">Edit
                                            Report</a>
                                    </div>

                                    <!-- Action Buttons (Fixed at Bottom) -->
                                    <div class="mt-auto flex flex-col space-y-2 pt-4">
                                        <button class="bg-[#45CF7F] text-[#007A33] px-4 py-1 text-xs rounded-md w-full font-semibold">
                                            VIEW PDF
                                        </button>
                                        <button
                                            @click="details.status === 'Resolved' ?
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Already Resolved',
                                                    text: 'This incident has already been resolved.',
                                                    confirmButtonColor: '#007A33'
                                                }) :
                                                isResolved = true"
                                            :class="details.status === 'Resolved' ? 'opacity-50 cursor-not-allowed' : ''"
                                            class="bg-[#007A33] text-white px-4 py-1 text-xs rounded-md w-full font-semibold">
                                            <span x-text="details.status === 'Resolved' ? 'RESOLVED' : 'MARK AS RESOLVED'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Keep isAddingIncident template separate -->
                            <template x-if="isAddingIncident">
                                <div class="flex flex-col overflow-y-auto max-h-600px xl:h-[800px] scroll-hidden">
                                    <div class="flex items-center justify-between border-b pb-2">
                                        <h2 class="font-bold text-lg">Add New Incident</h2>
                                        <button @click="isAddingIncident = false"
                                            class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
                                    </div>

                                    <form method="POST" action="{{ route('incident_reports.store') }}"
                                        class="space-y-1 mt-3">
                                        @csrf
                                        <label class="text-xs font-medium">Priority Level</label>
                                        <select name="priority_level"
                                            class="border border-gray-300 text-gray-700 text-xs pl-2 py-1 rounded-md w-full">
                                            <option value="Low">Low Priority</option>
                                            <option value="Normal">Normal Priority</option>
                                            <option value="High">High Priority</option>
                                        </select>

                                        <label class="text-xs font-medium pt-2">Incident Name</label>
                                        <input type="text" name="incident_name"
                                            class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Incident Name" required>

                                        <label class="text-xs font-medium">Subject</label>
                                        <input type="text" name="subject"
                                            class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Brief subject of the incident">

                                        <label class="text-xs font-medium">Description</label>
                                        <textarea name="description" class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Incident Description"></textarea>

                                        <div class="flex flex-col sm:flex-row sm:space-x-2">
                                            <!-- Date of Incident -->
                                            <div class="w-full sm:w-1/2">
                                                <label class="block text-xs font-medium">Date of Incident</label>
                                                <input type="date" name="incident_date"
                                                    class="w-full text-xs p-1 border rounded-lg" required>
                                            </div>

                                            <!-- Time of Incident -->
                                            <div class="w-full sm:w-1/2 mt-1 sm:mt-0">
                                                <label class="block text-xs font-medium">Time of Incident</label>
                                                <input type="time" name="incident_time"
                                                    class="w-full text-xs p-1 border rounded-lg" required>
                                            </div>
                                        </div>

                                        <label class="text-xs font-medium">Nature of Incident</label>
                                        <input type="text" name="incident_nature"
                                            class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Nature of the incident" required>

                                        <label class="text-xs font-medium">Location of Incident</label>
                                        <select name="location"
                                            class="border border-gray-300 text-gray-700 text-xs px-3 py-2 rounded-md w-full">
                                            <option value="PhilRice Negros">PhilRice Negros</option>
                                            <option value="PhilRice CES">PhilRice CES</option>
                                            <!-- Add other locations as needed -->
                                        </select>

                                        <label class="text-xs font-medium">Impact/s</label>
                                        <input type="text" name="impact"
                                            class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Impact of the Incident">

                                        <label class="text-xs font-medium">Affected Area/s</label>
                                        <input type="text" name="affected_areas"
                                            class="border border-gray-300 text-xs px-3 py-2 rounded-md w-full"
                                            placeholder="Affected Areas">

                                        <!-- Reporter Information -->
                                        <input type="hidden" name="reporter_id" value="1">
                                        <input type="hidden" name="reporter_name" value="{{ Auth::user()->name ?? '' }}">
                                        <input type="hidden" name="reporter_position"
                                            value="{{ Auth::user()->position ?? '' }}">

                                        <!-- Verified By Field -->
                                        <div class="flex flex-col w-full pt-5 pb-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div class="mb-2 sm:mb-0">
                                                    <label class="text-xs font-medium">Verified by</label>
                                                </div>
                                                <div class="relative w-full sm:w-[70%]" x-data="{
                                                    open: false,
                                                    search: '',
                                                    verifierId: '',
                                                    verifierName: '',
                                                    verifiers: [],
                                                    async fetchVerifiers() {
                                                        try {
                                                            const response = await fetch(`{{ route('incident_reports.verifiers') }}?search=${this.search}`);
                                                            this.verifiers = await response.json();
                                                        } catch (error) {
                                                            console.error('Error fetching verifiers:', error);
                                                            this.verifiers = [];
                                                        }
                                                    },
                                                    selectVerifier(id, name) {
                                                        this.verifierId = id;
                                                        this.verifierName = name;
                                                        this.search = name;
                                                        this.open = false;
                                                    }
                                                }" x-init="$watch('search', value => {
                                                    if (value.length > 2) fetchVerifiers();
                                                    if (value.length === 0) { verifierId = ''; verifierName = ''; }
                                                    verifierName = value;
                                                })">
                                                    <input type="text" name="verifier_name" x-model="search" @focus="open = true" @blur="setTimeout(() => open = false, 200)"
                                                        class="border border-gray-300 text-gray-700 text-xs pl-10 pr-3 py-4 rounded-lg w-full"
                                                        placeholder="Type to search or enter new verifier...">
                                                    <input type="hidden" name="verifier_id" x-model="verifierId">

                                                    <div x-show="open && search.length > 2" @click.away="open = false"
                                                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                                                        <ul class="max-h-60 overflow-auto">
                                                            <template x-for="verifier in verifiers" :key="verifier.id">
                                                                <li @click="selectVerifier(verifier.id, verifier.name)"
                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs">
                                                                    <span x-text="verifier.name"></span>
                                                                    <span x-show="verifier.position" class="text-gray-500 text-xs" x-text="' - ' + verifier.position"></span>
                                                                </li>
                                                            </template>
                                                            <li x-show="verifiers.length === 0 && search.length > 2" class="px-4 py-2 text-gray-500 text-xs">
                                                                No verifiers found. Use the text entered as new verifier name.
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center">
                                                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs"
                                                            x-text="verifierName ? $store.utils.getInitials(verifierName) : ''"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Approved By Field -->
                                        <div class="flex flex-col w-full pb-5">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div class="mb-2 sm:mb-0">
                                                    <label class="text-xs font-medium">Approved by</label>
                                                </div>
                                                <div class="relative w-full sm:w-[70%]" x-data="{
                                                    open: false,
                                                    search: '',
                                                    approverId: '',
                                                    approverName: '',
                                                    approvers: [],
                                                    async fetchApprovers() {
                                                        try {
                                                            const response = await fetch(`{{ route('incident_reports.approvers') }}?search=${this.search}`);
                                                            this.approvers = await response.json();
                                                        } catch (error) {
                                                            console.error('Error fetching approvers:', error);
                                                            this.approvers = [];
                                                        }
                                                    },
                                                    selectApprover(id, name) {
                                                        this.approverId = id;
                                                        this.approverName = name;
                                                        this.search = name;
                                                        this.open = false;
                                                    }
                                                }" x-init="$watch('search', value => {
                                                    if (value.length > 2) fetchApprovers();
                                                    if (value.length === 0) { approverId = ''; approverName = ''; }
                                                    approverName = value;
                                                })">
                                                    <input type="text" name="approver_name" x-model="search" @focus="open = true" @blur="setTimeout(() => open = false, 200)"
                                                        class="border border-gray-300 text-gray-700 text-xs pl-10 pr-3 py-4 rounded-lg w-full"
                                                        placeholder="Type to search or enter new approver...">
                                                    <input type="hidden" name="approver_id" x-model="approverId">

                                                    <div x-show="open && search.length > 2" @click.away="open = false"
                                                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                                                        <ul class="max-h-60 overflow-auto">
                                                            <template x-for="approver in approvers" :key="approver.id">
                                                                <li @click="selectApprover(approver.id, approver.name)"
                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs">
                                                                    <span x-text="approver.name"></span>
                                                                    <span x-show="approver.position" class="text-gray-500 text-xs" x-text="' - ' + approver.position"></span>
                                                                </li>
                                                            </template>
                                                            <li x-show="approvers.length === 0 && search.length > 2" class="px-4 py-2 text-gray-500 text-xs">
                                                                No approvers found. Use the text entered as new approver name.
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center">
                                                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs"
                                                            x-text="approverName ? $store.utils.getInitials(approverName) : ''"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit"
                                            class="bg-[#007A33] text-white px-4 py-2 text-xs rounded-md w-full font-semibold mt-3">
                                            ADD NEW INCIDENT
                                        </button>
                                    </form>
                                </div>
                            </template>

                            <template x-if="isResolved && details && details.status !== 'Resolved'">
                                <div class="flex flex-col lg:h-[550px] xl:h-[766px]">
                                    <div class="flex items-center justify-between border-b pb-2">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h2 class="font-bold text-lg" x-text="details.id"></h2>
                                            <div
                                                class="px-3 py-1 text-xs font-bold text-white bg-[#007A33] rounded-full">
                                                <span class="uppercase" x-text="details.priority_level"></span> PRIORITY
                                            </div>
                                        </div>
                                        <button @click="details = null"
                                            class="text-gray-400 hover:text-gray-600 text-lg">
                                            ✕
                                        </button>
                                    </div>

                                    <form method="POST"
                                        :action="'{{ route('incident_reports.resolve', '') }}/' + details.id"
                                        class="flex flex-col flex-grow"
                                        @submit.prevent="
                                            Swal.fire({
                                                title: 'Confirm Resolution',
                                                text: 'Are you sure you want to mark this incident as resolved?',
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: 'Yes, resolve it',
                                                cancelButtonText: 'No, cancel',
                                                confirmButtonColor: '#007A33'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $event.target.submit();
                                                }
                                            })
                                        "
                                    >
                                        @csrf
                                        <input type="hidden" name="status" value="Resolved">
                                        <div class="mt-4">
                                            <label class="block text-xs text-gray-500 font-semibold">ISD Findings</label>
                                            <textarea name="findings"
                                                class="border p-3 mt-1 rounded-lg text-sm text-gray-700 bg-white w-full h-24"
                                                placeholder="Enter findings..."
                                                required
                                                @keydown="if($event.key === 'Enter') $event.preventDefault()"
                                            ></textarea>
                                        </div>

                                        <div class="mt-4">
                                            <label class="block text-xs text-gray-500 font-semibold">Recommendations</label>
                                            <textarea name="recommendations"
                                                class="border p-3 mt-1 rounded-lg text-sm text-gray-700 bg-white w-full h-24"
                                                placeholder="Enter recommendations..."
                                                required
                                                @keydown="if($event.key === 'Enter') $event.preventDefault()"
                                            ></textarea>
                                        </div>

                                        <div class="flex gap-2 mt-auto">
                                            <button type="button"
                                                @click="isResolved = false"
                                                class="bg-gray-500 text-white px-4 py-1 text-xs rounded-md w-full font-semibold">
                                                CANCEL
                                            </button>
                                            <button type="submit"
                                                class="bg-[#007A33] text-white px-4 py-1 text-xs rounded-md w-full font-semibold">
                                                MARK AS RESOLVED
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </template>

                            <template x-if="isEditing && !isAddingIncident">
                                <div class="flex flex-col flex-1 overflow-y-auto lg:h-[560px] xl:h-[47.5rem] scroll-hidden">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <button @click="isEditing = false"
                                                class="text-gray-500 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="3" stroke="green"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <h2 class="font-bold text-lg">Edit Report</h2>
                                        </div>
                                    </div>

                                    <!-- Edit Form -->
                                    <form method="POST"
                                        :action="'{{ route('incident_reports.update', '') }}/' + details.id"
                                        class="mt-4">
                                        @csrf
                                        @method('PUT')
                                        <div class="space-y-2">
                                            <div>
                                                <label class="text-xs text-[#707070]">Priority Level</label>
                                                <select name="priority_level"
                                                    class="w-full p-1 border text-xs rounded-lg mt-1"
                                                    x-model="details.priority_level">
                                                    <option value="Low">Low Priority</option>
                                                    <option value="Normal">Normal Priority</option>
                                                    <option value="High">High Priority</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-xs text-[#707070] mt-2">Incident Name</label>
                                                <input type="text" name="incident_name"
                                                    class="w-full p-1 border text-xs rounded-lg mt-1"
                                                    placeholder="Incident Name" x-model="details.incident_name">
                                            </div>

                                            <div>
                                                <label class="text-xs text-[#707070] mt-2">Subject</label>
                                                <input type="text" name="subject"
                                                    class="w-full p-1 border text-xs rounded-lg mt-1"
                                                    placeholder="Incident Subject" x-model="details.subject">
                                            </div>

                                            <div>
                                                <label class="text-xs text-[#707070] mt-2">Description</label>
                                                <textarea name="description" class="w-full p-1 border text-xs rounded-lg mt-1" placeholder="Incident Description"
                                                    x-model="details.description"></textarea>
                                            </div>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:space-x-4">
                                            <!-- Date of Incident -->
                                            <div class="w-full sm:w-1/2 mt-2 sm:mt-0">
                                                <label class="block text-xs text-[#707070] mt-2">Date of
                                                    Incident</label>
                                                <div class="relative">
                                                    <input type="date" name="incident_date"
                                                        class="w-full text-xs p-1 border rounded-lg mt-1"
                                                        x-model="$store.utils.formatDateForInput(details.incident_date)">
                                                </div>
                                            </div>

                                            <!-- Time of Incident -->
                                            <div class="w-full sm:w-1/2 mt-2 sm:mt-0">
                                                <label class="block text-xs text-[#707070] mt-2">Time of
                                                    Incident</label>
                                                <div class="relative">
                                                    <input type="time" name="incident_time"
                                                        class="w-full text-xs p-1 border rounded-lg mt-1"
                                                        x-model="$store.utils.extractTimeFromDate(details.incident_date)">
                                                </div>
                                            </div>
                                        </div>

                                        <label class="block text-xs text-[#707070] mt-2">Nature of Incident</label>
                                        <input type="text" name="incident_nature"
                                            class="w-full p-1 border text-xs rounded-lg mt-1"
                                            x-model="details.incident_nature">

                                        <label class="block text-xs text-[#707070] mt-2">Location of Incident</label>
                                        <select name="location" class="w-full p-1 border text-xs rounded-lg mt-1"
                                            x-model="details.location">
                                            <option value="PhilRice Negros">PhilRice Negros</option>
                                            <option value="PhilRice CES">PhilRice CES</option>
                                            <!-- Add other locations as needed -->
                                        </select>

                                        <label class="block text-xs text-[#707070] mt-2">Impact/s</label>
                                        <input type="text" name="impact"
                                            class="w-full p-1 border text-xs rounded-lg mt-1"
                                            x-model="details.impact">

                                        <label class="block text-xs text-[#707070] mt-2">Affected Area/s</label>
                                        <input type="text" name="affected_areas"
                                            class="w-full p-1 border text-xs rounded-lg mt-1"
                                            x-model="details.affected_areas">

                                        <label class="block text-xs text-[#707070] mt-2">Verifier</label>
                                        <select name="verifier_id" class="w-full p-1 border text-xs rounded-lg mt-1">
                                            <option value="">Select Verifier</option>
                                            <!-- Add options dynamically if needed -->
                                        </select>

                                        <div class="flex flex-col w-full pt-5 pb-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div class="mb-2 sm:mb-0">
                                                    <label class="text-xs font-medium">Verified by</label>
                                                </div>
                                                <div class="relative w-full sm:w-[70%]" x-data="{
                                                    open: false,
                                                    search: '',
                                                    verifierId: '',
                                                    verifierName: '',
                                                    verifiers: [],
                                                    async fetchVerifiers() {
                                                        try {
                                                            const response = await fetch(`{{ route('incident_reports.verifiers') }}?search=${this.search}`);
                                                            this.verifiers = await response.json();
                                                        } catch (error) {
                                                            console.error('Error fetching verifiers:', error);
                                                            this.verifiers = [];
                                                        }
                                                    },
                                                    selectVerifier(id, name) {
                                                        this.verifierId = id;
                                                        this.verifierName = name;
                                                        this.search = name;
                                                        this.open = false;
                                                    }
                                                }" x-init="$watch('search', value => {
                                                    if (value.length > 2) fetchVerifiers();
                                                    if (value.length === 0) { verifierId = ''; verifierName = ''; }
                                                    verifierName = value;
                                                })">
                                                    <input type="text" name="verifier_name" x-model="search" @focus="open = true" @blur="setTimeout(() => open = false, 200)"
                                                        class="border border-gray-300 text-gray-700 text-xs pl-10 pr-3 py-4 rounded-lg w-full"
                                                        placeholder="Type to search or enter new verifier...">
                                                    <input type="hidden" name="verifier_id" x-model="verifierId">

                                                    <div x-show="open && search.length > 2" @click.away="open = false"
                                                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                                                        <ul class="max-h-60 overflow-auto">
                                                            <template x-for="verifier in verifiers" :key="verifier.id">
                                                                <li @click="selectVerifier(verifier.id, verifier.name)"
                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs">
                                                                    <span x-text="verifier.name"></span>
                                                                    <span x-show="verifier.position" class="text-gray-500 text-xs" x-text="' - ' + verifier.position"></span>
                                                                </li>
                                                            </template>
                                                            <li x-show="verifiers.length === 0 && search.length > 2" class="px-4 py-2 text-gray-500 text-xs">
                                                                No verifiers found. Use the text entered as new verifier name.
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center">
                                                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs"
                                                            x-text="verifierName ? $store.utils.getInitials(verifierName) : ''"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Approved By Field -->
                                        <div class="flex flex-col w-full pb-5">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div class="mb-2 sm:mb-0">
                                                    <label class="text-xs font-medium">Approved by</label>
                                                </div>
                                                <div class="relative w-full sm:w-[70%]" x-data="{
                                                    open: false,
                                                    search: '',
                                                    approverId: '',
                                                    approverName: '',
                                                    approvers: [],
                                                    async fetchApprovers() {
                                                        try {
                                                            const response = await fetch(`{{ route('incident_reports.approvers') }}?search=${this.search}`);
                                                            this.approvers = await response.json();
                                                        } catch (error) {
                                                            console.error('Error fetching approvers:', error);
                                                            this.approvers = [];
                                                        }
                                                    },
                                                    selectApprover(id, name) {
                                                        this.approverId = id;
                                                        this.approverName = name;
                                                        this.search = name;
                                                        this.open = false;
                                                    }
                                                }" x-init="$watch('search', value => {
                                                    if (value.length > 2) fetchApprovers();
                                                    if (value.length === 0) { approverId = ''; approverName = ''; }
                                                    approverName = value;
                                                })">
                                                    <input type="text" name="approver_name" x-model="search" @focus="open = true" @blur="setTimeout(() => open = false, 200)"
                                                        class="border border-gray-300 text-gray-700 text-xs pl-10 pr-3 py-4 rounded-lg w-full"
                                                        placeholder="Type to search or enter new approver...">
                                                    <input type="hidden" name="approver_id" x-model="approverId">

                                                    <div x-show="open && search.length > 2" @click.away="open = false"
                                                        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg">
                                                        <ul class="max-h-60 overflow-auto">
                                                            <template x-for="approver in approvers" :key="approver.id">
                                                                <li @click="selectApprover(approver.id, approver.name)"
                                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs">
                                                                    <span x-text="approver.name"></span>
                                                                    <span x-show="approver.position" class="text-gray-500 text-xs" x-text="' - ' + approver.position"></span>
                                                                </li>
                                                            </template>
                                                            <li x-show="approvers.length === 0 && search.length > 2" class="px-4 py-2 text-gray-500 text-xs">
                                                                No approvers found. Use the text entered as new approver name.
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="absolute left-2 top-1/2 transform -translate-y-1/2 flex items-center">
                                                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs"
                                                            x-text="approverName ? $store.utils.getInitials(approverName) : ''"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <button type="submit"
                                            class="w-full bg-green-700 text-white py-1 mt-auto text-xs rounded-lg font-semibold">
                                            SAVE CHANGES
                                        </button>
                                    </form>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Define Alpine.store for utility functions
        document.addEventListener("alpine:init", () => {
            // Global utility store
            Alpine.store('utils', {
                formatDate(dateString) {
                    if (!dateString) return 'Not specified';
                    try {
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return 'Invalid date';

                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit'
                        }) + ' ' + date.toLocaleTimeString('en-US', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    } catch (e) {
                        console.error('Date formatting error:', e);
                        return 'Error formatting date';
                    }
                },

                getInitials(name) {
                    if (!name) return '';
                    return name.split(' ')
                        .map(part => part.charAt(0).toUpperCase())
                        .slice(0, 2)
                        .join('');
                },

                formatDateForInput(dateString) {
                    if (!dateString) return '';
                    try {
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return '';
                        return date.toISOString().split('T')[0];
                    } catch (e) {
                        console.error('Date formatting error:', e);
                        return '';
                    }
                },

                extractTimeFromDate(dateString) {
                    if (!dateString) return '';
                    try {
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return '';
                        return date.toTimeString().slice(0, 5); // Returns HH:MM format
                    } catch (e) {
                        console.error('Time extraction error:', e);
                        return '';
                    }
                }
            });

            // Table data component
            Alpine.data("tableData", () => ({
                selectedStatus: "all", // Default to show all statuses
                currentPage: 1,
                perPage: 9,

                // Replace dummy data with actual data from backend
                data: @json($incidents ?? []),

                // Debugging function to inspect data
                inspectData() {
                    console.log('Data items:', this.data);
                    if (this.data.length > 0) {
                        console.log('First item date_reported:', this.data[0].date_reported);
                        console.log('First item incident_date:', this.data[0].incident_date);
                    }
                },

                // Initialize function to debug data
                init() {
                    this.inspectData();
                },

                // Computed: Get filtered & paginated data
                get paginatedData() {
                    let filteredData = this.data.filter(item => {
                        if (this.selectedStatus === "all") return true;
                        return this.selectedStatus === "resolved" ? item.status === "Resolved" : item.status === "Not Resolved";
                    });

                    let start = (this.currentPage - 1) * this.perPage;
                    let end = start + this.perPage;

                    return filteredData.slice(start, end);
                },

                // Computed: Total pages based on filtered data
                totalPages() {
                    return Math.ceil(this.data.filter(item => {
                        if (this.selectedStatus === "all") return true;
                        return this.selectedStatus === "resolved" ? item.status === "Resolved" : item.status === "Not Resolved";
                    }).length / this.perPage);
                },

                // Computed: Visible page numbers (max 5 at a time)
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
                    this.currentPage = 1; // Reset to page 1 when changing status
                },

                // Actions: Next & Previous Page
                nextPage() {
                    if (this.currentPage < this.totalPages()) {
                        this.currentPage++;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                }
            }));
        });

        // Check for flash messages and display them with SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            // Check for success message for adding a new incident
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#007A33'
                });
            @endif

            // Check for error messages
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#007A33'
                });
            @endif

            // For form submissions, add event listeners
            const addIncidentForm = document.querySelector('form[action="{{ route('incident_reports.store') }}"]');
            if (addIncidentForm) {
                addIncidentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Adding New Incident',
                        text: 'Are you sure you want to add this incident?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#007A33',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            }

            // Add event listener for all edit forms
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.method.toLowerCase() === 'post' && form.action.includes(
                    'incident_reports/update')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Update Incident',
                        text: 'Are you sure you want to update this incident?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#007A33',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });

        // Initialize Flatpickr for date inputs
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#from-date", {
                dateFormat: "F j, Y", // Format to match the image
                allowInput: true,
            });

            flatpickr("#to-date", {
                dateFormat: "F j, Y", // Format to match the image
                allowInput: true,
            });
        });
    </script>
</x-layout>
