# ImpactGuru CRM - Customer Management System

## 📋 Project Description

**ImpactGuru CRM** is a modern, role-based customer relationship management system built with Laravel 12 and Blade templating. It provides a comprehensive solution for managing customers, orders, and staff with real-time notifications and admin dashboards.

The system is designed to help businesses:
- Manage customer information and profiles with image uploads
- Track customer orders and order status
- Send real-time email and database notifications to admins
- Control access with role-based permissions (Admin & Staff)
- Export data to CSV and PDF formats
- Search and filter customer data instantly

**Tech Stack:**
- **Backend:** Laravel 12.x
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL with Soft Deletes
- **Authentication:** Laravel Breeze
- **Notifications:** Laravel Notifications (Mail + Database)
- **Export:** PDF (DomPDF), CSV

---

## 🚀 Installation Steps

### Prerequisites
- PHP 8.4+
- Composer
- MySQL Server
- Node.js & npm (for Vite)

### Step 1: Clone Repository
```bash
git clone https://github.com/rutujashinde0305/-ImpactGuru-Mini-CRM-A-Customer-Management-System.git
cd impactguru-crm
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=impactguru_crm
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Configure Mail (Gmail SMTP)
Update `.env` with Gmail credentials:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="ImpactGuruCRM"
```

**To get Gmail App Password:**
1. Go to https://myaccount.google.com/apppasswords
2. Select "Mail" and "Windows Computer"
3. Copy the 16-character password and paste in `.env`

### Step 6: Configure Queue
Update `.env`:
```env
QUEUE_CONNECTION=sync
```
(Using `sync` for immediate notification processing)

### Step 7: Run Migrations
```bash
php artisan migrate --seed
```

### Step 8: Create Storage Link
```bash
php artisan storage:link
```

### Step 9: Start Development Server
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite (for CSS/JS compilation)
npm run dev
```

Visit: `http://127.0.0.1:8000`

---

## ✨ Feature List

### 🔐 Authentication & Authorization
- ✅ User registration and login (Laravel Breeze)
- ✅ Role-based access control (Admin & Staff)
- ✅ Secure password hashing with bcrypt
- ✅ Session management
- ✅ Email verification support

### 👥 Customer Management
- ✅ Create, read, update, delete customers
- ✅ Profile image upload and display
- ✅ Search customers by name, email, or phone
- ✅ Soft delete with restore functionality
- ✅ View deleted customers (Admin only)
- ✅ Export customers to CSV/PDF
- ✅ Customer dashboard with recent additions

### 📦 Order Management
- ✅ Create and manage customer orders
- ✅ Track order status (Pending, Completed, Cancelled)
- ✅ View order details and history
- ✅ Link orders to customers
- ✅ Order date tracking
- ✅ Amount and revenue tracking

### 🔔 Notification System
- ✅ Real-time email notifications to admin
- ✅ Database notifications with read/unread status
- ✅ Notification dashboard (Latest 5 unread)
- ✅ Creator attribution (who created the customer/order)
- ✅ Mark notifications as read
- ✅ View all notifications with pagination
- ✅ Instant processing with sync queue driver

### 📊 Admin Dashboard
- ✅ Total customers count
- ✅ Total orders count
- ✅ Total revenue calculation
- ✅ Recent customers list
- ✅ Recent orders list
- ✅ Unread notifications display
- ✅ Quick action buttons (Add Customer, Add Order, etc.)
- ✅ Role-specific views (Admin vs Staff)

### 👨‍💼 User Management
- ✅ Create and manage staff/admin users
- ✅ Assign roles (Admin, Staff)
- ✅ User profile with image upload
- ✅ Edit user information
- ✅ Delete users (Admin only)

### 📤 Data Export
- ✅ Export customers to CSV
- ✅ Export customers to PDF
- ✅ Export orders to CSV
- ✅ Export orders to PDF
- ✅ Formatted reports with proper headers

### 🔍 Search & Filter
- ✅ Instant AJAX customer search
- ✅ Search by name, email, phone
- ✅ Real-time results without page reload
- ✅ Filter functionality in tables

### 🎨 User Interface
- ✅ Responsive Tailwind CSS design
- ✅ Dark mode support
- ✅ Mobile-friendly layout
- ✅ Clean and intuitive navigation
- ✅ Form validation with error messages
- ✅ Status badges for order states

---

## 🔑 Role Permissions Summary

### Admin User
Full access to all features:
- ✅ View, create, edit, delete customers
- ✅ Soft delete and restore customers
- ✅ View deleted customers
- ✅ Create and manage orders
- ✅ Create and manage users
- ✅ Receive email notifications
- ✅ View and manage all notifications
- ✅ Export data to CSV/PDF
- ✅ Access admin dashboard
- ✅ Manage user roles and permissions

### Staff User
Limited access with restrictions:
- ✅ View customer list and details
- ✅ Create new customers
- ✅ Edit customer information
- ✅ View orders
- ✅ Create new orders
- ✅ Search customers
- ✅ Export data to CSV/PDF
- ✅ View personal dashboard
- ❌ Cannot delete customers
- ❌ Cannot manage users
- ❌ Cannot access soft-deleted customers
- ❌ Cannot receive notifications

### Permission Matrix

