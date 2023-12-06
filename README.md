This laravel application performs a basic RESTful API for Platable to perform CRUD (Create, Read, Update, Delete)

Firstly I created 3 tables 'foods', 'donors' and 'recipients'. A 4th table 'foodables' is required to establish many to many polymorphic relationship such that a donor can have multiple
food items, and a recipient can have multiple food items.

