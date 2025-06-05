<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Create New Employee</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium">Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium">Position</label>
                    <input type="text" name="position" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium">Company</label>
                    <select name="company_id" id="companySelect" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Manager</label>
                    <select name="manager_id" id="managerSelect" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Manager</option>

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

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Save Employee
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
| 2. Updates the "Manager" dropdown based on the selected company by performing an AJAX call to Laravel route.
| 
| API Endpoints Used:
| - GET https://countriesnow.space/api/v0.1/countries/states => For country/state
| - POST https://countriesnow.space/api/v0.1/countries/state/cities => For cities
| - GET /companies/{companyId}/managers => Custom Laravel route to fetch managers
--}}

    <script>
        document.addEventListener("DOMContentLoaded", async () => {

          //API URL for fetching countries: GET
            const countriesEndpoint = "https://countriesnow.space/api/v0.1/countries/states";

          //API URL for fetching cities: POST {country, state}
            const citiesEndpoint = "https://countriesnow.space/api/v0.1/countries/state/cities";

            let countryData = [];

            const countrySelect = document.getElementById('country');
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            // Fetch countries and states
            const response = await fetch(countriesEndpoint);
            const responseParsed = await response.json();
            countryData = responseParsed.data;

            countryData.forEach(country => {
                const opt = document.createElement('option');
                opt.value = country.name;
                opt.text = country.name;
                countrySelect.appendChild(opt);
            });

            // On Change in Country seletced
            countrySelect.addEventListener('change', () => {
                const selectedCountry = countrySelect.value;
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';
                const country = countryData.find(country => country.name === selectedCountry);
                country.states.forEach(state => {
                const opt = document.createElement('option');
                opt.value = state.name;
                opt.text = state.name;
                stateSelect.appendChild(opt);
                    });
                
            });

            // On state change 
            stateSelect.addEventListener('change', async () => {
                const selectedCountry = countrySelect.value;
                const selectedState = stateSelect.value;

                citySelect.innerHTML = '<option value="">Loading...</option>';
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
                    citySelect.appendChild(opt);
                });
            });

          const companySelect = document.getElementById('companySelect');
          const managerSelect = document.getElementById('managerSelect');


            //on company change, fetch managers of the newly selected company for the dropdown
          companySelect.addEventListener('change', async() => {
            const companyId = companySelect.value;
            managerSelect.innerHTML = '<option value="">Loading...</option>';
            if(companyId){
              const res = await fetch(`/companies/${companyId}/managers`);
              const result = await res.json();
              managerSelect.innerHTML = '<option value="">None</option>';
              if(result.length > 0){
                result.forEach(manager => {
                const opt = document.createElement('option');
                opt.value = manager.id;
                opt.text = manager.name;
                managerSelect.appendChild(opt);
              })
              }
              else{
                managerSelect.innerHTML += '<option disabled>No managers found</option>';
              }

            }
            else{
              managerSelect.innerHTML = '<option value="">None</option>';
            }
          })
        });

    </script>

</body>
</html>
