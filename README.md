# ShareSphere
ShareSphere is a Laravel-based web application that facilitates seamless sharing and renting of products. It leverages Microsoft SQL Server as the primary database and implements modern web development practices with Blade templating, Vite asset bundling, and a clean MVC architecture.

# Features
- 🔐 User Authentication (Register, Login, Logout)
- 📦 Product Management (Add, Edit, Delete)
-🛒 Shopping Cart and Checkout
- 🚚 Shipping Details Handling
- 🔁 Product Return and Confirmation Flow
- 📜 Return & Transaction History

# Installation
### 1. Clone the Repository
```git clone https://github.com/AndrewKlement/ShareSphere.git```

### 2. Install Dependencies
```
composer install
npm install
```

### 3. Environment Configuration
#### Create .env file from example
```cp .env.example .env```

#### Configure it with your MSSQL db
```
DB_DRIVER=sqlsrv
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=YourDatabase
DB_USERNAME=YourUsername
DB_PASSWORD=YourPassword
```

### 4. Generate application key
```php artisan key:generate```

### 5. Run migrations
```php artisan migrate```

### 6. Seed DB with product category
```php artisan db:seed --class=CategorySeeder```

### 7. Run Server
```composer run dev```


