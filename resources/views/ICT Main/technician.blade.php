<x-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .transition {
            transition-property: opacity, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    <div x-data="technicianView">

        <!-- First view: List of technicians -->
        <div x-data="{ showAddAccount: false, showEmployeeInfo: false }" x-show="showTechnicianList && !showEditAccount"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-0 pb-2">

            <!-- Header -->
            <div class="flex items-center">
                <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Technicians</h2>
            </div>

            <!-- Main content area -->
            <div
                class="flex flex-col lg:flex-row space-y-2 lg:space-y-0 lg:space-x-2 mt-2 mr-2  h-auto xl:h-[800px] lg:h-[770px] font-roboto-text">

                <!-- Left panel: Technician list -->
                <div class="bg-white shadow-md rounded-lg sm:p-4 w-full lg:w-[40%] h-auto lg:h-full"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <!-- Search bar -->
                    <div class="flex flex-row justify-center items-center space-x-2" x-show="!showAddAccount">
                        <img src="{{ url('public/svg/technicians.svg') }}" alt="Custom SVG" class="size-6 svg-green">
                        <div class="relative flex items-center w-full">
                            <input type="text" placeholder="Search Technician"
                                x-model="searchQuery"
                                @input="filterTechnicians()"
                                class="pl-4 pr-10 py-2 w-full h-8 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#007A33] focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Technician List -->
                    <div class="mt-2 flex flex-col justify-between space-y-2 xl:h-[735px] lg:h-[700px]"
                        x-show="!showAddAccount" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="overflow-y-auto xl:h-[46rem] lg:h-[40rem] md:h-[40rem] sm:h-[30rem]">
                            <template x-for="technician in filteredTechnicians" :key="technician.philrice_id">
                                <div class="flex items-center p-3 sm:p-4 rounded-md cursor-pointer hover:bg-gray-100"
                                    @click="selectedTechnician = technician; showTechnicianList = false; showEmployeeInfo = true;">
                                    <div class="size-12 sm:size-16 bg-gray-300 rounded-full"></div>
                                    <div class="ml-3 space-y-1 sm:space-y-2">
                                        <div>
                                            <p class="font-bold text-base sm:text-lg" x-text="technician.name"></p>
                                            <p class="text-[10px] text-gray-500" x-text="strtoupper(technician.role)"></p>
                                        </div>
                                        <div>
                                            <span
                                                class="text-xs"
                                                :class="technician.status === 'active' ? 'bg-green-700 text-white px-2 py-1 rounded-lg' : 'bg-gray-500 text-white px-2 py-1 rounded-lg'"
                                                x-text="technician.status.toUpperCase()"
                                                class="px-2 py-1 rounded-lg">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- No results message -->
                            <div x-show="filteredTechnicians.length === 0" class="p-4 text-center text-gray-500">
                                No technicians found matching your search.
                            </div>
                        </div>
                        <div>
                            <button @click="showAddAccount = true"
                                class="bg-[#007A33] text-xs text-white w-full py-2 mt-4 rounded-lg">
                                ADD NEW ACCOUNT
                            </button>
                        </div>
                    </div>

                    <!-- Add New Account Section -->
                    <div x-show="showAddAccount" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-2 p-1"
                        x-data="{
                            selectedUserId: null,
                            userData: null,
                            isWorkingTechnician: false,
                            showEmployeeInfo: false,
                            workingTechnicianIds: [],
                            password: '',
                            confirmPassword: '',
                            passwordError: '',
                            
                            validateUser() {
                                if (!this.selectedUserId) return;

                                // Find user data from all users
                                const user = this.allUsers.find(u => u.philrice_id === this.selectedUserId);
                                if (user) {
                                    this.userData = user;
                                    // Check if user is already a working technician
                                    this.isWorkingTechnician = this.workingTechnicianIds.includes(this.selectedUserId);
                                    // Show employee info section
                                    this.showEmployeeInfo = true;
                                } else {
                                    this.userData = null;
                                    this.showEmployeeInfo = false;
                                }
                            },
                            
                            togglePasswordVisibility(fieldId) {
                                const field = document.getElementById(fieldId);
                                field.type = field.type === 'password' ? 'text' : 'password';
                            },
                            
                            submitNewAccount() {
                                if (this.isWorkingTechnician) return;
                                
                                // Validate passwords match if entered
                                if (this.password || document.getElementById('confirm-password').value) {
                                    if (this.password !== document.getElementById('confirm-password').value) {
                                        this.passwordError = 'Passwords do not match';
                                        return;
                                    }
                                    if (this.password.length < 6) {
                                        this.passwordError = 'Password must be at least 6 characters';
                                        return;
                                    }
                                }
                                
                                // Clear previous errors
                                this.passwordError = '';
                                
                                // Create form data
                                const formData = {
                                    philrice_id: this.userData.philrice_id,
                                    role_id: document.getElementById('employee-role').value,
                                    password: this.password,
                                    _token: '{{ csrf_token() }}'
                                };
                                
                                // Submit using fetch API
                                fetch('{{ route('technician.store') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(formData)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Show success alert
                                        Swal.fire({
                                            title: 'Success!',
                                            text: data.message,
                                            icon: 'success',
                                            confirmButtonColor: '#007A33'
                                        }).then(() => {
                                            // Reload page to show updated technicians list
                                            window.location.reload();
                                        });
                                    } else {
                                        // Show error message
                                        Swal.fire({
                                            title: 'Error',
                                            text: data.message || 'Failed to add account',
                                            icon: 'error',
                                            confirmButtonColor: '#007A33'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An unexpected error occurred',
                                        icon: 'error',
                                        confirmButtonColor: '#007A33'
                                    });
                                });
                            },

                            allUsers: []
                        }"
                        x-init="
                            workingTechnicianIds = {{ json_encode($workingTechnicianIds) }};
                            allUsers = {{ json_encode($allUsers) }};
                        ">

                        <!-- Header -->
                        <div class="flex items-center space-x-2 border-b pb-2">
                            <button @click="showAddAccount = false" class="text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <h2 class="font-bold text-lg sm:text-[20px] leading-[37px] font-roboto">Add New Account</h2>
                        </div>

                        <!-- Employee ID Section -->
                        <div class="mt-4">
                            <label for="employee-id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <div class="mt-1 flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                                <select id="employee-id" name="employee-id" x-model="selectedUserId"
                                    class="block w-full sm:w-[50%] pl-3 pr-8 py-1 lg:text-xs xl:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 xs:text-xs">
                                    <option value="">Select an Employee</option>
                                    <template x-for="user in allUsers" :key="user.philrice_id">
                                        <option :value="user.philrice_id" x-text="user.philrice_id"></option>
                                    </template>
                                </select>
                                <button @click="validateUser()"
                                    class="bg-[#007A33] w-full sm:w-[50%] h-[30px] text-white px-5 py-1 text-xs font-semibold rounded-md hover:bg-green-700">
                                    VALIDATE
                                </button>
                            </div>
                        </div>

                        <!-- Employee Information Section -->
                        <div x-show="showEmployeeInfo" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="flex flex-col mt-3 space-y-8 sm:space-y-16 justify-between xl:h-[630px]">

                            <!-- Employee Information Title -->
                            <div>
                                <h3 class="font-bold text-lg">Employee Information</h3>

                                <!-- Employee Profile Section -->
                                <div class="mt-4">
                                    <!-- Profile and Name in One Line -->
                                    <div class="flex items-center space-x-4">
                                        <!-- Profile Picture -->
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 12c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 14c-4.418 0-8 1.791-8 4v2h16v-2c0-2.209-3.582-4-8-4z" />
                                            </svg>
                                        </div>
                                        <!-- Employee Name -->
                                        <p class="font-bold xl:text-2xl sm:text-xl" x-text="userData?.name || 'No Name Found'"></p>
                                    </div>

                                    <!-- Employee Details Below -->
                                    <div class="mt-2 lg:text-[10px] xl:text-sm text-gray-600">
                                        <p><span class="text-gray-400">ID No.:</span> <span x-text="userData?.philrice_id || 'N/A'"></span></p>
                                        <p><span class="text-gray-400">Email:</span> <span x-text="userData?.email || 'N/A'"></span></p>
                                        <p><span class="text-gray-400">Position:</span> No Info</p>
                                        <p><span class="text-gray-400">Division:</span> No Info</p>
                                    </div>

                                    <!-- Working Technician Status Message -->
                                    <div class="mt-4" x-show="isWorkingTechnician">
                                        <p class="text-yellow-600 text-sm font-semibold">
                                            Note: This employee is already registered as a technician.
                                        </p>
                                    </div>
                                </div>

                                <!-- Role Selection -->
                                <div class="mt-4">
                                    <label for="employee-role"
                                        class="block lg:text-xs xl:text-sm font-medium text-gray-700"
                                        :class="{ 'opacity-50': isWorkingTechnician }">Role</label>
                                    <select id="employee-role" name="employee-role"
                                        class="block w-full mt-1 pl-3 pr-10 py-1 lg:text-xs xl:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 text-gray-700"
                                        :disabled="isWorkingTechnician"
                                        x-init="$watch('userData', value => {
                                            if (value && value.role_id) {
                                                $el.value = value.role_id;
                                            }
                                        })">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Password Fields -->
                                <div class="mt-4" :class="{ 'opacity-50': isWorkingTechnician }">
                                    <label for="password"
                                        class="block lg:text-xs xl:text-sm font-medium text-gray-700">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" x-model="password"
                                            class="block w-full pl-3 pr-10 py-1 lg:text-xs xl:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                                            :disabled="isWorkingTechnician">
                                        <button type="button" @click="togglePasswordVisibility('password')" class="absolute inset-y-0 right-3 flex items-center" :disabled="isWorkingTechnician">
                                            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4" :class="{ 'opacity-50': isWorkingTechnician }">
                                    <label for="confirm-password"
                                        class="block lg:text-xs xl:text-sm font-medium text-gray-700">Confirm Password</label>
                                    <div class="relative">
                                        <input type="password" id="confirm-password" name="confirm-password"
                                            class="block w-full pl-3 pr-10 py-1 lg:text-xs xl:text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                                            :disabled="isWorkingTechnician">
                                        <button type="button" @click="togglePasswordVisibility('confirm-password')" class="absolute inset-y-0 right-3 flex items-center" :disabled="isWorkingTechnician">
                                            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Password error message -->
                                    <p x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-1">
                                <button
                                    @click="submitNewAccount"
                                    :disabled="isWorkingTechnician || !userData"
                                    class="w-full bg-[#007A33] text-white py-2 text-xs text-center font-semibold rounded-lg shadow-md hover:bg-green-700"
                                    :class="{ 'opacity-50 cursor-not-allowed': isWorkingTechnician || !userData }">
                                    ADD NEW ACCOUNT
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right panel: Rankings and data -->
                <div x-show="!showAddAccount" x-data="tableData"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="bg-white w-full lg:w-[60%] rounded-lg px-5 py-3 relative shadow-md flex flex-col xl:h-[800px] lg:h-[770px] overflow-hidden font-roboto-text">

                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center border-gray-300 pb-2 gap-2">
                        <!-- Left Section: Title & Date Range -->
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3 justify-between w-full">
                            <div>
                                <h2 class="text-lg font-semibold"
                                    x-text="'Top Performing Technicians for ' + selectedMonth">Top Performing
                                    Technicians for February</h2>
                            </div>

                            <!-- Dropdowns -->
                            <div class="flex flex-wrap gap-2">
                                <select x-model="selectedMonth"
                                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[25px] rounded-md focus:ring focus:ring-green-500">
                                    <template x-for="month in months" :key="month">
                                        <option :value="month" x-text="month"></option>
                                    </template>
                                </select>
                                <select
                                    class="border border-gray-300 text-gray-700 text-xs px-3 h-[25px] rounded-md focus:ring focus:ring-green-500">
                                    <option>Completion Rate</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Ranking Circles -->
                    <div class="flex flex-wrap justify-around mt-4 gap-4">
                        <div class="flex flex-col items-center">
                            <div
                                class="relative size-24 sm:size-32 bg-gray-300 rounded-full border-2 border-[#FCA311] flex items-center justify-center">
                                <div
                                    class="absolute -top-4 right-1/2 transform translate-x-1/2 size-6 sm:size-8 bg-[#FCA311] rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs sm:text-base">1</span>
                                </div>
                            </div>
                            <p class="mt-2 text-green-700 font-bold text-xs sm:text-sm" x-text="topTechnicians[0]">
                            </p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div
                                class="relative size-24 sm:size-32 bg-gray-300 rounded-full border-2 border-[#FCA311] flex items-center justify-center">
                                <div
                                    class="absolute -top-4 right-1/2 transform translate-x-1/2 size-6 sm:size-8 bg-[#FCA311] rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs sm:text-base">2</span>
                                </div>
                            </div>
                            <p class="mt-2 text-green-700 font-bold text-xs sm:text-sm" x-text="topTechnicians[1]">
                            </p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div
                                class="relative size-24 sm:size-32 bg-gray-300 rounded-full border-2 border-[#FCA311] flex items-center justify-center">
                                <div
                                    class="absolute -top-4 right-1/2 transform translate-x-1/2 size-6 sm:size-8 bg-[#FCA311] rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs sm:text-base">3</span>
                                </div>
                            </div>
                            <p class="mt-2 text-green-700 font-bold text-xs sm:text-sm" x-text="topTechnicians[2]">
                            </p>
                        </div>
                    </div>

                    <!-- Table (Takes Remaining Space) -->
                    <div class="overflow-x-auto flex-grow mt-4">
                        <table class="w-full border-collapse mt-6 h-auto">
                            <thead>
                                <tr class="text-gray-600 uppercase text-sm border-b">
                                    <th class="py-1 sm:px-2 xl:px-1">
                                        Rank

                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Technician

                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Picked
                                        <button @click="sortTable('picked')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="gray" class="size-3">
                                                <path fill-rule="evenodd"
                                                    d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Completed
                                        <button @click="sortTable('completed')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="gray" class="size-3">
                                                <path fill-rule="evenodd"
                                                    d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Completion Rate %
                                        <button @click="sortTable('rate')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="gray" class="size-3">
                                                <path fill-rule="evenodd"
                                                    d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Resolution
                                        <button @click="sortTable('resolution')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="gray" class="size-3">
                                                <path fill-rule="evenodd"
                                                    d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </th>
                                    <th class="py-1 px-1 sm:px-2 text-left">
                                        Rating
                                        <button @click="sortTable('rating')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="gray" class="size-3">
                                                <path fill-rule="evenodd"
                                                    d="M6.97 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06L8.25 4.81V16.5a.75.75 0 0 1-1.5 0V4.81L3.53 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5Zm9.53 4.28a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V7.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(technician, index) in paginatedTechnicians"
                                    :key="index">dex">
                                    <tr class="border-b text-gray-700 text-sm  hover:bg-gray-100 cursor-pointer">
                                        <td class="xl:py-4 lg:py-3 sm:py-2 font-bold"
                                            x-text="((currentPage-1) * perPage) + index + 1"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2 font-bold truncate max-w-[100px] sm:max-w-none"
                                            x-text="technician.name"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2" x-text="technician.picked_count"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2" x-text="technician.completed_count"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2" x-text="technician.completion_rate"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2" x-text="technician.turnaround_time || '0 days 0 hrs 0 min 0 sec'"></td>
                                        <td class="xl:py-4 lg:py-3 sm:py-2" x-text="technician.rating"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination (Always at Bottom) -->
                    @include('ICT Main.entries')
                </div>
            </div>
        </div>

        <!-- Second view: Technician details -->
        <div x-show="!showTechnicianList && !showEditAccount" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-0">

            <!-- Header section with date filters -->
            <div class="flex flex-col sm:flex-row justify-between">
                <div class="flex items-center sm:mb-0">
                    <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Technicians</h2>
                </div>
                <div class="flex flex-wrap items-center gap-2 bg-[#F5F7FA] p-2 rounded-lg font-roboto-text">
                    <span class="text-gray-500 text-xs font-medium">FROM</span>
                    <input type="date" id="from-date" x-model="from" @change="updateRange"
                        class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                    <span class="text-gray-500 text-xs font-medium">TO</span>
                    <input type="date" id="to-date" x-model="to" @change="updateRange"
                        class="border border-gray-300 text-gray-700 text-xs px-3 h-[30px] rounded-md focus:ring focus:ring-green-500">
                </div>
            </div>

            <!-- Main content with technician info and stats -->
            <div class="flex flex-col lg:flex-row gap-4 mt-2 mr-2 h-auto lg:h-[600px] xl:h-[800px] font-roboto-text">
                <!-- Left panel: Technician details and request cards -->
                <div class="bg-white shadow rounded-lg p-3 sm:p-4 w-full lg:w-1/3  lg:h-full overflow-auto"
                    x-data="{ showTechnicians: false }">
                    <!-- Search/back section -->
                    <div class="flex flex-row justify-center items-center space-x-2 mb-3">
                        <img src="{{ url('public/svg/technicians.svg') }}" alt="Custom SVG" class="size-6 svg-green"
                            @click="showTechnicianList = true">
                        <div class="relative w-full">
                            <input type="text" placeholder="Search Technician" @focus="showTechnicians = true"
                                class="pl-4 pr-10 py-2 w-full h-8 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#007A33] focus:outline-none">
                            <span class="cursor-pointer" @click="showTechnicians = false">
                                <i class="fas fa-times"></i>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor"
                                class="w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Technician profile info -->
                    <div class="flex flex-col justify-between xl:h-[700px] space-y-4">
                        <div class="flex flex-row items-center text-left mt-4 space-y-2">
                            <div class="xl:size-20 sm:w-16 sm:h-16 bg-gray-300 rounded-full"></div>
                            <div class="flex flex-col justify-start ml-4">
                                <h2 class="xl:text-2xl sm:text-lg font-bold"
                                    x-text="selectedTechnician.name || selectedTechnician"></h2>
                                <p class="text-xs text-gray-500"
                                    x-text="selectedTechnician.role ? selectedTechnician.role.toUpperCase() : 'N/A'">
                                </p>
                                <div>
                                    <span
                                        x-bind:class="selectedTechnician.status === 'active' ? 'bg-green-600' : 'bg-gray-500'"
                                        class="text-white text-xs font-semibold py-1 px-3 rounded-lg inline-flex items-center">
                                        <span
                                            x-text="selectedTechnician.status ? selectedTechnician.status.toUpperCase() : 'ACTIVE'"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Edit link -->
                        <div class="mt-3 flex justify-end">
                            <a href="#" class="text-xs text-green-600"
                                @click.prevent="showEditAccount = true">Edit Account</a>
                        </div>

                        <!-- Technician Details -->
                        <div class="text-sm text-gray-600 mt-2 space-y-1">
                            <p><span class="font-semibold">ID No.:</span> <span
                                    x-text="selectedTechnician.philrice_id || 'N/A'"></span></p>
                            <p><span class="font-semibold">Email:</span> <span
                                    x-text="selectedTechnician.email || 'N/A'"></span></p>
                            <p><span class="font-semibold">Position:</span> <span
                                    x-text="selectedTechnician.position || 'N/A'"></span></p>
                            <p><span class="font-semibold">Division:</span> <span
                                    x-text="selectedTechnician.division || 'N/A'"></span></p>
                        </div>

                        <!-- Request Cards -->
                        <div class="flex flex-grow flex-col mt-7 space-y-4 items-center w-full">
                            @php
                                $requestCards = [
                                    'picked' => 'Picked Requests',
                                    'ongoing' => 'Ongoing Services',
                                    'completed' => 'Completed Services',
                                    'customer_feed' => 'Customer Feedback',
                                ];
                            @endphp

                            @foreach ($requestCards as $status => $label)
                                <div class="cursor-pointer w-full" onclick="updateTable('{{ $status }}')">
                                    <div
                                        class="flex items-center bg-white shadow-md rounded-lg w-full lg:h-[70px] xl:h-[100px] transition-transform duration-200">
                                        <!-- Icon Box -->
                                        <div
                                            class="bg-[#101C35] lg:w-[70px] xl:w-[90px] sm:w-[80px] h-full flex items-center justify-center rounded-lg hover:bg-[#0F8C3F] transition-colors duration-300">
                                            @if ($status == 'picked')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="size-7 sm:size-8">
                                                    <path
                                                        d="m18 5-2.414-2.414A2 2 0 0 0 14.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.828A2 2 0 0 0 18 5z" />
                                                    <path
                                                        d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                                    <path d="M8 18h1" />
                                                </svg>
                                            @elseif($status == 'ongoing')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="size-7 sm:size-8">
                                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                                    <path d="M3 3v5h5" />
                                                    <path d="M12 7v5l4 2" />
                                                </svg>
                                            @elseif ($status == 'customer_feed')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="white" class="w-7 h-7 sm:w-8 sm:h-8">
                                                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                                    <path d="M18 21a6 6 0 0 0-12 0" />
                                                    <path d="M20 8v6m3-3h-6" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                                                    class="size-8 sm:size-10">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="ml-2 sm:ml-4 flex-grow">
                                            <p class="text-green-600 text-xs sm:text-sm font-medium xl:text-base">
                                                {{ $label }}
                                            </p>
                                            @if ($status == 'picked')
                                                <div class="flex items-baseline space-x-2">
                                                    <p class="xl:text-4xl sm:text-2xl font-bold"
                                                        x-text="selectedTechnician.counts?.picked || '0'"></p>
                                                </div>
                                            @elseif ($status == 'ongoing')
                                                <div class="flex items-baseline space-x-2">
                                                    <p class="xl:text-4xl sm:text-2xl font-bold"
                                                        x-text="selectedTechnician.counts?.ongoing || '0'"></p>
                                                    <p class="text-[10px] xl:text-xs text-gray-500"
                                                        x-text="`${selectedTechnician.counts?.paused || '0'} paused`">
                                                    </p>
                                                </div>
                                            @elseif ($status == 'completed')
                                                <div class="flex items-center space-x-2">
                                                    <p class="xl:text-4xl sm:text-2xl font-bold"
                                                        x-text="selectedTechnician.counts?.completed || '0'"></p>
                                                    <div class="flex flex-col leading-tight mt-[-2px]">
                                                        <p class="text-[10px] xl:text-xs text-gray-400"
                                                            x-text="`${selectedTechnician.counts?.other_completed || '0'} other`">
                                                        </p>
                                                        <p class="text-[10px] xl:text-xs text-gray-500"
                                                            x-text="`${selectedTechnician.counts?.evaluated || '0'} evaluated`">
                                                        </p>
                                                    </div>
                                                </div>
                                            @elseif ($status == 'customer_feed')
                                                <div class="flex items-center space-x-2">
                                                    <p class="xl:text-4xl sm:text-2xl font-bold"
                                                        x-text="`${selectedTechnician.rating?.percentage || '0'}%`">
                                                    </p>
                                                    <span class="text-gray-600 text-xs sm:text-sm"
                                                        x-text="selectedTechnician.rating?.text || 'N/A'"></span>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ url('/' . $status) }}" class="text-black-600 pr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                class="w-6 h-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right panel: Statistics cards and summary -->
                <div class="flex flex-col w-full lg:w-2/3 space-y-4">
                    <!-- Stats Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                        <!-- Card 1: Average Turnaround Time -->
                        <div
                            class="flex items-center bg-white shadow-md rounded-lg w-full xl:h-[100px] lg:h-[80px] transition-transform duration-200">
                            <div
                                class="bg-[#101C35] xl:w-[90px] lg:w-[70px] sm:w-[80px] h-full flex items-center justify-center rounded-lg">
                                <img src="{{ url('public/svg/turnaroundTime.svg') }}" alt="Custom SVG"
                                    class="size-7 sm:size-9 filter-white">
                            </div>
                            <div class="ml-3 sm:ml-4">
                                <p class="text-green-600 lg:text-xs xl:text-lg sm:text-sm font-medium">Average
                                    Turnaround Time</p>
                                <p class="lg:text-xl xl:text-3xl sm:text-2xl font-bold average-turnaround-time"
                                    x-text="selectedTechnician.turnaround_time || '0 days 0 hrs 0 min 0 sec'"></p>
                            </div>
                        </div>

                        <!-- Card 2: Most office Served -->
                        <div
                            class="flex items-center bg-white shadow-md rounded-lg w-full xl:h-[100px] lg:h-[80px] transition-transform duration-200">
                            <div
                                class="bg-[#101C35] xl:w-[90px] lg:w-[70px] sm:w-[80px] h-full flex items-center justify-center rounded-lg">
                                <img src="{{ url('public/svg/office.svg') }}" alt="Custom SVG"
                                    class="size-7 sm:size-9 filter-white">
                            </div>
                            <div class="ml-3 sm:ml-4">
                                <p class="text-green-600 lg:text-xs xl:text-lg sm:text-sm font-medium">Most Office
                                    Served</p>
                                <div class="flex items-baseline space-x-2">
                                    <p class="xl:text-2xl sm:text-xl font-bold"
                                        x-text="
                                        selectedTechnician.most_serviced_office ?
                                        (selectedTechnician.most_serviced_office.includes(',') ?
                                            selectedTechnician.most_serviced_office.split(',')[0].trim() :
                                            selectedTechnician.most_serviced_office) :
                                        'No Office Served'
                                    ">
                                    </p>
                                    <p class="text-xs text-gray-500 mt-[-2px]"
                                        x-text="selectedTechnician.most_serviced_office_count ? `${selectedTechnician.most_serviced_office_count} services` : '0 services'">
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Most Serviced Category -->
                        <div
                            class="flex items-center bg-white shadow-md rounded-lg w-full xl:h-[100px] lg:h-[80px] transition-transform duration-200">
                            <div
                                class="bg-[#101C35] xl:w-[90px] lg:w-[70px] sm:w-[80px] h-full flex items-center justify-center rounded-lg">
                                <img src="{{ url('public/svg/servicedCategory.svg') }}" alt="Custom SVG"
                                    class="w-7 h-7 sm:w-9 sm:h-9 filter-white">
                            </div>
                            <div class="ml-3 sm:ml-4">
                                <p class="text-green-600 lg:text-xs xl:text-lg sm:text-sm font-medium">Most Serviced
                                    Category</p>
                                <p class="xl:text-2xl sm:text-xl font-bold truncate"
                                    x-text="selectedTechnician.most_serviced_category || 'No Services Yet'"></p>
                            </div>
                        </div>

                        <!-- Card 4: Total Incidents Reported -->
                        <div
                            class="flex items-center bg-white shadow-md rounded-lg w-full xl:h-[100px] lg:h-[80px] transition-transform duration-200">
                            <div
                                class="bg-[#101C35] xl:w-[90px] lg:w-[70px] sm:w-[80px] h-full flex items-center justify-center rounded-lg">
                                <img src="{{ url('public/svg/incidentReport.svg') }}" alt="Custom SVG"
                                    class="size-7 sm:size-9 filter-white">
                            </div>
                            <div class="ml-3 sm:ml-4">
                                <p class="text-green-600 lg:text-xs xl:text-lg sm:text-sm font-medium">Total
                                    Incidents Reported</p>
                                <p class="xl:text-4xl sm:text-2xl font-bold"
                                    x-text="selectedTechnician.counts?.incidents || '0'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Panel -->
                    <div class="bg-white shadow rounded-lg p-3 sm:p-4 h-auto lg:h-[410px] xl:h-[565px]">
                        <!-- Header Section -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10">
                            <h2 class="text-lg xl:text-2xl font-bold mb-2 sm:mb-0">Summary</h2>
                            <div class="flex flex-wrap items-center gap-2 lg:text-[10px] xl:text-xs text-gray-500">
                                <div class="text-right">
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
                                <a href="{{ url('/analytics') }}" class="text-black-600 pr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor"
                                        class="w-6 h-6 hover:text-[#0F8C3F] transition-colors duration-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Main Content (Chart + Total Requests) -->
                        <div
                            class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 h-auto xl:h-[450px] md:h-[320px]">
                            <!-- Summary Chart Section -->
                            <div class="flex flex-col items-center flex-1 space-y-1">
                                <div class="w-full xl:w-[70%] sm:w-[70%] flex justify-center mt-2">
                                    <canvas id="summaryChart"></canvas>
                                </div>
                                <div class="flex flex-row justify-around w-full xl:text-lg lg:text-xs sm:text-sm">
                                    <div class="text-yellow-500 font-bold"
                                        x-html="`${calculatePercentage('picked')}% <br> Picked`"></div>
                                    <div class="text-orange-500 font-bold"
                                        x-html="`${calculatePercentage('ongoing')}% <br> Ongoing`"></div>
                                    <div class="text-blue-600 font-bold"
                                        x-html="`${calculatePercentage('completed')}% <br> Completed`"></div>
                                </div>
                            </div>

                            <!-- Divider Line -->
                            <div class="hidden md:block w-px bg-gray-300"></div>
                            <hr class="block md:hidden border-gray-300" />

                            <!-- Total Requests Section -->
                            <div class="flex-1 overflow-y-auto pr-1 max-h-[200px] md:max-h-none">
                                <h3 class="text-sm font-bold">Total Requests</h3>
                                <p class="text-2xl font-bold mt-1" x-text="selectedTechnician.requests?.total || '0'">0</p>
                                <ul class="mt-2 xl:space-y-3 lg:space-y-1 md:space-y-1 sm:space-y-1 xl:text-sm lg:text-xs md:text-xs sm:text-xs">
                                    <template x-for="category in selectedTechnician.requests?.categories || []" :key="category.id">
                                        <li class="flex justify-between">
                                            <span x-text="category.category_name">Category Name</span>
                                            <span class="font-bold" x-text="category.request_count">0</span>
                                        </li>
                                    </template>

                                    <!-- Show "Other Categories" row if there are more categories beyond the top 10 -->
                                    <template x-if="selectedTechnician.requests?.other_categories_count > 0">
                                        <li class="flex justify-between text-gray-500">
                                            <span>Other Categories</span>
                                            <span class="font-bold" x-text="selectedTechnician.requests.other_categories_count">0</span>
                                        </li>
                                    </template>

                                    <template x-if="!selectedTechnician.requests?.categories || selectedTechnician.requests.categories.length === 0">
                                        <li class="text-gray-500 italic">No requests found</li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third view: Edit account -->
        <div x-show="showEditAccount" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-12">
            <div class="flex flex-col lg:flex-row gap-4 mt-6 mr-2 h-auto lg:h-[600px] font-roboto-text">
                <!-- Edit Account Form -->
                <div class="bg-white shadow-md rounded-lg p-4 w-1/3">
                    <div class="flex items-center space-x-2  border-b">
                        <button @click="showEditAccount = false"
                            class="text-green-600 text-sm font-semibold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="font-bold text-lg">Edit Account</h2>
                    </div>
                    <div class="flex flex-col mb-4 p-4 w-full">
                        <div class="flex flex-row items-center">
                            <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
                            <div class="ml-4">
                                <p class="font-bold text-lg" x-text="selectedTechnician.name"></p>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <p><span class="text-gray-400">ID No.:</span> <span
                                    x-text="selectedTechnician.philrice_id"></span></p>
                            <p><span class="text-gray-400">Email:</span> <span
                                    x-text="selectedTechnician.email"></span></p>
                            <p><span class="text-gray-400">Position:</span> <span
                                    x-text="selectedTechnician.position"></span></p>
                            <p><span class="text-gray-400">Division:</span> <span
                                    x-text="selectedTechnician.division"></span></p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between h-[58%]">
                        <div>
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select id="role" name="role" x-model="selectedTechnician.role"
                                    class="block w-full mt-1 border border-gray-300 font-roboto-text rounded-md px-3 py-2">
                                    <option value="Technician">Technician</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Station Technician">Station Technician</option>
                                </select>
                            </div>

                            <!-- Password field -->
                            <div class="mb-4 relative">
                                <label for="tech-password" class="block text-xs font-medium text-gray-700">New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="tech-password" name="password"
                                        class="w-full px-4 py-2 border rounded-md text-xs focus:ring focus:ring-green-300 pr-10">
                                    <button type="button" onclick="togglePassword('tech-password')"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                                        <svg id="eye-open-tech-password" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="size-4 hidden">
                                            <path
                                                d="M1.181 12C2.121 6.88 6.608 3 12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066zm10.237 10.238l-1.464-1.464a3 3 0 0 1-4.001-4.001L7.828 9.243a5 5 0 0 0 6.929 6.929zM7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592l-3.86-3.86a5 5 0 0 0-5.68-5.68L7.974 3.761z" />
                                        </svg>
                                        <svg id="eye-closed-tech-password" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="size-4 ">
                                            <path
                                                d="M4.52 5.934L1.393 2.808l1.415-1.415 19.799 19.8-1.415 1.414-3.31-3.31A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066zm10.237 10.238l-1.464-1.464a3 3 0 0 1-4.001-4.001L7.828 9.243a5 5 0 0 0 6.929 6.929zM7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592l-3.86-3.86a5 5 0 0 0-5.68-5.68L7.974 3.761z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="mb-4 relative">
                                <label for="tech-confirm-password"
                                    class="block text-xs font-medium text-gray-700">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" id="tech-confirm-password" name="confirm-password"
                                        required
                                        class="w-full px-4 py-2 border rounded-md text-xs focus:ring focus:ring-green-300 pr-10">
                                    <button type="button" onclick="togglePassword('tech-confirm-password')"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                                        <svg id="eye-open-tech-confirm-password" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="size-4 hidden">
                                            <path
                                                d="M1.181 12C2.121 6.88 6.608 3 12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066zm10.237 10.238l-1.464-1.464a3 3 0 0 1-4.001-4.001L7.828 9.243a5 5 0 0 0 6.929 6.929zM7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592l-3.86-3.86a5 5 0 0 0-5.68-5.68L7.974 3.761z" />
                                        </svg>
                                        <svg id="eye-closed-tech-confirm-password" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="size-4 ">
                                            <path
                                                d="M4.52 5.934L1.393 2.808l1.415-1.415 19.799 19.8-1.415 1.414-3.31-3.31A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066zm10.237 10.238l-1.464-1.464a3 3 0 0 1-4.001-4.001L7.828 9.243a5 5 0 0 0 6.929 6.929zM7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592l-3.86-3.86a5 5 0 0 0-5.68-5.68L7.974 3.761z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="flex gap-2">
                            <button @click="archiveTechnician(selectedTechnician)"
                                class="w-1/2 bg-[#45CF7F] text-xs hover:bg-green-500 text-[#004D1E] font-roboto-button py-2 rounded-lg">
                                DELETE
                            </button>
                            <button @click="updateTechnician(selectedTechnician)"
                                class="w-1/2 bg-[#007A33] text-xs hover:bg-green-800 text-white font-roboto-button py-2 rounded-lg">
                                SAVE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Define togglePassword in global scope
        window.togglePassword = function(fieldId) {
            const input = document.getElementById(fieldId);
            const eyeOpen = document.getElementById(`eye-open-${fieldId}`);
            const eyeClosed = document.getElementById(`eye-closed-${fieldId}`);

            if (!input || !eyeOpen || !eyeClosed) {
                console.error('Elements not found for', fieldId);
                return;
            }

            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            eyeOpen.classList.toggle("hidden", isHidden);
            eyeClosed.classList.toggle("hidden", !isHidden);
        };

        document.addEventListener("alpine:init", () => {
            Alpine.data("tableData", () => ({
                selectedStatus: "picked",
                currentPage: 1,
                perPage: 8,
                topTechnicians: @json($technicians->take(3)->pluck('name')),
                selectedMonth: new Date().toLocaleString('default', {
                    month: 'long'
                }),
                months: ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ],

                // Main data array for technicians
                techniciansData: [
                    @foreach ($technicians as $technician)
                        {
                            name: "{{ $technician['name'] }}",
                            philrice_id: "{{ $technician['philrice_id'] }}",
                            picked_count: {{ $technician['counts']['picked'] ?? 0 }},
                            completed_count: {{ $technician['counts']['other_completed'] ?? 0 }},
                            completion_rate: "{{ $technician['completion_rate'] ?? '0%' }}",
                            turnaround_time: "{{ $technician['turnaround_time'] ?? '0 days 0 hrs 0 min 0 sec' }}",
                            rating: "{{ $technician['rating']['display'] ?? 'Not rated' }}"
                        },
                    @endforeach
                ],

                // Computed property to get paginated technicians
                get paginatedTechnicians() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.techniciansData.slice(start, end);
                },

                // Data accessor for pagination component
                get data() {
                    return this.techniciansData;
                },

                // Total pages calculation for pagination
                totalPages() {
                    return Math.ceil(this.techniciansData.length / this.perPage);
                },

                // Generate visible page numbers for pagination
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

                // Page navigation methods
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

                // Sorting function for table headers
                sortTable(column) {
                    // Define sorting logic based on column
                    this.techniciansData.sort((a, b) => {
                        if (column === 'name') {
                            return a.name.localeCompare(b.name);
                        } else if (column === 'rank') {
                            return 0; // Already sorted by index
                        } else if (column === 'picked') {
                            return b.picked_count - a.picked_count;
                        } else if (column === 'completed') {
                            return b.completed_count - a.completed_count;
                        } else if (column === 'rate') {
                            // Extract percentage value for comparison
                            const rateA = parseFloat(a.completion_rate);
                            const rateB = parseFloat(b.completion_rate);
                            return rateB - rateA;
                        } else if (column === 'resolution') {
                            return a.resolution_time.localeCompare(b.resolution_time);
                        } else if (column === 'rating') {
                            return a.rating.localeCompare(b.rating);
                        }
                        return 0;
                    });
                },

                // Function to update technician data
                updateTechnicianData(philriceId, newData) {
                    const techIndex = this.techniciansData.findIndex(tech => tech.philrice_id === philriceId);
                    if (techIndex >= 0) {
                        this.techniciansData[techIndex] = { ...this.techniciansData[techIndex], ...newData };
                    }
                }
            }));

            Alpine.data('dateRange', () => ({
                from: '',
                to: '',
                get formattedDateRange() {
                    if (!this.from && !this.to) {
                        return 'All dates';
                    } else if (this.from && !this.to) {
                        return `From ${this.formatDate(this.from)}`;
                    } else if (!this.from && this.to) {
                        return `Until ${this.formatDate(this.to)}`;
                    } else {
                        return `${this.formatDate(this.from)} to ${this.formatDate(this.to)}`;
                    }
                },
                formatDate(dateStr) {
                    if (!dateStr) return '';
                    let options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return new Date(dateStr).toLocaleDateString('en-US', options);
                },
                updateRange() {
                    // Force Alpine to update the display
                    this.formattedDateRange;
                }
            }));

            // Add a new Alpine.js data component for the chart and technician data
            Alpine.data('technicianStats', () => ({
                chartInstance: null,

                // Calculate percentages based on technician's counts
                calculatePercentage(status) {
                    if (!this.selectedTechnician || !this.selectedTechnician.counts) {
                        return 0;
                    }

                    const completed = parseInt(this.selectedTechnician.counts.completed || 0);
                    const ongoing = parseInt(this.selectedTechnician.counts.ongoing || 0);
                    const picked = parseInt(this.selectedTechnician.counts.picked || 0);
                    const total = completed + ongoing + picked;

                    if (total === 0) return 0;

                    switch (status) {
                        case 'completed':
                            return Math.round((completed / total) * 100);
                        case 'ongoing':
                            return Math.round((ongoing / total) * 100);
                        case 'picked':
                            return Math.round((picked / total) * 100);
                        default:
                            return 0;
                    }
                },

                // Initialize the chart with technician data
                initChart() {
                    const ctx = document.getElementById("summaryChart").getContext("2d");
                    this.chartInstance = new Chart(ctx, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                    data: [40, 60], // Will be updated with actual data
                                    backgroundColor: ["#F3F4F6",
                                    "#3B4E57"], // Dark Blue + Light Gray
                                    borderWidth: 5,
                                    cutout: "45%",
                                    borderRadius: 10,
                                },
                                {
                                    data: [75, 25], // Will be updated with actual data
                                    backgroundColor: ["#F3F4F6",
                                    "#914D3A"], // Brown + Light Gray
                                    borderWidth: 5,
                                    cutout: "45%",
                                    borderRadius: 10,
                                },
                                {
                                    data: [90, 10], // Will be updated with actual data
                                    backgroundColor: ["#F3F4F6",
                                    "#F4B861"], // Light Brown/Orange + Light Gray
                                    borderWidth: 5,
                                    cutout: "45%",
                                    borderRadius: 10,
                                }
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
                },

                // Update chart with the latest technician stats
                updateChart() {
                    if (!this.chartInstance) {
                        this.initChart();
                        return;
                    }

                    const completedPercent = this.calculatePercentage('completed');
                    const ongoingPercent = this.calculatePercentage('ongoing');
                    const pickedPercent = this.calculatePercentage('picked');

                    // Update each ring of the doughnut chart
                    this.chartInstance.data.datasets[0].data = [100 - completedPercent,
                        completedPercent];
                    this.chartInstance.data.datasets[1].data = [100 - ongoingPercent, ongoingPercent];
                    this.chartInstance.data.datasets[2].data = [100 - pickedPercent, pickedPercent];

                    this.chartInstance.update();
                }
            }));

            // Initialize the chart when the document is ready
            document.addEventListener('DOMContentLoaded', function() {
                const technicianStatsComponent = Alpine.store('technicianStats');
                if (technicianStatsComponent) {
                    technicianStatsComponent.initChart();
                }
            });

            // Replace the existing chart initialization with our new approach
            const ctx = document.getElementById("summaryChart").getContext("2d");
            let summaryChart = new Chart(ctx, {
                type: "doughnut",
                data: {
                    datasets: [{
                            data: [40, 60], // Placeholder data
                            backgroundColor: ["#F3F4F6", "#3B4E57"], // Dark Blue + Light Gray
                            borderWidth: 5,
                            cutout: "45%",
                            borderRadius: 10,
                        },
                        {
                            data: [75, 25], // Placeholder data
                            backgroundColor: ["#F3F4F6", "#914D3A"], // Brown + Light Gray
                            borderWidth: 5,
                            cutout: "45%",
                            borderRadius: 10,
                        },
                        {
                            data: [90, 10], // Placeholder data
                            backgroundColor: ["#F3F4F6", "#F4B861"], // Light Brown/Orange + Light Gray
                            borderWidth: 5,
                            cutout: "45%",
                            borderRadius: 10,
                        },
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                    },
                    layout: {
                        padding: 20
                    }
                }
            });

            // Function to calculate percentages based on technician's counts
            window.calculatePercentage = function(status, technician) {
                if (!technician || !technician.counts) {
                    return 0;
                }

                const completed = parseInt(technician.counts.completed || 0);
                const ongoing = parseInt(technician.counts.ongoing || 0);
                const picked = parseInt(technician.counts.picked || 0);
                const total = completed + ongoing + picked;

                if (total === 0) return 0;

                switch (status) {
                    case 'completed':
                        return Math.round((completed / total) * 100);
                    case 'ongoing':
                        return Math.round((ongoing / total) * 100);
                    case 'picked':
                        return Math.round((picked / total) * 100);
                    default:
                        return 0;
                }
            };

            // Update chart whenever the selected technician changes
            window.updateSummaryChart = function(technician) {
                if (!summaryChart || !technician || !technician.counts) {
                    return;
                }

                const completedPercent = calculatePercentage('completed', technician);
                const ongoingPercent = calculatePercentage('ongoing', technician);
                const pickedPercent = calculatePercentage('picked', technician);

                // Update each ring of the doughnut chart
                summaryChart.data.datasets[0].data = [100 - completedPercent, completedPercent];
                summaryChart.data.datasets[1].data = [100 - ongoingPercent, ongoingPercent];
                summaryChart.data.datasets[2].data = [100 - pickedPercent, pickedPercent];

                // Update the percentage display text elements
                document.querySelector('.text-blue-600').innerHTML = `${completedPercent}% <br> Completed`;
                document.querySelector('.text-orange-500').innerHTML = `${ongoingPercent}% <br> Ongoing`;
                document.querySelector('.text-yellow-500').innerHTML = `${pickedPercent}% <br> Picked`;

                summaryChart.update();
            };
        });

        // Modify the Alpine.js component initialization to include the reactive technician data
        document.addEventListener('alpine:init', () => {
            // ...existing Alpine.data definitions...

            // Add to the main x-data component
            Alpine.data('technicianView', () => ({
                showTechnicianList: true,
                selectedTechnician: '',
                from: '',
                to: '',
                showEditAccount: false,
                searchQuery: '',
                allTechnicians: @json($technicians), // Store all technicians for filtering

                // Add this computed property for filtered technicians
                get filteredTechnicians() {
                    if (!this.searchQuery.trim()) {
                        return this.allTechnicians;
                    }

                    const query = this.searchQuery.toLowerCase();
                    return this.allTechnicians.filter(tech =>
                        tech.name.toLowerCase().includes(query) ||
                        (tech.philrice_id && tech.philrice_id.toLowerCase().includes(query)) ||
                        (tech.role && tech.role.toLowerCase().includes(query))
                    );
                },

                // Method to filter technicians (for compatibility)
                filterTechnicians() {
                    // The filtering is done automatically through the computed property
                    // This method exists just for the @input handler
                },

                // Function to convert string to uppercase (for template)
                strtoupper(str) {
                    return str ? str.toUpperCase() : '';
                },

                // ...existing methods...

                // Watch for changes to selectedTechnician
                init() {
                    // Flag to prevent multiple loads of the same data
                    this.loadedTurnaroundTimes = {};

                    // Keep existing init code
                    this.$watch('selectedTechnician', (technician) => {
                        // Only load turnaround time if this is a new technician
                        // or we haven't loaded it for this technician yet
                        if (technician && technician.philrice_id && !this.loadedTurnaroundTimes[technician.philrice_id]) {
                            // Mark as loaded to prevent duplicate calls
                            this.loadedTurnaroundTimes[technician.philrice_id] = true;
                            this.loadTurnaroundTime(technician.philrice_id);
                        }

                        // Update the chart when technician changes (if this exists in your code)
                        if (window.updateSummaryChart && technician) {
                            setTimeout(() => {
                                window.updateSummaryChart(technician);
                            }, 100);
                        }
                    });
                },

                // Method to load turnaround time for the selected technician
                loadTurnaroundTime(technicianId) {
                    console.log("Loading turnaround time for technician:", technicianId);

                    // Show loading state
                    this.selectedTechnician.turnaround_time = "Loading...";

                    // Fetch the turnaround time data
                    fetch(`/ServiceTrackerGithub/technician/${technicianId}/turnaround-time`)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Turnaround time data:", data);

                            if (data.success) {
                                this.selectedTechnician.turnaround_time = data.average_turnaround_time;
                                console.log("Updated turnaround time:", this.selectedTechnician.turnaround_time);
                            } else {
                                this.selectedTechnician.turnaround_time = "No data available";
                                console.warn("Failed to load turnaround time:", data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error loading turnaround time:", error);
                            this.selectedTechnician.turnaround_time = "Error loading data";
                        });
                },

                // Calculate percentages for the current technician
                calculatePercentage(status) {
                    return window.calculatePercentage(status, this.selectedTechnician);
                }
            }));
        });

        function updateTechnician(technician) {
            const password = document.getElementById('tech-password').value;
            const confirmPassword = document.getElementById('tech-confirm-password').value;
            if (password && password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match!',
                    confirmButtonColor: '#007A33'
                });
                return;
            }

            Swal.fire({
                title: 'Updating Account',
                text: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/ServiceTrackerGithub/update-technician', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: technician.philrice_id,
                        role: technician.role,
                        password: password || null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Account updated successfully!',
                            confirmButtonColor: '#007A33'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to update account',
                            confirmButtonColor: '#007A33'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the account',
                        confirmButtonColor: '#007A33'
                    });
                });
        }

        function archiveTechnician(technician) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This account will be deleted. This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007A33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deleted it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/ServiceTrackerGithub/archive-technician', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id: technician.philrice_id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Archived!',
                                    'Account has been deleted successfully.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || 'Failed to delete account',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the account',
                                'error'
                            );
                        });
                }
            });
        }

        // Add this to your existing JavaScript that handles technician selection
        function loadTechnicianTurnaroundTime(technicianId) {
            // Show loading state
            document.querySelector('.average-turnaround-time').textContent = "Loading...";

            // Fetch the turnaround time data
            fetch(`/ServiceTrackerGithub/technician/${technicianId}/turnaround-time`)
                .then(response => response.json())
                .then(data => {
                    console.log("Turnaround time data:", data); // Log the full data for debugging

                    if (data.success) {
                        // Update the selectedTechnician object with the turnaround time
                        if (window.Alpine) {
                            const component = Alpine.getComponent(document.querySelector('[x-data="technicianView"]'));
                            if (component && component.selectedTechnician) {
                                component.selectedTechnician.turnaround_time = data.average_turnaround_time;
                            }
                        }

                        // Log detailed information about the calculation
                        console.log('Total seconds:', data.total_seconds);
                        console.log('Requests processed:', data.requests_processed);
                        console.log('Average seconds per request:', data.average_seconds);
                        console.log('Formatted time:', data.average_turnaround_time);

                        if (data.debug_info) {
                            console.log('Debug info:', data.debug_info);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading turnaround time:', error);
                    // Set a fallback value on error
                    if (window.Alpine) {
                        const component = Alpine.getComponent(document.querySelector('[x-data="technicianView"]'));
                        if (component && component.selectedTechnician) {
                            component.selectedTechnician.turnaround_time = "Error loading data";
                        }
                    }
                });
        }

        // Call this function whenever a technician is selected
        document.addEventListener('technicianSelected', function(e) {
            if (e.detail && e.detail.id) {
                loadTechnicianTurnaroundTime(e.detail.id);
            }
        });
    </script>
</x-layout>
