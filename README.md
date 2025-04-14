# Product Variants API

This project is a backend API for managing store products with various types of variants such as color, size, and dimensions. It is built using Laravel and uses MongoDB as the primary database. The system is designed to handle flexible and dynamic attributes for each product, enabling the creation of multiple combinations of features and prices per product.

## Technologies Used

- Laravel 12
- MongoDB
- [mongodb/laravel-mongodb](https://github.com/mongodb/laravel-mongodb) package
- RESTful API structure
- Laravel Sanctum (for authentication, planned in later stages)
- PHP 8.2+
- Composer
- Postman Collection (For Test)
- Git (version control)

## Purpose of the Project

- Build a product management system with support for variations
- Design relational-style models in MongoDB
- Develop a complete API for managing products and their variations
- Clean architecture following SOLID principles and Clean Code practices
- Ready for frontend development using Vue.js or Nuxt 3

## Installation

1. Clone the repository:

```bash
git clone <https://github.com/emzeddev/product-variant-api.git>
cd product-variant-api


## 📁 Directory Structure

```text
app/
├── Models/
├── Http/
│   ├── Controllers/Api/
│   ├── Requests/
│   ├── Resources/
├── Services/
├── Traits/
routes/
├── api.php

