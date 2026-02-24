# Jussilog

**The Product Catalog powered by the Laravel Framework**

Jussilog is a modern product catalog API built with Laravel 10, designed for easy deployment on Google Cloud Run with Docker support. It provides a RESTful API for managing products with features like inventory tracking, pricing, images, and visibility controls.

## Features

- **Product Management**: Full CRUD operations for products
- **RESTful API**: Clean, intuitive API endpoints
- **SQLite Database**: Lightweight database for development and demo deployments
- **Docker Support**: Production-ready Docker configuration
- **Cloud Run Ready**: Optimized for Google Cloud Run deployment
- **Laravel Sanctum**: API authentication support
- **Vite Frontend Assets**: Modern frontend build pipeline

## Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Web Server**: Nginx + PHP-FPM
- **Frontend Build**: Vite
- **Authentication**: Laravel Sanctum
- **Containerization**: Docker & Docker Compose

## Quick Start

### Prerequisites

- Docker and Docker Compose installed
- Git

### Local Development with Docker

1. **Clone the repository**
   ```bash
   git clone https://github.com/jussipalanen/jussilog-backend.git
   cd jussilog-backend
   ```

2. **Generate Application Key**
   ```bash
   # If you have PHP installed locally
   php artisan key:generate
   
   # Copy the key from .env file
   cat .env | grep APP_KEY
   ```

3. **Update docker-compose.yml**
   
   Edit `docker-compose.yml` and replace `APP_KEY` value with your generated key:
   ```yaml
   APP_KEY: base64:YOUR_GENERATED_KEY_HERE
   ```

4. **Build and Start the Container**
   ```bash
   docker-compose up --build
   ```

5. **Access the Application**
   - API: http://localhost:8000
   - Health Check: http://localhost:8000/api/hello

### Local Development without Docker

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed  # Optional: seed sample data
   ```

4. **Build Frontend Assets**
   ```bash
   npm run build
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

## API Endpoints

### Public Endpoints

- `GET /api/hello` - Health check endpoint
- `GET /api/products` - List all products
- `GET /api/products/{id}` - Get single product
- `POST /api/products` - Create new product
- `DELETE /api/products/{id}` - Delete product

### Protected Endpoints (Sanctum Authentication)

- `GET /api/user` - Get authenticated user

### Example API Usage

**List all products:**
```bash
curl http://localhost:8000/api/products
```

**Create a product:**
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Wireless Headphones",
    "description": "Premium noise-cancelling headphones",
    "price": 299.99,
    "sale_price": 249.99,
    "quantity": 50,
    "visibility": "published"
  }'
```

**Get a specific product:**
```bash
curl http://localhost:8000/api/products/1
```

**Delete a product:**
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

## Google Cloud Run Deployment

### Build and Deploy

1. **Set up Google Cloud Project**
   ```bash
   # Configure gcloud CLI
   gcloud auth login
   gcloud config set project YOUR_PROJECT_ID
   ```

2. **Build Docker Image**
   ```bash
   docker build -t gcr.io/YOUR_PROJECT_ID/jussilog-backend .
   ```

3. **Push to Container Registry**
   ```bash
   docker push gcr.io/YOUR_PROJECT_ID/jussilog-backend
   ```

4. **Deploy to Cloud Run**
   ```bash
   gcloud run deploy jussilog-backend \
     --image gcr.io/YOUR_PROJECT_ID/jussilog-backend \
     --platform managed \
     --region us-central1 \
     --allow-unauthenticated \
     --set-env-vars "APP_KEY=base64:YOUR_APP_KEY,APP_ENV=production,APP_DEBUG=false,DB_CONNECTION=sqlite"
   ```

5. **Test Deployment**
   ```bash
   # Cloud Run will provide a URL
   curl https://jussilog-backend-XXXXX-uc.a.run.app/api/hello
   ```

### Important Notes for Cloud Run

- **Ephemeral Storage**: SQLite database resets on each deployment. For production with persistent data, use Cloud SQL (MySQL/PostgreSQL).
- **Environment Variables**: Set `APP_KEY`, `APP_ENV=production`, and `APP_DEBUG=false` via Cloud Run console or CLI.
- **Logging**: Application logs are sent to stdout/stderr and available in Cloud Logging.
- **Port**: Cloud Run automatically injects the `PORT` environment variable; the entrypoint script handles this.

## Docker Files Overview

- **`Dockerfile`**: Multi-stage build with Node.js for frontend assets and PHP-FPM + Nginx
- **`docker-compose.yml`**: Local development environment with volume persistence
- **`.dockerignore`**: Optimizes build context by excluding unnecessary files
- **`docker/nginx.conf`**: Laravel-optimized Nginx configuration
- **`docker/entrypoint.sh`**: Container startup script that handles migrations, caching, and dynamic port configuration

## Database

The application uses SQLite by default for simplicity and easy deployment. The database schema includes:

- **Users**: User authentication and management
- **Products**: Main product catalog with fields:
  - `title`: Product name
  - `description`: Product description
  - `price`: Regular price
  - `sale_price`: Discounted price (optional)
  - `quantity`: Stock quantity
  - `featured_image`: Main product image URL
  - `images`: Additional images (JSON array)
  - `visibility`: Product status (published/draft)

### Switching to MySQL/PostgreSQL

For production deployments with Cloud SQL:

1. Update `docker-compose.yml` or Cloud Run environment variables:
   ```yaml
   DB_CONNECTION: mysql
   DB_HOST: your-cloudsql-instance
   DB_PORT: 3306
   DB_DATABASE: jussilog
   DB_USERNAME: your-username
   DB_PASSWORD: your-password
   ```

2. For Cloud SQL, use Unix socket connection in Cloud Run.

## Development

### Running Tests

```bash
# With Docker
docker-compose exec app php artisan test

# Without Docker
php artisan test
```

### Database Migrations

```bash
# Create new migration
php artisan make:migration create_your_table

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback
```

### Code Style

```bash
# Format code with Laravel Pint
./vendor/bin/pint
```

## Troubleshooting

### Permission Issues in Docker

If you encounter permission errors:
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Database Not Found

Ensure the SQLite database file exists:
```bash
docker-compose exec app touch database/database.sqlite
docker-compose exec app php artisan migrate
```

### Port Already in Use

Change the host port in `docker-compose.yml`:
```yaml
ports:
  - "8001:8080"  # Change 8000 to 8001 or any available port
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Powered By

<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
</a>
</p>
