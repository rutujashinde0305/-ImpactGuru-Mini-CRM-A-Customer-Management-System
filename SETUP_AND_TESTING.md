# ImpactGuru CRM - Setup & Testing Guide

## Initial Setup

### 1. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 2. Create Symbolic Link for Storage
```bash
php artisan storage:link
```

This creates `public/storage` symlink to `storage/app/public` for file uploads.

### 3. Generate API Token

To test the API, you need an API token. Run:

```bash
php artisan app:generate-api-token
```

Or specify a user:
```bash
php artisan app:generate-api-token --user=1
```

Or use Tinker:
```bash
php artisan tinker
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

## API Testing

### Using Postman

1. Create a new request collection
2. Set the base URL to `http://localhost:8000/api`
3. In the request headers, add:
   ```
   Authorization: Bearer YOUR_TOKEN_HERE
   Content-Type: application/json
   ```

### Using cURL

#### 1. Get API Token
```bash
# Run in PHP Artisan Tinker
php artisan tinker
```

Then in Tinker:
```php
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

#### 2. List Customers
```bash
curl -X GET http://localhost:8000/api/customers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

#### 3. Get Single Customer
```bash
curl -X GET http://localhost:8000/api/customers/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

#### 4. Create Customer
```bash
curl -X POST http://localhost:8000/api/customers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "123-456-7890",
    "address": "123 Main Street"
  }'
```

#### 5. Update Customer (Admin Only)
```bash
curl -X PUT http://localhost:8000/api/customers/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "phone": "098-765-4321",
    "address": "456 Oak Avenue"
  }'
```

#### 6. Delete Customer (Admin Only)
```bash
curl -X DELETE http://localhost:8000/api/customers/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Using the Web Interface

1. **Dashboard**: http://localhost:8000/dashboard
2. **Customers**: http://localhost:8000/customers
3. **Orders**: http://localhost:8000/orders

## Error Handling

### Common Errors

#### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```
**Solution**: Ensure you're including a valid token in the Authorization header.

#### 403 Forbidden
```json
{
  "message": "Unauthorized action."
}
```
**Solution**: You need admin role to perform this action.

#### 404 Not Found
```json
{
  "success": false,
  "message": "Customer not found"
}
```
**Solution**: Check that the ID exists.

#### 422 Unprocessable Entity
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "name": ["The name field is required."]
  }
}
```
**Solution**: Provide all required fields with valid data.

## File Uploads

### Upload Profile Image

When creating or updating a customer via the web interface:

```blade
<form method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="profile_image" accept="image/*">
    <input type="submit">
</form>
```

For API requests with file upload:

```bash
curl -X POST http://localhost:8000/api/customers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "phone=123-456-7890" \
  -F "profile_image=@/path/to/image.jpg"
```

The image will be stored in `storage/app/public/profiles/` and accessible via:
```
http://localhost:8000/storage/profiles/filename.jpg
```

## Logging

All errors are logged to `storage/logs/laravel.log`. Check this file for debugging:

```bash
tail -f storage/logs/laravel.log
```

## Testing with Different Roles

### Create an Admin User

In Tinker:
```php
$admin = User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
$token = $admin->createToken('admin-token')->plainTextToken;
echo $token;
```

### Create a Staff User

In Tinker:
```php
$staff = User::create([
    'name' => 'Staff User',
    'email' => 'staff@example.com',
    'password' => bcrypt('password'),
    'role' => 'staff'
]);
$token = $staff->createToken('staff-token')->plainTextToken;
echo $token;
```

## Performance Tips

1. **Pagination**: API endpoints return 15 items per page by default
2. **Filtering**: Orders can be filtered by status: `/api/orders?status=Pending`
3. **Relationships**: Customer data includes related orders when available
4. **Caching**: Consider implementing query caching for high-traffic endpoints

## Security Considerations

1. **API Tokens**: Keep tokens secure and never commit them to version control
2. **HTTPS**: Use HTTPS in production
3. **Rate Limiting**: Consider implementing rate limiting for production
4. **CORS**: API respects Sanctum's stateful domain configuration
5. **Validation**: All inputs are validated server-side

## Database Seeding

To populate test data:

```bash
php artisan db:seed DatabaseSeeder
```

This will create:
- Demo users
- Sample customers
- Sample orders

## Deployment Checklist

- [ ] Set `.env` variables for production
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Create storage symlink: `php artisan storage:link`
- [ ] Configure Sanctum domains in `config/sanctum.php`
- [ ] Set proper file permissions on `storage/` directory
- [ ] Enable HTTPS in `.env`
- [ ] Set up error logging and monitoring
- [ ] Configure backup strategy
