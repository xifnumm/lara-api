# Customer Inquiry Management API

Laravel-based REST API for managing customer inquiries submitted to the Maldives Stock Exchange website. This system provides a reliable backend for capturing, storing, and retrieving customer inquiries with proper validation and error handling.

## 📋 Overview

This API enables visitors to submit and retrieve inquiries across four key categories:

- **Trading** - Questions about trading operations
- **Market Data** - Queries about market information
- **Technical Issues** - Technical support requests
- **General** - General inquiries

All inquiries are logged reliably for compliance, auditing, and support follow-up purposes.

## 🛠️ Tech Stack

- **Framework:** Laravel 10.x (Latest LTS)
- **Database:** PostgreSQL
- **Language:** PHP 8.1+
- **Architecture:** RESTful API (Backend only)

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── InquiriesController.php    # API logic
│   └── Requests/
│       └── StoreInquiryRequest.php    # Validation rules
├── Models/
│   └── Inquiry.php                     # Database model
database/
└── migrations/
    └── create_inquiries_table.php      # Database schema
routes/
└── api.php                             # API endpoints
```

## 🚀 Setup Instructions

### Prerequisites

- PHP 8.1 or higher
- Composer
- PostgreSQL
- PostgreSQL server (DBngin recommended)

### Installation Steps

1. **Clone the repository**

```bash
   git clone <repository-url>
   cd inquiry-management-api
```

2. **Install dependencies**

```bash
   composer install
```

3. **Configure environment**

```bash
   cp .env.example .env
```

4. **Update database credentials in `.env`**

```env
   DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5454
    DB_DATABASE=lara-api-db
    DB_USERNAME=postgres
    DB_PASSWORD=
```

5. **Generate application key**

```bash
   php artisan key:generate
```

6. **Run database migrations**

```bash
   php artisan migrate
```

7. **Start the development server**

```bash
   php artisan serve
```

The API will be available at: `http://localhost:8000`

## 📡 API Endpoints

### Health Check

```http
GET /api/health
```

Verify API is running.

**Response:**

```json
{
    "status": "ok",
    "message": "API is running",
    "timestamp": "2024-02-09 10:30:00"
}
```

---

### Create Inquiry

```http
POST /api/inquiries
```

**Request Body:**

```json
{
    "name": "Ahmed Hassan",
    "email": "ahmed@example.mv",
    "category": "trading",
    "subject": "Trading Hours Query",
    "message": "What are the trading hours for MSE?"
}
```

**Valid Categories:**

- `trading`
- `market_data`
- `technical_issues`
- `general`

**Success Response (201):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed Hassan",
        "email": "ahmed@example.mv",
        "category": "trading",
        "subject": "Trading Hours Query",
        "message": "What are the trading hours for MSE?",
        "created_at": "2024-02-09T10:30:00.000000Z",
        "updated_at": "2024-02-09T10:30:00.000000Z"
    },
    "message": "Inquiry submitted successfully"
}
```

**Validation Error Response (422):**

```json
{
    "success": false,
    "message": "Validation failed. Please check your input.",
    "errors": {
        "email": ["Please provide a valid email address."],
        "category": [
            "Invalid category. Choose from: trading, market_data, technical_issues, or general."
        ]
    }
}
```

---

### List All Inquiries

```http
GET /api/inquiries
```

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Ahmed Hassan",
            "email": "ahmed@example.mv",
            "category": "trading",
            "subject": "Trading Hours Query",
            "message": "What are the trading hours for MSE?",
            "created_at": "2024-02-09T10:30:00.000000Z",
            "updated_at": "2024-02-09T10:30:00.000000Z"
        }
    ],
    "message": "Inquiries retrieved successfully"
}
```

---

### Get Specific Inquiry

