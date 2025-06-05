<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-lg shadow-md text-center w-full max-w-xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Office Management System</h1>
        <p class="text-gray-600 mb-8">Manage your Companies and Employees efficiently.</p>

        <div class="flex justify-center gap-6">
            <a href="{{ route('companies.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                Manage Companies
            </a>
            <a href="{{ route('employees.index') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                Manage Employees
            </a>
        </div>
    </div>
</body>
</html>
