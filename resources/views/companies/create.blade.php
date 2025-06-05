<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Add New Company</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('companies.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Company Name</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border border-gray-300 rounded" value="{{ old('name') }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Location</label>
                <input type="text" name="location" class="w-full mt-1 p-2 border border-gray-300 rounded" value="{{ old('location') }}" required>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Save
                </button>
                <a href="{{ route('companies.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
            </div>
        </form>
    </div>

</body>
</html>