```http
GET /api/inquiries/{id}
```

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Ahmed Hassan",
        "email": "ahmed@example.mv",
        "category": "trading",
        "subject": "Trading Hours Query",
        "message": "What are the trading hours for MSE?",
        "created_at": "2024-02-09T10:30:00.000000Z",
        "updated_at": "2024-02-09T10:30:00.000000Z"
    },
    "message": "Inquiry retrieved successfully"
}
```

**Not Found Response (404):**

```json
{
    "success": false,
    "message": "Inquiry not found"
}
```

## 🧪 Testing the API

### Using cURL

**Create an inquiry:**

```bash
curl -X POST http://localhost:8000/api/inquiries \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ahmed Hassan",
    "email": "ahmed@example.mv",
    "category": "trading",
    "subject": "Trading Hours Query",
    "message": "What are the trading hours for MSE?"
  }'
```

**Get all inquiries:**

```bash
curl http://localhost:8000/api/inquiries
```

**Get specific inquiry:**

```bash
curl http://localhost:8000/api/inquiries/1
```

### Using Postman

1. Import the endpoints listed above
2. Set `Content-Type: application/json` header
3. Use the example request bodies

## 🗄️ Database Schema

**Table: `inquiries`**

| Column     | Type         | Constraints |
| ---------- | ------------ | ----------- |
| id         | BIGSERIAL    | PRIMARY KEY |
| name       | VARCHAR(255) | NOT NULL    |
| email      | VARCHAR(255) | NOT NULL    |
| category   | ENUM         | NOT NULL    |
| subject    | VARCHAR(255) | NOT NULL    |
| message    | TEXT         | NOT NULL    |
| created_at | TIMESTAMP    | NULL        |
| updated_at | TIMESTAMP    | NULL        |

**Category ENUM values:**

- trading
- market_data
- technical_issues
- general

## ✨ Features

### Core Features

- ✅ RESTful API design with proper HTTP methods
- ✅ PostgreSQL database integration with Eloquent ORM
- ✅ Comprehensive validation with Form Requests
- ✅ Database transaction handling for data integrity
- ✅ Robust error handling with appropriate HTTP status codes
- ✅ Consistent JSON response formatting
- ✅ Request/error logging for debugging and compliance
- ✅ Mass assignment protection
- ✅ SQL injection prevention via Eloquent
- ✅ Clean, maintainable code following Laravel conventions

### Future Enhancements

- 📊 Pagination for large datasets
- 🔍 Advanced filtering (by category, date range, status)
- 📈 Inquiry status tracking (pending, in-progress, resolved)
- 🔐 API authentication and authorization
- ⚡ Rate limiting to prevent abuse
- 📧 Email notifications for new inquiries
- 📊 Analytics and reporting dashboard
- 🧪 Comprehensive automated testing suite
- 🔄 Soft deletes for inquiry records
- 🌐 Internationalization support

## 🐛 Troubleshooting

### Database Connection Issues

**Error:** `SQLSTATE[08006] Connection refused`

**Solution:**

1. Ensure PostgreSQL is running (check your PostgreSQL server)
2. Verify credentials in `.env`
3. Check if database exists: `psql -U postgres -l`

---

### Migration Errors

**Error:** `Base table or view not found`

**Solution:**

```bash
php artisan migrate:fresh
```

---

### Port Already in Use

**Error:** `Address already in use`

**Solution:**

```bash
php artisan serve --port=8001
```

---

### Vendor Folder Missing

**Error:** `Class not found`

**Solution:**

```bash
composer install
```

## 📚 Laravel Conventions

This project adheres to Laravel best practices:

- RESTful routing patterns
- Eloquent ORM for database interactions
- Form Request classes for validation
- Resource controllers for clean separation
- Database migrations for version-controlled schema
- Environment-based configuration
- Proper naming conventions (singular models, plural controllers)

## 🔧 Development

### Running in Development

```bash
php artisan serve
```

### Database Management

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (drop all tables and re-migrate)
php artisan migrate:fresh

# Check migration status
php artisan migrate:status
```

### Logs

Application logs are stored in `storage/logs/laravel.log`

## 📝 Configuration

### Environment Variables

Key configuration options in `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5454
DB_DATABASE=lara-api-db
DB_USERNAME=postgres
DB_PASSWORD=

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

**Important:** Set `APP_DEBUG=false` in production environments.

---

**Built with:** Laravel • PostgreSQL • RESTful API Design

**Last Updated:** February 9, 2024
