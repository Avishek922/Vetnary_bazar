# Veterinary Bazaar - Technical Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Technology Stack](#technology-stack)
3. [Architecture & Design Patterns](#architecture--design-patterns)
4. [Database Schema](#database-schema)
5. [Authentication & Authorization](#authentication--authorization)
6. [Core Features](#core-features)
7. [API Endpoints](#api-endpoints)
8. [Email System](#email-system)
9. [File Structure](#file-structure)
10. [Setup & Installation](#setup--installation)

---

## Project Overview

**Veterinary Bazaar** is a full-featured e-commerce platform built with Laravel for selling veterinary products and pet care items. The system supports multiple user roles, order management, inventory tracking, and delivery agent assignment.

### Key Capabilities
- Multi-role user management (Super Admin, Admin, Inventory Manager, Delivery Agent, Customer)
- Product catalog with categories and search
- Shopping cart and checkout system
- Order tracking and management
- Delivery agent assignment system
- Email notifications
- Dynamic content pages (About Us, Contact Us)
- Contact query management
- OTP-based password reset

---

## Technology Stack

### Backend
- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication
- **PDF Generation**: DomPDF (barryvdh/laravel-dompdf)

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js (for interactive components)
- **Build Tool**: Vite
- **Icons**: Heroicons (SVG)

### Development Tools
- **Dependency Manager**: Composer (PHP), NPM (JavaScript)
- **Version Control**: Git
- **Server**: Apache/Nginx (XAMPP for local development)

---

## Architecture & Design Patterns

### Repository Pattern
The application uses the Repository Pattern to abstract data access logic:

```
App/
├── Interfaces/
│   ├── CategoryRepositoryInterface.php
│   ├── OrderRepositoryInterface.php
│   ├── ProductRepositoryInterface.php
│   └── UserRepositoryInterface.php
└── Repositories/
    ├── CategoryRepository.php
    ├── OrderRepository.php
    ├── ProductRepository.php
    └── UserRepository.php
```

**Benefits**:
- Separation of concerns
- Easier testing and mocking
- Centralized data access logic

### Service Layer
Business logic is encapsulated in service classes:

```php
App/Services/
├── ProductService.php
├── OrderService.php
└── CartService.php
```

### MVC Architecture
- **Models**: Eloquent ORM models in `app/Models/`
- **Views**: Blade templates in `resources/views/`
- **Controllers**: HTTP controllers in `app/Http/Controllers/`

---

## Database Schema

### Core Tables

#### users
```sql
- id (PK)
- name
- email (unique)
- password (hashed)
- phone
- address
- role (enum: user, admin, super_admin, inventory_manager, delivery_agent)
- status (boolean)
- avatar
- remember_token
- created_at, updated_at
```

#### products
```sql
- id (PK)
- name
- slug (unique)
- description
- price (decimal)
- buying_price (decimal) -- for profit calculation
- stock
- category_id (FK -> categories)
- images (JSON array)
- is_active (boolean)
- created_at, updated_at
```

#### categories
```sql
- id (PK)
- name
- slug (unique)
- description
- image
- parent_id (FK -> categories, nullable)
- created_at, updated_at
```

#### orders
```sql
- id (PK)
- user_id (FK -> users)
- order_number (unique)
- total_amount (decimal)
- status (enum: pending, processing, shipped, delivered, cancelled)
- payment_method
- payment_status
- delivery_address
- shipping_address
- notes
- assigned_to (FK -> users, nullable) -- delivery agent
- created_at, updated_at
```

#### order_items
```sql
- id (PK)
- order_id (FK -> orders)
- product_id (FK -> products)
- quantity
- price (decimal) -- snapshot at time of order
- created_at, updated_at
```

#### cart
```sql
- id (PK)
- user_id (FK -> users)
- product_id (FK -> products)
- quantity
- created_at, updated_at
```

#### contact_queries
```sql
- id (PK)
- name
- email
- phone
- message (text)
- status (enum: pending, resolved)
- created_at, updated_at
```

#### password_reset_otps
```sql
- id (PK)
- email
- otp (6 digits)
- expires_at (timestamp)
- created_at, updated_at
```

#### pages
```sql
- id (PK)
- slug (unique)
- title
- content (text)
- is_active (boolean)
- created_at, updated_at
```

### Relationships

**User → Orders**: One-to-Many
**User → Cart**: One-to-Many
**Product → Category**: Many-to-One
**Order → OrderItems**: One-to-Many
**Order → User (assigned_to)**: Many-to-One (for delivery agents)

---

## Authentication & Authorization

### Roles & Permissions

| Role | Permissions |
|------|-------------|
| **Super Admin** | Full system access, user management, all CRUD operations |
| **Admin** | Product/Category/Order management, view users, manage queries |
| **Inventory Manager** | Product/Category management, view orders, assign delivery agents, view queries |
| **Delivery Agent** | View assigned orders only, update order status |
| **User (Customer)** | Browse products, place orders, view own orders |

### Middleware

```php
// app/Http/Middleware/
- AdminMiddleware.php          // admin, super_admin
- SuperAdminMiddleware.php     // super_admin only
- InventoryManagerMiddleware.php // inventory_manager, admin, super_admin
- DeliveryAgentMiddleware.php  // delivery_agent, delivery
```

### Route Protection

```php
// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin dashboard and resources
});

// Super admin only routes
Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});
```

---

## Core Features

### 1. Product Management

**Location**: `app/Http/Controllers/Admin/ProductController.php`

**Features**:
- CRUD operations for products
- Image upload (multiple images per product)
- Category assignment
- Stock management
- Buying price tracking for profit calculation
- Search and filter by category
- Low stock alerts (email notifications)

**Key Methods**:
```php
index()    // List all products with search/filter
create()   // Show create form
store()    // Save new product
edit()     // Show edit form
update()   // Update product
destroy()  // Delete product
```

### 2. Order Management

**Location**: `app/Http/Controllers/Admin/OrderController.php`

**Features**:
- View all orders
- Update order status
- Assign orders to delivery agents
- Generate PDF invoices
- Delete delivered orders (super admin only)
- Filter orders by delivery agent

**Order Statuses**:
- `pending` → `processing` → `shipped` → `delivered`
- `cancelled` (can be set at any time)

**Delivery Agent Assignment**:
```php
assign(Request $request, Order $order)   // Assign order to agent
unassign(Order $order)                   // Remove assignment
```

### 3. Shopping Cart

**Location**: `app/Http/Controllers/Web/CartController.php`

**Features**:
- Add products to cart
- Update quantities
- Remove items
- Calculate totals
- Session-based for guests (future: persistent cart)

### 4. Checkout & Payment

**Location**: `app/Http/Controllers/Web/CheckoutController.php`

**Payment Methods**:
- Cash on Delivery (COD)
- Khalti (future integration)

**Process**:
1. User reviews cart
2. Enters shipping address
3. Selects payment method
4. Order is created with unique order number
5. Email confirmation sent
6. Cart is cleared

### 5. User Management

**Location**: `app/Http/Controllers/Admin/UserController.php`

**Features**:
- Create users (admin only)
- Edit user details
- Assign roles
- Delete users (cannot delete self)
- Search users by name/email

### 6. Contact Query System

**Location**: `app/Http/Controllers/Admin/ContactQueryController.php`

**Features**:
- Store contact form submissions
- Email notification to admin
- View and manage queries
- Mark as resolved
- Delete queries

### 7. Dynamic Pages

**Location**: `app/Http/Controllers/Admin/PageController.php`

**Pages**:
- About Us (with images)
- Contact Us (with form)

**Features**:
- WYSIWYG content editing
- Active/inactive toggle
- Slug-based routing

### 8. Password Reset (OTP)

**Location**: `app/Http/Controllers/Auth/PasswordResetController.php`

**Flow**:
1. User enters email
2. System generates 6-digit OTP
3. OTP sent via email (expires in 10 minutes)
4. User enters OTP to verify
5. User sets new password
6. OTP record deleted

**Restrictions**: Only available for regular users, not admin/staff

---

## API Endpoints

### Public Routes

```
GET  /                          // Home page
GET  /products                  // Product listing
GET  /products/{slug}           // Product details
GET  /pages/{slug}              // Dynamic pages (about-us, contact-us)
POST /contact-query             // Submit contact form
```

### Authentication Routes

```
GET  /login                     // Login form
POST /login                     // Process login
GET  /register                  // Registration form
POST /register                  // Process registration
POST /logout                    // Logout
GET  /password/reset            // Request password reset
POST /password/send-otp         // Send OTP
GET  /password/verify           // OTP verification form
POST /password/verify-otp       // Verify OTP
GET  /password/reset-form       // New password form
POST /password/update           // Update password
```

### User Routes (Authenticated)

```
GET  /cart                      // View cart
POST /cart/add                  // Add to cart
PUT  /cart/{id}                 // Update cart item
DELETE /cart/{id}               // Remove from cart
GET  /checkout                  // Checkout page
POST /checkout                  // Process checkout
GET  /orders                    // User's orders
GET  /orders/{id}               // Order details
GET  /profile                   // User profile
PUT  /profile                   // Update profile
```

### Admin Routes (Admin/Super Admin)

```
GET  /admin/dashboard           // Dashboard with stats
GET  /admin/products            // Product management
GET  /admin/categories          // Category management
GET  /admin/orders              // Order management
POST /admin/orders/{id}/assign  // Assign to delivery agent
GET  /admin/users               // User management (super admin)
GET  /admin/queries             // Contact queries
GET  /admin/pages/{id}/edit     // Edit dynamic pages
```

---

## Email System

### Mailables

All email classes are in `app/Mail/`:

#### 1. WelcomeEmail
- **Trigger**: User registration
- **Template**: `emails.welcome`
- **Content**: Welcome message, account details

#### 2. OrderPlacedEmail
- **Trigger**: Order creation
- **Template**: `emails.order_placed`
- **Content**: Order details, items, total

#### 3. LowStockAlertEmail
- **Trigger**: Product stock ≤ 5
- **Template**: `emails.low_stock_alert`
- **Recipient**: Admin
- **Content**: Product name, current stock

#### 4. NewContactQueryEmail
- **Trigger**: Contact form submission
- **Template**: `emails.new_contact_query`
- **Recipient**: Admin
- **Content**: Sender details, message

#### 5. PasswordResetOtpEmail
- **Trigger**: Password reset request
- **Template**: `emails.password_reset_otp`
- **Content**: 6-digit OTP, expiration notice

### Email Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vetbazaar.com
MAIL_FROM_NAME="Veterinary Bazaar"
```

---

## File Structure

```
vet-shop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── ContactQueryController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── PageController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── PasswordResetController.php
│   │   │   └── Web/
│   │   │       ├── CartController.php
│   │   │       ├── CheckoutController.php
│   │   │       ├── ContactQueryController.php
│   │   │       ├── HomeController.php
│   │   │       ├── OrderController.php
│   │   │       ├── PageController.php
│   │   │       ├── ProductController.php
│   │   │       └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── SuperAdminMiddleware.php
│   │   │   ├── InventoryManagerMiddleware.php
│   │   │   └── DeliveryAgentMiddleware.php
│   │   └── Requests/
│   │       ├── ProductRequest.php
│   │       ├── RegisterRequest.php
│   │       └── OrderRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Cart.php
│   │   ├── ContactQuery.php
│   │   ├── Page.php
│   │   └── PasswordResetOtp.php
│   ├── Repositories/
│   │   ├── CategoryRepository.php
│   │   ├── OrderRepository.php
│   │   ├── ProductRepository.php
│   │   └── UserRepository.php
│   ├── Interfaces/
│   │   ├── CategoryRepositoryInterface.php
│   │   ├── OrderRepositoryInterface.php
│   │   ├── ProductRepositoryInterface.php
│   │   └── UserRepositoryInterface.php
│   ├── Services/
│   │   ├── ProductService.php
│   │   └── OrderService.php
│   ├── Mail/
│   │   ├── WelcomeEmail.php
│   │   ├── OrderPlacedEmail.php
│   │   ├── LowStockAlertEmail.php
│   │   ├── NewContactQueryEmail.php
│   │   └── PasswordResetOtpEmail.php
│   ├── Helpers/
│   │   └── HashIdHelper.php
│   └── Traits/
│       └── HasHashId.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── PageSeeder.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── products/
│   │   │   ├── categories/
│   │   │   ├── orders/
│   │   │   ├── users/
│   │   │   ├── queries/
│   │   │   └── pages/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── password/
│   │   ├── frontend/
│   │   │   ├── home.blade.php
│   │   │   ├── products/
│   │   │   ├── cart/
│   │   │   ├── checkout/
│   │   │   ├── orders/
│   │   │   └── pages/
│   │   ├── emails/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── admin.blade.php
│   │   │   └── auth.blade.php
│   │   └── components/
│   └── css/
│       └── app.css
├── routes/
│   └── web.php
└── public/
    ├── images/
    │   ├── products/
    │   ├── categories/
    │   └── about/
    └── uploads/
```

---

## Setup & Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL
- Apache/Nginx (XAMPP recommended for Windows)

### Installation Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd vet-shop
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install JavaScript dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database** (edit `.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vet_shop
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Seed database** (optional)
```bash
php artisan db:seed --class=PageSeeder
```

8. **Create storage link**
```bash
php artisan storage:link
```

9. **Build assets**
```bash
npm run dev    # For development
npm run build  # For production
```

10. **Start development server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

### Default Admin Account
After seeding, create an admin user manually or via tinker:
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Super Admin',
    'email' => 'admin@vetbazaar.com',
    'password' => Hash::make('password'),
    'role' => 'super_admin',
    'status' => true
]);
```

---

## Key Features Implementation Details

### ID Obfuscation
Uses `HashIdHelper` to encode/decode IDs in URLs for security:
```php
// Encoding
$hashId = HashIdHelper::encode($id);

// Decoding
$id = HashIdHelper::decode($hashId);
```

### Image Upload
Products and categories support image uploads:
- Stored in `public/images/products/` and `public/images/categories/`
- Multiple images per product (JSON array)
- Automatic thumbnail generation (future enhancement)

### Order Number Generation
Unique order numbers: `ORD-{timestamp}-{random}`
```php
'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999)
```

### Profit Calculation
```php
$profit = ($sellingPrice - $buyingPrice) * $quantity
```
Displayed on admin dashboard for delivered orders.

### Search Functionality
- Products: Search by name, filter by category
- Orders: Filter by delivery agent name
- Users: Search by name or email

### Sorting
Products can be sorted by:
- Newest (default)
- Price: Low to High
- Price: High to Low
- Name: A-Z
- Name: Z-A

---

## Security Considerations

1. **Password Hashing**: All passwords hashed using bcrypt
2. **CSRF Protection**: All forms include `@csrf` token
3. **SQL Injection**: Eloquent ORM prevents SQL injection
4. **XSS Protection**: Blade `{{ }}` auto-escapes output
5. **Role-Based Access**: Middleware protects admin routes
6. **ID Obfuscation**: Public URLs use hashed IDs
7. **OTP Expiration**: Password reset OTPs expire in 10 minutes

---

## Future Enhancements

- [ ] Persistent cart for guest users
- [ ] RESTful API with Laravel Sanctum
- [ ] Product reviews and ratings
- [ ] Wishlist functionality
- [ ] Advanced analytics dashboard
- [ ] Real-time order tracking
- [ ] Payment gateway integration (Khalti, eSewa)
- [ ] SMS notifications
- [ ] Multi-language support
- [ ] Product variants (size, color)

---

## Troubleshooting

### Common Issues

**Issue**: Images not displaying
**Solution**: Run `php artisan storage:link`

**Issue**: 500 error on admin routes
**Solution**: Clear cache with `php artisan cache:clear` and `php artisan config:clear`

**Issue**: Emails not sending
**Solution**: Check `.env` mail configuration and ensure mail server is running

**Issue**: Permission denied on uploads
**Solution**: Set proper permissions on `storage/` and `public/uploads/`
```bash
chmod -R 775 storage
chmod -R 775 public/uploads
```

---

## Support & Contact

For technical support or questions about this project, contact the development team.

**Project Version**: 1.0.0  
**Last Updated**: December 2025  
**Framework**: Laravel 10.x
