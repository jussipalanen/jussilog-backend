# Jussilog - Laravel backend

**The Product Catalog powered by the Laravel Framework**

Jussilog is a modern product catalog API built with Laravel 10, designed for easy deployment on Google Cloud Run with Docker support. It provides a RESTful API for managing products with features like inventory tracking, pricing, images, and visibility controls.

## Features

- **Product Management**: Full CRUD operations for products
- **RESTful API**: Clean, intuitive API endpoints
- **MySQL Database**: Production-ready MySQL with Docker support (SQLite also available)
- **Docker Support**: Production-ready Docker configuration with MySQL persistence
- **Cloud Run Ready**: Optimized for Google Cloud Run deployment
- **Laravel Sanctum**: API authentication support
- **Vite Frontend Assets**: Modern frontend build pipeline

## Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Database**: MySQL 8.0 (SQLite alternative for lightweight deployments)
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

2. **Initialize Environment**
   ```bash
   ./dev init
   ```

3. **Build and Start the Container**
   ```bash
   ./dev up
   ```

4. **Access the Application**
   - API: http://localhost:8000
   - Health Check: http://localhost:8000/api/hello

### Dev Script Commands

Common commands are available via the dev script:

```bash
./dev up
./dev down
./dev restart
./dev status
./dev logs
./dev shell
./dev artisan --version
./dev composer --version
./dev npm --version
```

### Docker Cache Refresh (Manual)

If route or config changes do not appear immediately, clear Laravel caches manually:

```bash
./dev artisan optimize:clear
```

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

## File Uploads (Local vs GCS)

Product images and the upload test endpoint use the default filesystem disk (`FILESYSTEM_DISK`).

### Local (Filesystem) Uploads

Set the disk to `public` and ensure the storage symlink exists:

```bash
FILESYSTEM_DISK=public
```

```bash
php artisan storage:link
```

Files are stored under `storage/app/public`, and URLs resolve under `/storage/...`.

### Google Cloud Storage (GCS)

Set the disk to `gcs` and provide HMAC keys for the bucket:

```bash
FILESYSTEM_DISK=gcs
GCS_ACCESS_KEY_ID=your-hmac-access-id
GCS_SECRET_ACCESS_KEY=your-hmac-secret
GCS_BUCKET=your-bucket-name
GCS_ENDPOINT=https://storage.googleapis.com
GCS_USE_PATH_STYLE_ENDPOINT=false
```

Signed URLs are returned for product images and the upload test endpoint. The default expiry time is 1 hour.

If you decide to make the bucket public, the links will still work, but signed URLs are still returned by the API.

## API Endpoints

### API Documentation (Swagger UI)

After generating the docs, open:

- `http://localhost:8000/api/docs`

Generate or refresh docs:

```bash
php artisan scribe:generate
```

Re-run the command whenever you add or change API routes to keep the Swagger docs up to date.

### Public Endpoints

- `GET /api/hello` - Health check endpoint
- `POST /api/upload-test` - Upload a single image (`file`) to the configured disk
- `GET /api/products` - List all products (supports `page` and `per_page`)
- `GET /api/products/{id}` - Get single product
- `POST /api/products` - Create new product
- `DELETE /api/products/{id}` - Delete product
- `GET /api/users/roles` - Get all available roles
- `GET /api/users` - List all users with roles
- `GET /api/users/{id}` - Get single user with roles

### Protected Endpoints (Sanctum Authentication)

- `GET /api/user` - Get authenticated user with roles
- `GET /api/me` - Get authenticated user with metadata and roles

### Example API Usage

**List all products:**
```bash
curl http://localhost:8000/api/products
```

**List products with pagination:**
```bash
curl "http://localhost:8000/api/products?page=2&per_page=25"
```

