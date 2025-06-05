<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Edit Employee</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ $employee->name }}" required>
                </div>
                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ $employee->email }}" required>
                </div>
                <div>
                    <label class="block font-medium">Position</label>
                    <input type="text" name="position" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ $employee->position }}" required>
                </div>
                <div>
                    <label class="block font-medium">Company</label>
                    <select name="company_id" id="companySelect" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ $employee->company_id == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Manager</label>
                    <select name="manager_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">None</option>
                        @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}" {{ $employee->manager_id == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Country</label>
                    <select id="country" name="country" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Country</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">State</label>
                    <select id="state" name="state" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select State</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">City</label>
                    <select id="city" name="city" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select City</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Update Employee
            </button>
        </form>
    </div>

    {{-- 
|--------------------------------------------------------------------------
| Employee Form - Dynamic Dropdown 
|--------------------------------------------------------------------------
|
| This script performs the following:
| 1. Fetches and populates country, state, and city dropdowns using the CountriesNow API.
| 
| 
| API Endpoints Used:
| - GET https://countriesnow.space/api/v0.1/countries/states => For country/state
| - POST https://countriesnow.space/api/v0.1/countries/state/cities => For cities
|
--}}
    <script>
        const selectedCountry = @json($employee->country);
        const selectedState = @json($employee->state);
        const selectedCity = @json($employee->city);

        document.addEventListener("DOMContentLoaded", async () => {
            const countriesEndpoint = "https://countriesnow.space/api/v0.1/countries/states";
            const citiesEndpoint = "https://countriesnow.space/api/v0.1/countries/state/cities";

            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            // Fetch all countries and states
            const res = await fetch(countriesEndpoint);
            const result = await res.json();
            console.log(result.data);
            
            result.data.forEach(country => {
                const opt = document.createElement('option');
                opt.value = country.name;
                opt.text = country.name;
                if (country.name === selectedCountry) opt.selected = true;
                countrySelect.appendChild(opt);
            });

            // Load states for selected country
            const country = result.data.find(country => country.name === selectedCountry);
            if (country) {
                country.states.forEach(state => {
                    const opt = document.createElement('option');
                    opt.value = state.name;
                    opt.text = state.name;
                    if (state.name === selectedState) opt.selected = true;
                    stateSelect.appendChild(opt);
                });

                // Fetch cities if the state is selected
                if (selectedState) {
                    const res = await fetch(citiesEndpoint, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ country: selectedCountry, state: selectedState })
                    });

                    const result = await res.json();
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    result.data.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city;
                        opt.text = city;
                        if (city === selectedCity) opt.selected = true;
                        citySelect.appendChild(opt);
                    });
                }
            }

            // on country change
            countrySelect.addEventListener('change', () => {
                const newCountry = countrySelect.value;
                const selected = result.data.find(country => country.name === newCountry);
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';

                if (selected) {
                    selected.states.forEach(state => {
                        const opt = document.createElement('option');
                        opt.value = state.name;
                        opt.text = state.name;
                        stateSelect.appendChild(opt);
                    });
                }
            });

            // on state change
            stateSelect.addEventListener('change', async () => {
                const country = countrySelect.value;
                const state = stateSelect.value;
                console.log(country);
                console.log(state);
                
                citySelect.innerHTML = '<option value="">Loading...</option>';

                const res = await fetch(citiesEndpoint, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ country, state })
                });

                const result = await res.json();
                console.log("cities", result.data);
                
                citySelect.innerHTML = '<option value="">Select City</option>';
                result.data.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city;
                    opt.text = city;
                    citySelect.appendChild(opt);
                });
            });
        });
    </script>
</body>
</html>
