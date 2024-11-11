# Backend Developer Technical Task - Laravel

This repository contains the solution for a Backend Developer Technical Task using Laravel. The task covers various Laravel functionalities such as routing, Eloquent ORM, migrations, authentication, authorization, API development, testing, frontend integration, and Stripe payment integration.

## Requirements

Before you start, ensure you have the following installed on your machine:

- PHP (>= 7.4)
- Composer
- Laravel (latest version)
- Stripe account (for Stripe integration)

## Installation

Follow the steps below to set up and run the project locally:

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/repository-name.git
    ```

2. Navigate into the project directory:
    ```bash
    cd repository-name
    ```

3. Install the dependencies:
    ```bash
    composer install
    ```

4. Create a `.env` file from the `.env.example`:
    ```bash
    cp .env.example .env
    ```

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Set up your database configuration in `.env` file:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. Run the database migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```

8. Set up Stripe environment variables in the `.env` file:
    ```
    STRIPE_KEY=your_stripe_test_key
    STRIPE_SECRET=your_stripe_test_secret
    ```

9. Serve the application:
    ```bash
    php artisan serve
    ```

Your application should now be accessible at `http://localhost:8000`.

## Features Implemented

### Section 1: Routing & Middleware
- Created a Laravel route directing to a controller method.
- Implemented a route parameter and retrieved its value in the controller.
- Created custom middleware that logs the incoming requests.
- Applied the middleware to specific routes.

### Section 2: Eloquent ORM, Migrations & Seeders
- Created a `Product` model with `name`, `price`, and `quantity` fields.
- Implemented a query to fetch products with a price greater than a specified amount.
- Added a `category_id` column to the `products` table through migration.
- Populated the `category_id` column with random values using a seeder.

### Section 3: Authentication & Authorization
- Implemented user authentication using Laravel's built-in system.
- Created middleware to restrict access to authenticated users.
- Defined authorization rules for updating and deleting products using Laravel's policy.

### Section 4: API Routes & Authentication
- Created a RESTful API endpoint to retrieve a list of products with pagination.
- Secured the API endpoint with token-based authentication.
- Provided instructions on generating and using the API token.

### Section 5: Unit & Feature Testing
- Wrote a unit test for the controller method that adds a new product.
- Wrote a feature test for the authentication process, testing both successful and unsuccessful login attempts.
- Used a test database for isolation during tests.

### Section 6: Blade Templates & AJAX Integration
- Created Blade templates to display a list of products and a form to add a new product.
- Implemented AJAX functionality to add a new product without refreshing the page.

### Section 7: Stripe Integration
- Integrated Stripe PHP SDK into the Laravel project for handling payments.
- Created a payment form using Stripe Elements or Checkout.
- Implemented a controller action to handle the form submission and create a charge.
- Displayed a payment confirmation message after successful payment and stored the payment details.
- Implemented webhooks to handle Stripe events and update the order status.

## Running Tests

To run the unit tests and feature tests, use the following command:

```bash
php artisan test