**Paginated response example:**
```json
{
   "data": [
      {
         "id": 26,
         "title": "Wireless Headphones",
         "description": "Premium noise-cancelling headphones",
         "price": "299.99",
         "sale_price": null,
         "quantity": 50,
         "featured_image": null,
         "images": [],
         "visibility": true,
         "created_at": "2026-03-05T10:15:30.000000Z",
         "updated_at": "2026-03-05T10:15:30.000000Z"
      }
   ],
   "current_page": 2,
   "from": 26,
   "last_page": 4,
   "last_page_url": "http://localhost:8000/api/products?page=4",
   "links": [
      {
         "url": "http://localhost:8000/api/products?page=1",
         "label": "Previous",
         "active": false
      },
      {
         "url": "http://localhost:8000/api/products?page=2",
         "label": "2",
         "active": true
      },
      {
         "url": "http://localhost:8000/api/products?page=3",
         "label": "Next",
         "active": false
      }
   ],
   "next_page_url": "http://localhost:8000/api/products?page=3",
   "path": "http://localhost:8000/api/products",
   "per_page": 25,
   "prev_page_url": "http://localhost:8000/api/products?page=1",
   "to": 50,
   "total": 100
}
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

**Get all available roles:**
```bash
curl http://localhost:8000/api/users/roles
```

**Role response example:**
```json
[
  {
    "id": 1,
    "key": "admin",
    "label": "Admin"
  },
  {
    "id": 2,
    "key": "customer",
    "label": "Customer"
  },
  {
    "id": 3,
    "key": "vendor",
    "label": "Vendor"
  }
]
```

**List all users:**
```bash
curl http://localhost:8000/api/users
```

**Get a specific user:**
```bash
curl http://localhost:8000/api/users/1
```

**User response example:**
```json
{
  "id": 1,
  "first_name": "Ada",
  "last_name": "Lovelace",
  "username": "ada.lovelace",
  "name": "Ada Lovelace",
  "email": "ada@example.com",
  "roles": ["admin", "vendor"]
}
```

## User CLI Commands

The app includes Artisan commands for creating, updating, and deleting users.
Valid roles are:
- Customer (key: `customer`)
- Vendor (key: `vendor`)
- Admin (key: `admin`)

New users default to `customer` when created via factories/seeders.

### Create a user

```bash
php artisan user:create \
   --first-name="Ada" \
   --last-name="Lovelace" \
   --username="ada.lovelace" \
   --name="Ada Lovelace" \
   --email=ada@example.com \
   --password=secret \
   --role=admin
```

You can also run the command without flags to use interactive prompts:

```bash
php artisan user:create
```

### Update a user

Update by id or email. Use `--new-email` when changing the user's email.

```bash
php artisan user:update --id=12 --name="Ada L." --role=vendor
php artisan user:update --email=ada@example.com --new-email=ada.new@example.com
```

### Delete a user

```bash
php artisan user:delete --email=ada@example.com
```

### List users

```bash
php artisan user:list
```

### Manual User Management on Cloud Run (gcloud)

Use Cloud Run Jobs to run Artisan commands in production without SSH access.

1. Set your variables:

```bash
export PROJECT_ID="client-jussimatic"
export REGION="europe-north1"
export IMAGE="europe-north1-docker.pkg.dev/${PROJECT_ID}/jussilog-backend/jussilog-backend:latest"
```

2. Create one-time jobs:

```bash
gcloud run jobs create user-create-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --image "$IMAGE" \
   --command php \
   --args artisan,user:create,--first-name=Admin,--last-name=User,--username=admin,--name=Admin\ User,--email=admin@example.com,--password=ChangeMe123!,--role=admin

gcloud run jobs create user-update-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --image "$IMAGE" \
   --command php \
   --args artisan,user:update,--email=admin@example.com,--role=admin

# If you use SQLite on Cloud Run, set these env vars on the jobs
gcloud run jobs update user-create-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --set-env-vars "DB_CONNECTION=sqlite,DB_DATABASE=/var/www/html/database/database.sqlite"

