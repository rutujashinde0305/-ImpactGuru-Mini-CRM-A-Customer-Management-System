# ImpactGuru CRM - Complete Feature Overview

## 1. Authentication & Authorization

### Features
- **User Authentication**: Login, register, password reset
- **Email Verification**: Users must verify email before accessing dashboard
- **Role-Based Access**: Admin and Staff roles
- **API Token Authentication**: Sanctum-based API tokens for REST endpoints

### Files
- `app/Http/Middleware/Authenticate.php`
- `app/Models/User.php`
- `routes/auth.php`

---

## 2. Customer Management

### Features
- **CRUD Operations**: Create, Read, Update, Delete customers
- **Profile Images**: Upload and display customer profile pictures
- **Search & Filtering**: Real-time AJAX search by name, email, phone
- **Soft Deletes**: Soft-delete customers and restore from trash
- **Pagination**: 10 customers per page
- **Export**: CSV and PDF export of all customers

### Routes
```
GET    /customers              # List all customers
GET    /customers/create       # Show create form
POST   /customers              # Store new customer
GET    /customers/{id}         # Show customer details
GET    /customers/{id}/edit    # Show edit form
PUT    /customers/{id}         # Update customer
DELETE /customers/{id}         # Soft delete customer
GET    /customers/trashed      # View deleted customers
PATCH  /customers/{id}/restore # Restore deleted customer
DELETE /customers/{id}/force   # Permanently delete customer
GET    /customers/search/ajax  # AJAX search endpoint
GET    /customers/export/csv   # Export to CSV
GET    /customers/export/pdf   # Export to PDF
```

### Database
```sql
customers (id, name, email, phone, address, profile_image, created_at, updated_at, deleted_at)
```

### Models
- `app/Models/Customer.php`
- Relationships: `hasMany(Order::class)`

---

## 3. Order Management

### Features
- **CRUD Operations**: Create, Read, Update, Delete orders
- **Status Tracking**: Pending, Completed, Cancelled
- **Customer Association**: Link orders to customers
- **Order Numbers**: Unique order identifiers
- **Amount Tracking**: Decimal currency amounts
- **Admin Notifications**: Send email/database notifications to admins on new order
- **Status Filtering**: Filter orders by status
- **Pagination**: 10 orders per page
- **Export**: CSV and PDF export

### Routes
```
GET    /orders                 # List all orders
GET    /orders/create          # Show create form
POST   /orders                 # Store new order
GET    /orders/{id}            # Show order details
GET    /orders/{id}/edit       # Show edit form
PUT    /orders/{id}            # Update order
DELETE /orders/{id}            # Delete order
GET    /orders/export/csv      # Export to CSV
GET    /orders/export/pdf      # Export to PDF
```

### Database
```sql
orders (id, customer_id, order_number, amount, status, order_date, created_at, updated_at)
```

### Models
- `app/Models/Order.php`
- Relationships: `belongsTo(Customer::class)`

---

## 4. Dashboard

### Features
- **Role-Based Dashboards**: Different views for Admin and Staff
- **Statistics Cards**: Total customers, orders, revenue
- **Recent Customers**: Display 5 most recent customers
- **Quick Actions**: Links to add customers or view orders
- **Dark Mode**: Full dark mode support

### Routes
```
GET /dashboard  # Main dashboard
```

### Components
- `resources/views/components/stat-card.blade.php` - Reusable stat card component

---

## 5. Notifications & Mail

### Features
- **Order Notifications**: Send email and database notifications when new order created
- **Admin Recipients**: Only admins receive order notifications
- **Email Content**: Includes order details, customer info, amount
- **Database Storage**: Notifications stored in database for history

### Notification Classes
- `app/Notifications/NewOrderNotification.php`

### Database
```sql
notifications (id, notifiable_id, type, data, read_at, created_at)
```

### Configuration
- Mail service via `.env` (Mailtrap, Gmail, SendGrid, etc.)
- Mailtrap recommended for development

---

## 6. REST API (Sanctum)

### Authentication
- Token-based using Laravel Sanctum
- Generate tokens: `php artisan app:generate-api-token`
- Include in requests: `Authorization: Bearer TOKEN`

