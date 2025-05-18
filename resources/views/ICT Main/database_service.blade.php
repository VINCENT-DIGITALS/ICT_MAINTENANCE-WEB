<x-layout>
    <h2 class="font-bold text-[20px] leading-[37px] font-roboto-title">Database</h2>

    <div class="mt-4 space-x-5 flex w-full font-roboto-text">
        {{-- Problems Encountered --}}
        <div id="problems-container" class="flex flex-col w-[60%]">
            <div class="bg-white shadow rounded-lg p-4 w-full lg:h-[600px] xl:h-[785px] relative">
                <h2 class="text-lg font-bold">Problems Encountered</h2>
                <div class="mt-2">
                    <input type="text" id="search-bar" placeholder="Search" class="w-full border p-2 rounded-md text-xs" oninput="filterProblems()">
                </div>
                <div class="mt-2">
                    <select id="category-dropdown" class="w-full border p-2 rounded-md text-xs" onchange="filterProblems()">
                        <option value="">ALL SERVICE CATEGORIES</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-gray-500 mt-2 text-xs">Showing all {{ $problemsCount }} items.</p>

                <div class="mt-2 lg:h-[390px] xl:h-[36rem] overflow-y-auto rounded-md">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="">
                                <th class="p-1 text-center">Action</th>
                                <th class="p-1 w-[70%]">Problem Title</th>
                                <th class="p-1">No. of entries</th>
                            </tr>
                        </thead>
                        <tbody id="problems-table-body">
                            @foreach ($problems as $problem)
                                <tr data-category-id="{{ $problem->category_id }}" data-problem-name="{{ strtolower($problem->encountered_problem_name) }}">
                                    <td class="p-2 text-center">
                                        <button onclick="confirmArchiveProblem('{{ $problem->id }}', '{{ $problem->encountered_problem_name }}')"d }}', '{{ $problem->encountered_problem_name }}')"
                                            class="text-gray-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray" class="size-5">
                                                <path fill-rule="evenodd"
                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="p-2 font-bold">{{ $problem->encountered_problem_name }}<br>
                                        <span class="text-[#B0B0B0] text-xs font-normal">
                                            {{ $categories->firstWhere('id', $problem->category_id)?->category_name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="p-2">15 entries</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button onclick="showAddProblemForm()"
                    class="w-full font-semibold bg-[#007A33] text-white p-2 mt-2 rounded-lg text-xs">ADD NEW PROBLEM</button>

                <!-- Modal container -->
                <div id="modal-container-problem"
                    class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-70 hidden flex justify-center items-center">
                    <!-- Modal content for problems will be dynamically inserted here -->
                </div>
            </div>
        </div>

        {{-- Actions Taken --}}
        <div id="actions-container" class="flex flex-col w-[60%]">
            <div class="bg-white shadow rounded-lg p-4 w-full lg:h-[600px] xl:h-[785px] relative">
                <h2 class="text-lg font-bold">Actions Taken</h2>
                <div class="mt-2">
                    <input type="text" id="search-bar-actions" placeholder="Search" class="w-full border p-2 rounded-md text-xs" oninput="filterActions()">
                </div>
                <div class="mt-2">
                    <select id="category-dropdown-actions" class="w-full border p-2 rounded-md text-xs" onchange="filterActions()">
                        <option value="">ALL SERVICE CATEGORIES</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-gray-500 mt-2 text-xs">Showing all {{ $actionsCount }} items.</p>

                <div class="mt-2 lg:h-[390px] xl:h-[36rem] overflow-y-auto rounded-md">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr>
                                <th class="p-1 text-center">Action</th>
                                <th class="p-1 w-[70%]">Action Title</th>
                                <th class="p-1">No. of entries</th>
                            </tr>
                        </thead>
                        <tbody id="actions-table-body">
                            @foreach ($actions as $action)
                                <tr data-category-id="{{ $action->category_id }}" data-action-name="{{ strtolower($action->action_name) }}">
                                    <td class="p-2 text-center">
                                        <button onclick="confirmArchiveAction('{{ $action->id }}', '{{ $action->action_name }}')"d }}', '{{ $action->action_name }}')"
                                            class="text-gray-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray" class="size-5">
                                                <path fill-rule="evenodd"
                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="p-2 font-bold">{{ $action->action_name }}<br>
                                        <span class="text-[#B0B0B0] text-xs font-normal">
                                            {{ $categories->firstWhere('id', $action->category_id)?->category_name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="p-2">15 entries</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button onclick="showAddActionForm()"
                    class="w-full font-semibold bg-[#007A33] text-white p-2 mt-2 rounded-lg text-xs">ADD NEW ACTION</button>

                <!-- Modal container -->
                <div id="modal-container-action"
                    class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-70 hidden flex justify-center items-center">
                    <!-- Modal content for actions will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Store original content for both sections
        const originalProblemsContent = document.getElementById('problems-container').innerHTML;
        const originalActionsContent = document.getElementById('actions-container').innerHTML;

        let selectedProblemId = null;

        // Function to show the modal for problems
        function showModalProblem(problemName, problemId) {
            selectedProblemId = problemId; // Store the problem ID for deletion
            const modalContainer = document.getElementById('modal-container-problem');
            modalContainer.innerHTML = `
                <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-[400px]">
                    <h2 class="text-lg font-bold text-center mb-4">Are you sure you want to remove this option?</h2>
                    <div class="bg-[#ECECEC] rounded-lg p-2 mb-2">
                        <p class="text-center font-bold text-xs">${problemName}</p>
                    </div>
                    <p class="text-center text-gray-500 text-xs mb-4">This change will affect all existing records where this option was selected.</p>
                    <div class="flex justify-between w-full space-x-2">
                        <button onclick="closeModal('modal-container-problem')" class="bg-[#45CF7F] w-[50%] text-[#007A33] text-sm px-4 py-2 rounded-lg font-medium">CANCEL</button>
                        <button onclick="confirmRemoval()" class="bg-[#007A33] w-[50%] text-sm text-white px-4 py-2 rounded-lg font-medium">CONFIRM REMOVAL</button>
                    </div>
                </div>
            `;
            modalContainer.classList.remove('hidden');
        }

        // Function to show the modal for actions
        function showModalAction(actionName, actionId) {
            selectedActionId = actionId; // Store the action ID for deletion
            const modalContainer = document.getElementById('modal-container-action');
            modalContainer.innerHTML = `
                <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-[400px]">
                    <h2 class="text-lg font-bold text-center mb-4">Are you sure you want to remove this option?</h2>
                    <div class="bg-[#ECECEC] rounded-lg p-2 mb-2">
                        <p class="text-center font-bold text-xs">${actionName}</p>
                    </div>
                    <p class="text-center text-gray-500 text-xs mb-4">This change will affect all existing records where this option was selected.</p>
                    <div class="flex justify-between w-full space-x-2">
                        <button onclick="closeModal('modal-container-action')" class="bg-[#45CF7F] w-[50%] text-[#007A33] text-sm px-4 py-2 rounded-lg font-medium">CANCEL</button>
                        <button onclick="confirmActionRemoval()" class="bg-[#007A33] w-[50%] text-sm text-white px-4 py-2 rounded-lg font-medium">CONFIRM REMOVAL</button>
                    </div>
                </div>
            `;
            modalContainer.classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal(modalId) {
            const modalContainer = document.getElementById(modalId);
            modalContainer.classList.add('hidden');
            modalContainer.innerHTML = ''; // Clear modal content
        }

        // Function to handle removal confirmation
        function confirmRemoval() {
            if (!selectedProblemId) return;

            fetch(`{{ route('database_service.delete_problem', ':id') }}`.replace(':id', selectedProblemId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Problem deleted successfully.') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Problem deleted successfully.',
                        confirmButtonColor: '#007A33'
                    }).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete the problem.',
                        confirmButtonColor: '#007A33'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while deleting the problem.',
                    confirmButtonColor: '#007A33'
                });
            });

            closeModal('modal-container-problem');
        }

        // Function to handle action removal confirmation
        function confirmActionRemoval() {
            if (!selectedActionId) return;

            fetch(`{{ route('database_service.delete_action', ':id') }}`.replace(':id', selectedActionId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Action deleted successfully.') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Action deleted successfully.',
                        confirmButtonColor: '#007A33'
                    }).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete the action.',
                        confirmButtonColor: '#007A33'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while deleting the action.',
                    confirmButtonColor: '#007A33'
                });
            });

            closeModal('modal-container-action');
        }

        // Function to show the "Add New Problem" form
        function showAddProblemForm() {
            const container = document.getElementById('problems-container');
            container.innerHTML = `
                <form method="POST" action="{{ route('database_service.add_problem') }}" class="bg-white shadow rounded-lg p-4 w-full h-[600px]">
                    @csrf
                    <div class="flex flex-col justify-between h-[572.5px] w-full">
                        <div>
                            <div class="flex items-center space-x-2 mt-2 border-b pb-3">
                                <button type="button" onclick="restoreProblemsContent()" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="green" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <h2 class="font-bold text-lg">Add New Problem</h2>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Service Category</label>
                                <select name="category_id" class="w-full border p-2 rounded-md text-xs">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Problem</label>
                                <input type="text" name="problem_name" placeholder="Corroded Terminal Connection" class="w-full border p-2 rounded-md text-xs" required>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Abbreviation</label>
                                <input type="text" name="abbreviation" placeholder="Abbreviation" class="w-full border p-2 rounded-md text-xs" required>
                            </div>
                            @if ($errors->any())
                                <div class="text-red-500">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-[#007A33] text-white font-semibold p-2 mt-auto rounded-lg text-xs">ADD NEW PROBLEM</button>
                        </div>
                    </div>
                </form>
            `;
        }

        // Function to restore the original "Problems Encountered" content
        function restoreProblemsContent() {
            const container = document.getElementById('problems-container');
            container.innerHTML = originalProblemsContent;
        }

        // Function to show the "Add New Action" form
        function showAddActionForm() {
            const container = document.getElementById('actions-container');
            container.innerHTML = `
                <form method="POST" action="{{ route('database_service.add_action') }}" class="bg-white shadow rounded-lg p-4 w-full h-[600px]">
                    @csrf
                    <div class="flex flex-col justify-between h-[572.5px] w-full">
                        <div>
                            <div class="flex items-center space-x-2 mt-2 border-b pb-3">
                                <button type="button" onclick="restoreActionsContent()" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="green" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <h2 class="font-bold text-lg">Add New Action</h2>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Service Category</label>
                                <select name="category_id" class="w-full border p-2 rounded-md text-xs">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Action</label>
                                <input type="text" name="action_name" placeholder="Action Description" class="w-full border p-2 rounded-md text-xs" required>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium">Abbreviation</label>
                                <input type="text" name="abbreviation" placeholder="Abbreviation" class="w-full border p-2 rounded-md text-xs" required>
                            </div>
                            @if ($errors->any())
                                <div class="text-red-500">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-[#007A33] text-white font-semibold p-2 mt-auto rounded-lg text-xs">ADD NEW ACTION</button>
                        </div>
                    </div>
                </form>
            `;
        }

        // Function to restore the original "Actions Taken" content
        function restoreActionsContent() {
            const container = document.getElementById('actions-container');
            container.innerHTML = originalActionsContent;
        }

        function filterProblems() {
            const searchQuery = document.getElementById('search-bar').value.toLowerCase();
            const selectedCategory = document.getElementById('category-dropdown').value;
            const tableBody = document.getElementById('problems-table-body');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const problemName = row.getAttribute('data-problem-name');
                const categoryId = row.getAttribute('data-category-id');

                const matchesSearch = problemName.includes(searchQuery);
                const matchesCategory = !selectedCategory || categoryId === selectedCategory;

                if (matchesSearch && matchesCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterActions() {
            const searchQuery = document.getElementById('search-bar-actions').value.toLowerCase();
            const selectedCategory = document.getElementById('category-dropdown-actions').value;
            const tableBody = document.getElementById('actions-table-body');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const actionName = row.getAttribute('data-action-name');
                const categoryId = row.getAttribute('data-category-id');

                const matchesSearch = actionName.includes(searchQuery);
                const matchesCategory = !selectedCategory || categoryId === selectedCategory;

                if (matchesSearch && matchesCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function archiveProblem(problemId) {
            if (!problemId) return;

            fetch(`{{ route('database_service.archive_problem', ':id') }}`.replace(':id', problemId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Problem archived successfully.') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Archived!',
                        text: 'Problem archived successfully.',
                        confirmButtonColor: '#007A33'
                    }).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to archive the problem.',
                        confirmButtonColor: '#007A33'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while archiving the problem.',
                    confirmButtonColor: '#007A33'
                });
            });
        }

        function archiveAction(actionId) {
            if (!actionId) return;

            fetch(`{{ route('database_service.archive_action', ':id') }}`.replace(':id', actionId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Action archived successfully.') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Archived!',
                        text: 'Action archived successfully.',
                        confirmButtonColor: '#007A33'
                    }).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to archive the action.',
                        confirmButtonColor: '#007A33'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while archiving the action.',
                    confirmButtonColor: '#007A33'
                });
            });
        }

        function confirmArchiveProblem(problemId, problemName) {
            Swal.fire({
                title: 'Archive Confirmation',
                html: `Are you sure you want to archive <strong>${problemName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007A33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call the existing archiveProblem function
                    archiveProblem(problemId);
                }
            });
        }

        function confirmArchiveAction(actionId, actionName) {
            Swal.fire({
                title: 'Archive Confirmation',
                html: `Are you sure you want to archive <strong>${actionName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007A33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call the existing archiveAction function
                    archiveAction(actionId);
                }
            });
        }
    </script>
</x-layout>
