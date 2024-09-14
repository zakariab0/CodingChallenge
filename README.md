<h2>Coding Challenge: Product Management Application<h2>
A simple full-stack application for managing products and categories built with Laravel and Bootstrap.

<h3>Features</h3>
<ul>
    <li>Create and manage products</li>
    <li>List products with sorting and filtering options.</li>
    <li>Automated tests for product creation.</li>
</ul>

<h3>Running the project</h3>
<ul>
    <li>Configure database and other environment settings in .env .</li>
    <li>Run composer install to install dependencies.</li>
    <li>Run php artisan key:generate to generate the application key.</li>
</ul>

<h3>Migrate Database:</h3>
<ul>
    <li>Run php artisan migrate to create the necessary database tables.
    <li>Run these following command for seeding the database with sample data:</li>
        <ol>artisan db:seed --class=CategoryProductSeeder</ol>
        <ol>artisan db:seed --class=ProductSeeder</ol>
        <ol>artisan db:seed --class=CategorySeeder</ol>
    <li>Run php artisan serve to start the Laravel development server.</li>
</ul>

<h3>How to Test</h3>
    <ul>Run Tests:</ul>
        <li>Set .env.testing file for testing .env configuration and use same .env method to generate the key.</li>
        <li>Run php artisan test to execute the automated tests for the backend.</li>