gcloud run jobs update user-update-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --set-env-vars "DB_CONNECTION=sqlite,DB_DATABASE=/var/www/html/database/database.sqlite"
```

3. Execute the jobs:

```bash
gcloud run jobs execute user-create-job --project "$PROJECT_ID" --region "$REGION" --wait
gcloud run jobs execute user-update-job --project "$PROJECT_ID" --region "$REGION" --wait
```

4. Update a job command when needed:

```bash
gcloud run jobs update user-update-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --command php \
   --args artisan,user:update,--id=1,--role=vendor
```

Optional: add local shell functions to make manual user operations faster:

```bash
create_admin_user() {
   gcloud run jobs update user-create-job \
      --project "$PROJECT_ID" \
      --region "$REGION" \
      --command php \
      --args "artisan,user:create,--first-name=$1,--last-name=$2,--username=$3,--name=$1\ $2,--email=$4,--password=$5,--role=admin" && \
   gcloud run jobs execute user-create-job --project "$PROJECT_ID" --region "$REGION" --wait
}

update_user_role() {
   gcloud run jobs update user-update-job \
      --project "$PROJECT_ID" \
      --region "$REGION" \
      --command php \
      --args "artisan,user:update,--email=$1,--role=$2" && \
   gcloud run jobs execute user-update-job --project "$PROJECT_ID" --region "$REGION" --wait
}
```

Examples:

```bash
create_admin_user "Admin" "User" "admin" "admin@example.com" "StrongPass123!"
update_user_role "admin@example.com" "vendor"
```

Security note:

- Avoid passing real passwords directly in shell history or CI logs.
- Prefer generating a temporary strong password and rotating it immediately after first login.
- For production automation, store sensitive values in Google Secret Manager and inject them at runtime.

Create the secret once (interactive prompt):

```bash
printf '%s' 'StrongPass123!' | gcloud secrets create ADMIN_USER_PASSWORD \
   --project "$PROJECT_ID" \
   --replication-policy=automatic \
   --data-file=-
```

If the secret already exists, add a new rotated version:

```bash
printf '%s' 'NewRotatedPass456!' | gcloud secrets versions add ADMIN_USER_PASSWORD \
   --project "$PROJECT_ID" \
   --data-file=-
```

Grant Secret Manager access to the Cloud Run Job service account:

```bash
export JOB_SA="jussilog-job-runner@${PROJECT_ID}.iam.gserviceaccount.com"

# Create service account if missing
gcloud iam service-accounts create jussilog-job-runner \
   --project "$PROJECT_ID" \
   --display-name "Jussilog Cloud Run Job Runner"

# Let the service account access the admin password secret
gcloud secrets add-iam-policy-binding ADMIN_USER_PASSWORD \
   --project "$PROJECT_ID" \
   --member "serviceAccount:${JOB_SA}" \
   --role "roles/secretmanager.secretAccessor"

# Use this service account for jobs
gcloud run jobs update user-create-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --service-account "$JOB_SA"

gcloud run jobs update user-update-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --service-account "$JOB_SA"
```

Example (read password from Secret Manager and update the job args):

```bash
ADMIN_PASSWORD="$(gcloud secrets versions access latest --secret=ADMIN_USER_PASSWORD --project "$PROJECT_ID")"

gcloud run jobs update user-create-job \
   --project "$PROJECT_ID" \
   --region "$REGION" \
   --command php \
   --args "artisan,user:create,--first-name=Admin,--last-name=User,--username=admin,--name=Admin\ User,--email=admin@example.com,--password=${ADMIN_PASSWORD},--role=admin"
