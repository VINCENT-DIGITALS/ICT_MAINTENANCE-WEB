<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white shadow-md rounded-lg p-10 text-center">
        <img src="{{ url('public/images/unauthorized.svg') }}" alt="Access Denied" class="mx-auto w-32 mb-4">
        <h1 class="text-3xl font-bold text-red-500">Access Denied</h1>
        <p class="text-gray-600 mt-2">You do not have permission to view this page.</p>

        <a href="{{ url('/') }}" class="mt-5 inline-block bg-blue-500 text-white px-5 py-2 rounded-md hover:bg-blue-600 transition">
            Go Back to Login
        </a>
    </div>

</body>
</html>
