<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login | ICT Maintenance & Service Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex flex-col justify-between"
    style="background-image: url('{{ url('public/images/Maintenance-Login-bg.png') }}'); background-size: cover;">

    <!-- Centered Login Form -->
    <div class="flex items-center justify-center h-full">
        <div class="bg-white shadow-lg rounded-lg px-10 py-12 w-[600px] h-[600px] flex flex-col justify-center">
            <h1 class="text-5xl font-bold text-center mb-12 leading-tight font-roboto">
                ICT Maintenance &<br> Service Management System
            </h1>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5 mt-6">
                @csrf

                <!-- PhilRice ID -->
                <div class="">
                    <label for="philrice_id" class="block text-base text-xs font-medium text-gray-700">PhilRice ID
                        Number</label>
                    <input type="text" id="philrice_id" name="philrice_id" required
                        class="w-full px-4 py-3 border rounded-md text-xs focus:ring focus:ring-green-300 h-[2rem]">
                </div>

                <!-- Password Field -->
                <div class="mb-4 relative">
                    <label for="password" class="block text-base font-medium  text-xs text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border rounded-md text-xs focus:ring focus:ring-green-300 h-[2rem]">

                    <!-- Eye Toggle Button -->

                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-5">
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                            class="size-5 hidden">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path fill-rule="evenodd"
                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"
                            class="size-5">
                            <path
                                d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                            <path
                                d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                            <path
                                d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                        </svg>

                    </button>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-green-600 text-white font-medium rounded-md text-sm hover:bg-green-700 transition h-[2rem]">
                    LOG IN
                </button>
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mt-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mt-4">
                        {{ session('error') }}
                    </div>
                @endif
            </form>

            <!-- Support Link -->
            <p class="text-center text-sm text-gray-500 mt-6">
                Having trouble logging in? Email us at
                <a href="mailto:idsupport@mail.philrice.gov.ph" class="text-blue-500 hover:underline">
                    idsupport@mail.philrice.gov.ph
                </a>
            </p>
        </div>
    </div>

    <!-- Footer with Colored Bar -->
    <div>
        <p class="text-center text-gray-400 text-sm mb-10">
            © 2025 PhilRice - Information Systems Division. All rights reserved.
        </p>
    </div>

    <div class="fixed bottom-0 w-full flex">
        <div class="w-2/3 h-3 bg-[#0F8C3F]"></div>
        <div class="w-2/3 h-3 bg-[#3B4E57]"></div>
        <div class="w-2/3 h-3 bg-[#914D3A]"></div>
        <div class="w-2/3 h-3 bg-[#F4B861]"></div>
        <div class="w-2/3 h-3 bg-[#7A4923]"></div>
    </div>

    <!-- Password Toggle Script -->
    <script>
        // Check if user is authenticated by making an Ajax request
        function checkAuthentication() {
            fetch('/api/check-auth', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    // User is authenticated, redirect to dashboard
                    window.location.replace('/dashboard');
                }
            })
            .catch(error => {
                console.error('Authentication check failed:', error);
            });
        }

        // Run immediately when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Check authentication status
            checkAuthentication();
            
            // Handle back button navigation
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Page was loaded from cache (back button)
                    checkAuthentication();
                }
            });
        });

        // Standard password toggle function
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeOpen = document.getElementById("eye-open");
            var eyeClosed = document.getElementById("eye-closed");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
            }
        }
    </script>

</body>

</html>