### Customer Endpoints
```
GET    /api/customers              # List (paginated, 15 per page)
GET    /api/customers/{id}         # Get by ID
POST   /api/customers              # Create
PUT    /api/customers/{id}         # Update (admin only)
DELETE /api/customers/{id}         # Delete (admin only)
```

### Order Endpoints
```
GET    /api/orders?status=pending   # List with optional filtering
GET    /api/orders/{id}             # Get by ID
POST   /api/orders                  # Create
PUT    /api/orders/{id}             # Update (admin only)
DELETE /api/orders/{id}             # Delete (admin only)
```

### Response Format
```json
{
  "success": true,
  "message": "Action completed",
  "data": { ... }
}
```

### Controllers
- `app/Http/Controllers/Api/CustomerApiController.php`
- `app/Http/Controllers/Api/OrderApiController.php`

---

## 7. File Management & Storage

### Features
- **Profile Images**: Upload customer profile images
- **Public Storage**: Images stored in `storage/app/public/profiles/`
- **Symlink**: Public access via `public/storage/` symlink
- **Display**: Show images with fallback to default avatar
- **Cleanup**: Delete images when customer/image is removed

### Artisan Commands
```bash
php artisan storage:link  # Create symlink
```

### Default Avatar
- Path: `public/images/default-avatar.png`
- SVG-based placeholder

---

## 8. Error Handling

### Custom Error Pages
- **404**: Page not found (`resources/views/errors/404.blade.php`)
- **500**: Server error (`resources/views/errors/500.blade.php`)

### Logging
- All errors logged to `storage/logs/laravel.log`
- View logs: `tail -f storage/logs/laravel.log`

### Validation
- Form request validation classes
- Server-side validation on all inputs
- Error messages displayed to users

---

## 9. Search & Filtering

### Features
- **AJAX Search**: Real-time customer search without page reload
- **Debouncing**: 300ms delay after typing stops
- **Multi-Field Search**: Search by name, email, phone
- **Status Filtering**: Filter orders by status

### Search Endpoint
```
GET /customers/search/ajax?search=term
```

---

## 10. Exports (CSV & PDF)

### CSV Export
- Streaming response using `php://output`
- Efficient for large datasets
- Headers included for spreadsheet applications
- Customers: CSV export with all fields
- Orders: CSV export with customer names

### PDF Export
- Uses `barryvdh/laravel-dompdf`
- Custom Blade templates for formatting
- Downloads as attachment
- Customers: `resources/views/customers/pdf.blade.php`
- Orders: `resources/views/orders/pdf.blade.php`

### Routes
```
GET /customers/export/csv
GET /customers/export/pdf
GET /orders/export/csv
GET /orders/export/pdf
```

---

## 11. Form Requests & Validation

### Customer Requests
- `app/Http/Requests/StoreCustomerRequest.php`
- `app/Http/Requests/UpdateCustomerRequest.php`

### Fields
- Name (required)
- Email (required, unique, email format)
- Phone (required)
- Address (optional)
- Profile Image (optional, image file)

---

## 12. Views & UI

### Layout Components
- `resources/views/layouts/app.blade.php` - Main app layout with navigation
- `resources/views/layouts/guest.blade.php` - Guest layout for auth pages

### Customer Views
- `resources/views/customers/index.blade.php` - List with AJAX search
- `resources/views/customers/create.blade.php` - Create form
- `resources/views/customers/edit.blade.php` - Edit form
- `resources/views/customers/show.blade.php` - Detail view with profile image
- `resources/views/customers/trashed.blade.php` - Soft-deleted customers
- `resources/views/customers/_table.blade.php` - Partial table for AJAX
- `resources/views/customers/pdf.blade.php` - PDF template

### Order Views
- `resources/views/orders/index.blade.php` - List with status filtering
- `resources/views/orders/create.blade.php` - Create form
- `resources/views/orders/edit.blade.php` - Edit form
- `resources/views/orders/show.blade.php` - Detail view
- `resources/views/orders/pdf.blade.php` - PDF template

