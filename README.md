 # Office Management System – Laravel Project

# Project Overview

This is a simple Office Management System built using Laravel and MySQL, designed to manage Companies and Employees.

# Features:

-Company CRUD (Create, Read, Update, Delete)

-Employee CRUD with Manager assignment. One Manager(employee) for every Employee.

-Dynamic Country/State/City selection via API

-DataTables integration for search, pagination, and filtering

-Simple Home Navigation Page (TailwindCSS)

# Requirements

PHP (via XAMPP)

Composer installed globally

MySQL (included in XAMPP)

Laravel 10+

# Installation & Setup (Using XAMPP)

## 1. Clone the Repository

git clone https://github.com/Jason3248/Company-Management-Laravel.git
cd Company-Management-Laravel

## 2. Start XAMPP

Open XAMPP Control Panel

Start Apache and MySQL

Go to http://localhost/phpmyadmin and create a database:

DB Name: office_management(anything of your choice).

## 3. Install Dependencies

composer install

## 4. Create .env Configuration

cp .env.example .env

Edit .env and set your database connection:

DB_DATABASE=office_management
DB_USERNAME=root
DB_PASSWORD=

## 5. Generate Application Key

php artisan key:generate

## 6. Run Migrations

php artisan migrate

## 7. Serve the Project

php artisan serve

## Visit:

http://localhost:8000

🌐 Routes

/ → Home Navigation Page

/companies → Company Management

/employees → Employee Management

# Notes

Country/State/City dropdown uses CountriesNow API
Website Link(no API key req): https://countriesnow.space/

URL used:
 1. https://countriesnow.space/api/v0.1/countries/states
    method: GET
    This fetches all countries and states.

 2. 'https://countriesnow.space/api/v0.1/countries/state/cities' 
--data '{
    "country": "Nigeria",
    "state": "Lagos"
}'
    method: POST
    This fetches all cities based on selected country and state

Manager dropdown updates based on selected company

TailwindCSS is used for styling

## Some Screenshots

### 1. Home Page
   ![image](https://github.com/user-attachments/assets/d94a685a-a7a6-40c2-b16d-e2357b746814)
   

### 2. Employee Viewing and Management
   ![image](https://github.com/user-attachments/assets/84a8176c-46ba-454e-8564-486774790283)
   

### 3. Adding Employee
    ![image](https://github.com/user-attachments/assets/abcaf3b5-db47-4cd3-9d2c-2f683df79dfa)

### 4. Company

   ![image](https://github.com/user-attachments/assets/2d7482e4-8c3f-4b88-a73a-11bd4fc1aa57)

## Author

Jason Dsouza

## THANK YOU
