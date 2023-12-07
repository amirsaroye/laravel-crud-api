This laravel application performs a basic RESTful API for Platable to perform CRUD (Create, Read, Update, Delete)

Firstly I created 3 tables 'foods', 'donors' and 'recipients'. A 4th table 'foodables' is required to establish many to many polymorphic relationship such that a donor can have multiple
food items, and a recipient can have multiple food items.

Than I impemented CRUD for all 3 models.
Than established a many to many polymorphic relationship between donors, recipients and foods, with foodable table storing necessary information.

How to run the projects
=======================

->Install a fresh laravel app, command composer create-project laravel/laravel app-name
->clone the github repo https://github.com/amirsaroye/laravel-crud-api.git into your project
-> make sure to update .env file as per your system specifications(for database connection)
-> migrate database using command php artisan migrate
->you are good to use the APIs

API Documentation
=================
For FOODS

1. Retrieve All Foods
HTTP verb - GET
URL - app_base_url/api/getfoods

2. Retrieve specific Foods
HTTP verb - GET
URL - app_base_url/api/getfood
Parameters
food_id (required)

3. Create a New Food
HTTP verb - POST
URL - app_base_url/api/storefood
Parameters
food_name (required)
description (optional)
expiry_date (optional)
quantity (optional)
donor_id (optional) The unique identifier of the donor associated with the food item.

4. Update a Food Item
URL - app_base_url/api/updatefood
HTTP verb - PUT
Parameters
food_id (required)
food_name (optional)
description (optional)
expiry_date (optional)
quantity (optional)
donor_id (optional) The unique identifier of the donor associated with the food item.

5. Delete a Food Item
URL - app_base_url/api/deletefood
HTTP verb - DELETE
Parameters
food_id (required)

For DONORS

1. Retrieve All Donors
HTTP verb - GET
URL - app_base_url/api/getdonors

2. Create a New Donor
HTTP verb - POST
URL - app_base_url/api/storedonor
Parameters
donor_name (required)
contact_info (optional)
food_id (optional) The unique identifier of the donor associated with the food item.

3. Update a Donor
URL - app_base_url/api/updatedonor
HTTP verb - PUT
Parameters
donor_id (required)
donor_name (optional)
contact_info (optional)
food_id (optional) The unique identifier of the donor associated with the food item.

4. Delete a Donor
URL - app_base_url/api/deletedonor
HTTP verb - DELETE
Parameters
donor_id (required)

5. Listing all food items donated by a specific donor
URL - app_base_url/api/getdonateditems
HTTP verb - GET
Parameters
donor_id (required)


For RECIPIENTS

1. Retrieve All Recipients
HTTP verb - GET
URL - app_base_url/api/getrecipients

2. Create a New Recipient
HTTP verb - POST
URL - app_base_url/api/storerecipient
Parameters
recipient_name (required)
contact_info (optional)

3. Update a Recipient
URL - app_base_url/api/updaterecipient
HTTP verb - PUT
Parameters
recipient_id (required)
recipient_name (optional)
contact_info (optional)

4. Delete a Recipient
URL - app_base_url/api/deleterecipient
HTTP verb - DELETE
Parameters
recipient_id (required)