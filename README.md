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

<h3>How to use CLI</h3>
    <ul>I have created three commands for a better command managment:<ul>
        <li><b>List parent categories IDs:</b> php artisan category:list-parents</li>
        <li><b>List Sub categories IDs based on a parent Category:</b> php artisan category:list-subs 1</li>
        <li><b>Create Product:</b>  78 php artisan product:create "{NAME}" "{DESCRIPTION}" {PRICE} --image="{IMAGE_PATH}" --parent_category={PARENT_CATEGORY_ID} --subcategories={PSUB_CATEGORY_ID} --subcategories={PSUB_CATEGORY_ID} </li>
        