```

## Google Cloud Run Deployment

### Build and Deploy

1. **Set up Google Cloud Project**
   ```bash
   # Configure gcloud CLI
   gcloud auth login
   gcloud config set project client-jussimatic
   ```

   Remember to authenticate and select the `client-jussimatic` project before running the deployment steps.

2. **Build Docker Image**
   ```bash
   docker build -t europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest .
   ```

3. **Push to Container Registry**
   ```bash
   docker push europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest
   ```

4. **Deploy to Cloud Run**
   ```bash
    gcloud run deploy jussilog-backend \
       --image europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest \
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
- **Startup Work**: The production container now skips migrations and Laravel cache warming at startup by default to reduce cold-start time and instance CPU usage.
- **Optional Startup Flags**: Set `RUN_MIGRATIONS_AT_STARTUP=true`, `WARM_LARAVEL_CACHE_AT_STARTUP=true`, or `FIX_PERMISSIONS_AT_STARTUP=true` only when you explicitly need that behavior.

## Docker Files Overview

- **`Dockerfile`**: Production-focused multi-stage build for the Laravel API with Composer, PHP-FPM, Nginx, and OPCache
- **`docker-compose.yml`**: Local development environment with volume persistence
- **`.dockerignore`**: Optimizes build context by excluding unnecessary files
- **`docker/nginx.conf`**: Laravel-optimized Nginx configuration
- **`docker/entrypoint.sh`**: Container startup script that handles dynamic port configuration and optional startup tasks

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

### Database Configuration

#### Using MySQL with Docker (Local Development)

The default `docker-compose.yml` includes a MySQL 8.0 service with persistent storage. To use MySQL:

1. **Copy and configure environment file:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   The `.env.example` already includes MySQL defaults:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql          # Docker service name
   DB_PORT=3306
   DB_DATABASE=jussilog
   DB_USERNAME=jussilog
   DB_PASSWORD=jussilog
   MYSQL_ROOT_PASSWORD=rootpassword
   ```

2. **Start services:**
   ```bash
   ./dev up
   ```
   
   The entrypoint script will:
   - Wait for MySQL to be ready
   - Create the database if needed
   - Run migrations automatically

3. **Access MySQL directly (optional):**
   ```bash
   # Via Docker container
   docker-compose exec mysql mysql -u jussilog -pjussilog jussilog
   
   # From host machine (port 3306 is exposed)
   mysql -h 127.0.0.1 -P 3306 -u jussilog -pjussilog jussilog
   ```

#### Using SQLite (Alternative)

For lightweight development or demo deployments:

1. **Update `.env`:**
   ```env
   DB_CONNECTION=sqlite
   ```

2. **Create database file:**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

#### Production Database (Cloud SQL)

For production deployments with Cloud SQL:

1. Update Cloud Run environment variables:
   ```yaml
   DB_CONNECTION: mysql
   DB_HOST: your-cloudsql-instance  # Or Unix socket path
   DB_PORT: 3306
   DB_DATABASE: jussilog
   DB_USERNAME: your-username
   DB_PASSWORD: your-password
   ```

2. For Cloud SQL, configure Unix socket connection in Cloud Run for better performance and security.

#### Test Production Cloud SQL Connection Locally

Use Cloud SQL Auth Proxy and the production-style socket settings to validate connectivity before deployment.

1. Start Cloud SQL Auth Proxy:
   ```bash
   sudo mkdir -p /cloudsql
   sudo chown "$USER":"$USER" /cloudsql
   cloud-sql-proxy --unix-socket /cloudsql client-jussimatic:europe-north1:jussilog-db
   ```

2. Update local `.env` database values:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_SOCKET=/cloudsql/client-jussimatic:europe-north1:jussilog-db
   DB_PORT=3306
   DB_DATABASE=jussilog
   DB_USERNAME=jussilog
   DB_PASSWORD=YOUR_DB_PASSWORD
   ```

3. Verify Laravel can connect:
   ```bash
   php artisan tinker
   ```
   Then run:
   ```php
   DB::connection()->getPdo();
   ```

4. Create missing tables if needed:
   ```bash
   php artisan migrate --force
   ```

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
