# ImpactGuru CRM - REST API Documentation

## Authentication

The API uses Laravel Sanctum for authentication. All endpoints require a valid API token.

### Getting an API Token

To generate a token for a user, run:

```bash
php artisan tinker
```

Then in the Tinker shell:

```php
$user = User::first(); // or User::find(id)
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

Copy the token and use it in your API requests.

### Making API Requests

Include the token in the `Authorization` header:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

## API Endpoints

### Customers

#### List Customers (Paginated)
```
GET /api/customers
```

Response:
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [...],
    "per_page": 15,
    "total": 100
  }
}
```

#### Get Customer by ID
```
GET /api/customers/{id}
```

Response:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "123-456-7890",
    "address": "123 Main St"
  }
}
```

#### Create Customer
```
POST /api/customers
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "098-765-4321",
  "address": "456 Oak Ave"
}
```

Response (201 Created):
```json
{
  "success": true,
  "message": "Customer created successfully",
  "data": {
    "id": 2,
    "name": "Jane Doe",
    ...
  }
}
```

#### Update Customer (Admin only)
```
PUT /api/customers/{id}
Authorization: Bearer TOKEN
Content-Type: application/json

{
  "name": "Jane Smith",
  "email": "jane.smith@example.com",
  "phone": "098-765-4322",
  "address": "456 Oak Ave Apt 2"
}
```

Response:
```json
{
  "success": true,
  "message": "Customer updated successfully",
  "data": {...}
}
```

#### Delete Customer (Admin only)
```
DELETE /api/customers/{id}
Authorization: Bearer TOKEN
```

Response:
```json
{
  "success": true,
  "message": "Customer deleted successfully"
}
```

### Orders

#### List Orders (Paginated)
```
GET /api/orders?status=Pending
```

Query Parameters:
- `status` (optional): Filter by status (Pending, Completed, Cancelled)

Response:
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [...],
    "per_page": 15,
    "total": 50
  }
}
```

#### Get Order by ID
```
GET /api/orders/{id}
```

Response:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "order_number": "ORD-2025-001",
    "customer_id": 1,
    "customer": {
      "id": 1,
      "name": "John Doe"
    },
    "amount": "1500.00",
    "status": "Pending",
    "order_date": "2025-12-06"
  }
}
```

#### Create Order
```
POST /api/orders
Content-Type: application/json

{
  "customer_id": 1,
  "order_number": "ORD-2025-002",
  "amount": 2500.00,
  "status": "Pending",
  "order_date": "2025-12-06"
}
```

Response (201 Created):
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {...}
}
```

#### Update Order (Admin only)
```
PUT /api/orders/{id}
Authorization: Bearer TOKEN
Content-Type: application/json

{
  "customer_id": 1,
  "order_number": "ORD-2025-002",
  "amount": 2600.00,
  "status": "Completed",
  "order_date": "2025-12-06"
}
```

#### Delete Order (Admin only)
```
DELETE /api/orders/{id}
Authorization: Bearer TOKEN
```

Response:
```json
{
  "success": true,
  "message": "Order deleted successfully"
}
```

## Error Handling

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "Unauthorized action."
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Customer not found"
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

## Example cURL Requests

### Get Token
```bash
php artisan tinker
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

### List Customers
```bash
curl -X GET http://localhost:8000/api/customers \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Create Customer
```bash
curl -X POST http://localhost:8000/api/customers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Customer",
    "email": "new@example.com",
    "phone": "555-1234",
    "address": "789 Elm St"
  }'
```

### Update Customer
```bash
curl -X PUT http://localhost:8000/api/customers/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "email": "updated@example.com",
    "phone": "555-5678",
    "address": "789 Elm St Apt 1"
  }'
```

### Delete Customer
```bash
curl -X DELETE http://localhost:8000/api/customers/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Rate Limiting

API requests are not currently rate-limited, but this can be added in middleware if needed.

## CORS

API endpoints are accessible from the configured sanctum domains. Cross-origin requests from SPAs are supported.
