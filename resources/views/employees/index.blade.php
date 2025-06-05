<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Employee Management System</h1>

    <div class="flex space-x-2">
        <a href="{{ url('/') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded">
            ← Back to Home
        </a>
        <a href="{{ route('employees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Add Employee
        </a>
    </div>
</div>
            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium">Filter by Company</label>
            <select id="companyFilter" class="w-full border rounded p-2">
                <option value="">All</option>
                @foreach(\App\Models\Company::all() as $company)
                    <option value="{{ $company->name }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Filter by Position</label>
            <input type="text" id="positionFilter" class="w-full border rounded p-2" placeholder="Enter position">
        </div>
    </div>

    <table id="employeesTable" class="stripe hover w-full">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Company</th>
            <th>Manager</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Models\Employee::all() as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->company->name ?? '-' }}</td>
                <td>{{ $employee->manager->name ?? '-' }}</td>
                <td>
                    {{ $employee->city ?? '-' }},
                    {{ $employee->state ?? '-' }},
                    {{ $employee->country ?? '-' }}
                </td>
                <td class="space-x-2">
                    <a href="{{ route('employees.edit', $employee) }}"
                       class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete employee?')" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        const table = $('#employeesTable').DataTable({
            responsive: true,
            pageLength: 10
        });

        $('#companyFilter').on('change', function () {
            table.column(3).search(this.value).draw();
        });

        $('#positionFilter').on('keyup', function () {
            table.column(2).search(this.value).draw();
        });
    });
</script>

</body>
</html>