| Feature | Admin | Staff |
|---------|-------|-------|
| View Customers | ✅ | ✅ |
| Create Customer | ✅ | ✅ |
| Edit Customer | ✅ | ✅ |
| Delete Customer | ✅ | ❌ |
| View Deleted | ✅ | ❌ |
| Restore Customer | ✅ | ❌ |
| View Orders | ✅ | ✅ |
| Create Order | ✅ | ✅ |
| Edit Order | ✅ | ✅ |
| Delete Order | ✅ | ❌ |
| Manage Users | ✅ | ❌ |
| View Notifications | ✅ | ❌ |
| Receive Emails | ✅ | ❌ |
| Admin Dashboard | ✅ | ❌ |
| Staff Dashboard | ✅ | ✅ |
| Export Data | ✅ | ✅ |

---

## 📁 Project Structure

```
impactguru-crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CustomerController.php
│   │   │   ├── OrderController.php
│   │   │   ├── UserController.php
│   │   │   ├── DashboardController.php
│   │   │   └── NotificationController.php
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php
│   │   │   └── IsStaffOrAdmin.php
│   │   └── Requests/
│   │       ├── StoreCustomerRequest.php
│   │       └── UpdateCustomerRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Customer.php
│   │   └── Order.php
│   └── Notifications/
│       ├── NewCustomerNotification.php
│       └── NewOrderNotification.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── customers/
│   │   ├── orders/
│   │   ├── users/
│   │   ├── dashboard/
│   │   ├── notifications/
│   │   └── layouts/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── auth.php
├── storage/
│   ├── app/
│   │   └── public/
│   │       └── profiles/ (Customer/User images)
│   └── logs/
├── tests/
├── .env
├── artisan
├── composer.json
└── package.json
```

---

## 🗄️ Database Schema

### Users Table
```sql
id, name, email, password, role, profile_image, created_at, updated_at
```

### Customers Table
```sql
id, name, email, phone, address, profile_image, deleted_at, created_at, updated_at
```

### Orders Table
```sql
id, customer_id, order_number, amount, status, order_date, created_at, updated_at
```

### Notifications Table
```sql
id, notifiable_type, notifiable_id, type, data (JSON), read_at, created_at
```

---

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Test Files Location
```
tests/
├── Feature/
├── Unit/
└── TestCase.php
```

---

## 🔐 Security Features

- ✅ CSRF protection on all forms
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection with Blade escaping
- ✅ Password hashing with bcrypt
- ✅ Role-based middleware authentication
- ✅ Soft deletes preserve data integrity
- ✅ Database transactions for critical operations

---

## 📧 Email Configuration

### Supported Drivers
- **SMTP** (Production - Gmail, SendGrid, etc.)
- **Log** (Development - logs to `storage/logs/laravel.log`)

### Notification Emails Include
- Customer name and creation details
- Creator attribution (who created the record)
- Direct link to view the resource
- Professional email template

---

## 📱 API Endpoints

### Customers
- `GET /customers` - List all customers
- `GET /customers/create` - Customer creation form
- `POST /customers` - Store new customer
- `GET /customers/{customer}` - View customer details
- `GET /customers/{customer}/edit` - Edit form
- `PATCH /customers/{customer}` - Update customer
- `DELETE /customers/{customer}` - Delete customer (soft)
- `GET /customers/trashed` - View soft-deleted customers (Admin)
- `PATCH /customers/{id}/restore` - Restore customer (Admin)
- `DELETE /customers/{id}/force` - Permanent delete (Admin)

### Orders
- `GET /orders` - List all orders
- `GET /orders/create` - Order creation form
- `POST /orders` - Store new order
- `GET /orders/{order}` - View order details
- `GET /orders/{order}/edit` - Edit form
- `PATCH /orders/{order}` - Update order
- `DELETE /orders/{order}` - Delete order (Admin)

### Users
- `GET /users` - List users (Admin)
- `GET /users/create` - User creation form (Admin)
- `POST /users` - Store new user (Admin)
- `GET /users/{user}/edit` - Edit user (Admin)
- `PATCH /users/{user}` - Update user (Admin)
- `DELETE /users/{user}` - Delete user (Admin)

### Notifications
- `GET /notifications` - View all notifications (Admin)
- `POST /notifications/{id}/read` - Mark as read (Admin)
- `POST /notifications/read-all` - Mark all as read (Admin)

---

## 🐛 Troubleshooting

### Issue: Notifications not appearing
**Solution:** Ensure `QUEUE_CONNECTION=sync` in `.env` and run:
```bash
php artisan config:clear
php artisan cache:clear
```

### Issue: Emails not sending
**Solution:** 
1. Verify Gmail app password in `.env`
2. Enable "Less secure app access" (if not using app password)
3. Check `storage/logs/laravel.log` for errors

### Issue: Images not displaying
**Solution:** Run storage link command:
```bash
php artisan storage:link
```

### Issue: 404 on routes
**Solution:** Clear route cache:
```bash
php artisan route:clear
php artisan cache:clear
```

### Issue: Database errors during migration
**Solution:**
```bash
php artisan migrate:fresh --seed
```

---

## 📝 Default Credentials

After running migrations and seeding:

**Admin User:**
- Email: `rutujashinde0305@gmail.com`
- Password: See `.env` or user table

**Staff User:**
- Email: `test@example.com`
- Password: See `.env` or user table

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**Rutuja Shinde**
- Email: rutujashinde0305@gmail.com
- GitHub: [@rutujashinde0305](https://github.com/rutujashinde0305)

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Laravel Breeze
- DomPDF for PDF generation
- All open-source contributors

---

## 📞 Support

For support, email rutujashinde0305@gmail.com or open an issue in the repository.

---

**Last Updated:** December 8, 2025
**Version:** 1.0.0