### Dashboard Views
- `resources/views/dashboard/admin.blade.php` - Admin dashboard
- `resources/views/dashboard/staff.blade.php` - Staff dashboard

### Error Views
- `resources/views/errors/404.blade.php`
- `resources/views/errors/500.blade.php`

---

## 13. Styling

### Framework
- **Tailwind CSS**: Utility-first CSS framework
- **Dark Mode**: Full dark mode support via `dark:` classes
- **Responsive**: Mobile-first responsive design

### Key Classes Used
- `bg-white dark:bg-gray-800` - Background with dark mode
- `text-gray-900 dark:text-gray-100` - Text colors
- `px-6 py-3` - Padding utilities
- `grid grid-cols-1 md:grid-cols-3` - Responsive grid

---

## 14. Middleware & Security

### Middleware
- `auth` - Require authentication
- `verified` - Require email verification
- `admin` - Require admin role (for API)

### Security Features
- CSRF protection on all POST/PUT/PATCH/DELETE
- Password hashing with bcrypt
- Email verification
- Soft deletes for data protection

---

## 15. Database Migrations

### Migration Files
- `0001_01_01_000000_create_users_table.php`
- `0001_01_01_000001_create_cache_table.php`
- `0001_01_01_000002_create_jobs_table.php`
- `2025_12_06_110001_create_personal_access_tokens_table.php`
- `2025_12_06_110948_add_role_to_users_table.php`
- `2025_12_06_111409_create_customers_table.php`
- `2025_12_06_120001_create_orders_table.php`

### Running Migrations
```bash
php artisan migrate
php artisan migrate:refresh --seed
```

---

## 16. Seeding & Sample Data

### Database Seeder
- `database/seeders/DatabaseSeeder.php`
- Creates sample users, customers, orders

### Running Seeders
```bash
php artisan db:seed
php artisan db:seed DatabaseSeeder
```

---

## 17. Configuration Files

### Key Files
- `.env` - Environment variables
- `config/app.php` - Application configuration
- `config/database.php` - Database configuration
- `config/mail.php` - Mail configuration
- `config/sanctum.php` - API authentication
- `config/filesystems.php` - File storage

---

## 18. Artisan Commands

### Custom Commands
```bash
php artisan app:generate-api-token          # Generate API token for user
php artisan app:generate-api-token --user=1 # For specific user
```

### Common Commands
```bash
php artisan migrate                  # Run migrations
php artisan db:seed                 # Seed database
php artisan storage:link            # Create storage symlink
php artisan tinker                  # Interactive shell
php artisan queue:work              # Run queue worker
php artisan notifications:table     # Create notifications table
```

---

## 19. Testing

### Unit Tests
- Located in `tests/Unit/`

### Feature Tests
- Located in `tests/Feature/`

### Running Tests
```bash
php artisan test
php artisan test --filter=CustomerTest
```

---

## 20. Deployment

### Production Checklist
- [ ] Set `.env` variables for production
- [ ] Run `php artisan migrate --force`
- [ ] Create storage symlink: `php artisan storage:link`
- [ ] Configure mail service
- [ ] Set up error logging
- [ ] Enable HTTPS
- [ ] Configure Sanctum domains
- [ ] Set proper file permissions
- [ ] Back up database
- [ ] Configure auto-backup strategy

### Deployment Commands
```bash
composer install --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## Summary Statistics

- **Models**: 2 (Customer, Order)
- **Controllers**: 4 (Customer, Order, Dashboard, API controllers)
- **Views**: 25+ (CRUD, dashboard, errors, partials)
- **Routes**: 30+ (web + API)
- **Migrations**: 7
- **Notifications**: 1
- **API Endpoints**: 10+ (Customers + Orders)
- **Tests**: Ready for implementation

---

## Getting Started

1. **Setup**: Follow `SETUP_AND_TESTING.md`
2. **Configuration**: Set up mail in `MAIL_CONFIGURATION.md`
3. **API Testing**: Check `API_DOCUMENTATION.md`
4. **Development**: Run `php artisan serve` and start building!

---

## Support & Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Laravel Notifications](https://laravel.com/docs/notifications)
