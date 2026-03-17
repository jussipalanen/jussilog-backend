# Jussilog - Laravel Backend Service

**Full-stack API backend powered by the Laravel Framework**

Jussilog is a modern multi-feature API built with Laravel 10, designed for easy deployment on Google Cloud Run with Docker support. It provides a RESTful API covering product catalog management, order handling, resume building with PDF/HTML export, blog publishing, visitor tracking, and full user authentication.

## Features

- **Product Management**: Full CRUD operations for products with inventory tracking, pricing, images, and visibility controls
- **Order Management**: Full CRUD for orders and order items, with authenticated user order history
- **Invoice Management**: Full CRUD for invoices and invoice items, auto-generated from orders with sequential invoice numbers (`INV-YYYY-NNNNN`), status lifecycle (draft → issued → paid → cancelled), PDF/HTML export, and customer-scoped access control
- **Resume Builder**: Full CRUD for resumes with section management (work experience, education, skills, projects, certifications, languages, awards, recommendations)
- **Resume Photo Upload**: Upload and store a professional photo per resume, with automatic thumbnail generation (thumb 80×80, small 200×200, medium 400×400)
- **Resume Export**: Export resumes as PDF or HTML with theme and template selection, Finnish/English language support
- **User Authentication**: Register, login, logout, and session check via Laravel Sanctum
- **Google OAuth**: Sign in with Google via token-based authentication
- **Password Reset**: Lost password and reset password flows with email notification
- **User Management**: CRUD for users with role assignment (admin, vendor, customer)
- **Visitor Tracking**: Track and query daily and total visitor counts
- **Blog**: Full CRUD for blog posts with categories, tags, featured image, excerpt, visibility toggle, and author tracking. Public read access, admin-only write access
- **Admin Thumbnail Management**: Admin endpoints to regenerate or purge product and resume photo thumbnails
- **RESTful API**: Clean, intuitive API endpoints
- **MySQL Database**: Production-ready MySQL with Docker support (SQLite also available)
- **Docker Support**: Production-ready Docker configuration (PHP-FPM + Nginx, no Node.js build stage) with MySQL persistence
- **Cloud Run Ready**: Optimized for Google Cloud Run deployment with warmup endpoint and Cloud Scheduler keep-warm job

## Tech Stack

- **Backend**: Laravel 10 (PHP 8.2+)
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
./dev generate-postman     # Regenerate postman/collection.json from live routes
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
- `POST /api/register` - Register a new user account
- `POST /api/login` - Log in and receive a Sanctum token
- `POST /api/auth/google` - Sign in with a Google ID token
- `POST /api/lost-password` - Request a password reset email
- `POST /api/reset-password` - Reset password using a token from email
- `GET /api/products` - List all products (supports `page` and `per_page`)
- `GET /api/products/{id}` - Get single product
- `POST /api/products` - Create new product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete product
- `GET /api/orders` - List all orders
- `POST /api/orders` - Create a new order
- `GET /api/orders/{id}` - Get single order
- `PUT /api/orders/{id}` - Update an order
- `DELETE /api/orders/{id}` - Delete an order
- `GET /api/users/roles` - Get all available roles
- `GET /api/users` - List all users with roles
- `GET /api/users/{id}` - Get single user with roles
- `PATCH /api/users/update-role` - Update a user's role
- `POST /api/visitors/track` - Track a visitor
- `GET /api/visitors/today` - Get today's visitor count
- `GET /api/visitors/total` - Get total visitor count
- `GET /api/resumes/export/options` - Get available export themes, templates, and languages
- `POST /api/resumes/export/pdf` - Export a resume as PDF from JSON payload (no auth required)
- `POST /api/resumes/export/html` - Export a resume as HTML from JSON payload (no auth required)

### Resume Export Endpoints (Sanctum Authentication)

- `GET /api/resumes/{id}/export/pdf` - Download resume as a PDF file
- `GET /api/resumes/{id}/export/html` - Download resume as an HTML file

Accepted query parameters:

| Parameter  | Values | Default |
|------------|--------|---------|
| `lang`     | `en`, `fi` | Resume's language setting, fallback `en` |
| `theme`    | `green`, `blue`, `red`, `yellow`, `cyan`, `orange`, `violet`, `black`, `white`, `grey` | Resume's theme setting, fallback `green` |
| `template` | `default` | Resume's template setting, fallback `default` |

**Download resume as PDF:**
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/resumes/1/export/pdf" \
  --output resume.pdf
```

**Download resume as HTML:**
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/resumes/1/export/html" \
  --output resume.html
```

**With explicit language and theme:**
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/resumes/1/export/pdf?lang=fi&theme=blue" \
  --output resume.pdf
```

### Public Resume Export Endpoints (no authentication)

Export a resume directly from a JSON payload — nothing is stored in the database. Ideal for live previews and client-side resume builders.

- `POST /api/resumes/export/pdf` - Export a resume as a downloadable PDF
- `POST /api/resumes/export/html` - Export a resume as a downloadable HTML file

#### Request body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `full_name` | string | yes | Full name |
| `email` | string | yes | Email address |
| `phone` | string | no | Phone number |
| `location` | string | no | Location (city / country) |
| `linkedin_url` | string | no | LinkedIn profile URL |
| `portfolio_url` | string | no | Portfolio / website URL |
| `github_url` | string | no | GitHub profile URL |
| `title` | string | no | Resume label / role title |
| `summary` | string | no | Professional summary paragraph |
| `language` | `en` \| `fi` | no | Output language (default: `en`) |
| `theme` | see options | no | Colour theme (default: `green`) |
| `template` | `default` | no | Layout template (default: `default`) |
| `photo` | string | no | Professional photo as a base64 string (JPEG / PNG / GIF / WebP, max ~5 MB). A `data:image/…;base64,` prefix is accepted but not required. |
| `work_experiences` | array | no | Work experience entries (see section fields below) |
| `educations` | array | no | Education entries |
| `skills` | array | no | Skill entries |
| `projects` | array | no | Project entries |
| `certifications` | array | no | Certification entries |
| `languages` | array | no | Language entries |
| `awards` | array | no | Award entries |
| `recommendations` | array | no | Recommendation entries |

#### Section field reference

**`work_experiences[]`**

| Field | Type | Required |
|-------|------|----------|
| `job_title` | string | yes |
| `company_name` | string | yes |
| `location` | string | no |
| `start_date` | date | yes |
| `end_date` | date | no |
| `is_current` | boolean | no |
| `description` | string | no |
| `sort_order` | integer | no |

**`educations[]`**

| Field | Type | Required |
|-------|------|----------|
| `degree` | string | yes |
| `field_of_study` | string | yes |
| `institution_name` | string | yes |
| `location` | string | no |
| `graduation_year` | integer | no |
| `gpa` | number | no |
| `sort_order` | integer | no |

**`skills[]`** — `category`, `name` (required), `proficiency` (`beginner`/`basic`/`intermediate`/`advanced`/`expert`, required), `sort_order`

**`projects[]`** — `name` (required), `description`, `technologies[]`, `live_url`, `github_url`, `sort_order`

**`certifications[]`** — `name`, `issuing_organization` (required), `issue_date`, `sort_order`

**`languages[]`** — `language` (required), `proficiency` (`native`/`fluent`/`conversational`/`basic`, required), `sort_order`

**`awards[]`** — `title` (required), `issuer`, `date`, `description`, `sort_order`

**`recommendations[]`** — `full_name` (required), `title`, `company`, `email`, `phone`, `recommendation`, `sort_order`

#### Example request

```bash
curl -X POST http://localhost:8000/api/resumes/export/pdf \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Ada Lovelace",
    "email": "ada@example.com",
    "phone": "+358401234567",
    "location": "Helsinki, Finland",
    "title": "Software Engineer",
    "theme": "blue",
    "language": "en",
    "photo_base64": "<base64-encoded image>",
    "work_experiences": [
      {
        "job_title": "Senior Engineer",
        "company_name": "Acme Corp",
        "start_date": "2020-01-01",
        "is_current": true
      }
    ],
    "skills": [
      { "category": "Backend", "name": "PHP", "proficiency": "expert" }
    ]
  }' \
  --output ada-lovelace-resume.pdf
```

### Protected Endpoints (Sanctum Authentication)

- `GET /api/user` - Get authenticated user with roles
- `GET /api/me` - Get authenticated user with metadata and roles
- `POST /api/logout` - Log out and revoke the current token
- `GET /api/check-auth` - Check if the current token is valid
- `GET /api/my-orders` - Get orders belonging to the authenticated user
- `POST /api/users` - Create a new user
- `PUT /api/users/{id}` - Update a user
- `DELETE /api/users/{id}` - Delete a user
- `GET /api/resumes` - List all resumes for the authenticated user
- `POST /api/resumes` - Create a new resume
- `GET /api/resumes/{id}` - Get a resume with all sections
- `PUT /api/resumes/{id}` - Update resume details
- `DELETE /api/resumes/{id}` - Delete a resume
- `GET /api/resumes/{id}/export/pdf` - Download resume as PDF
- `GET /api/resumes/{id}/export/html` - Download resume as HTML
- `GET /api/resumes/{resumeId}/{section}` - List items for a resume section
- `POST /api/resumes/{resumeId}/{section}` - Add an item to a resume section
- `PUT /api/resumes/{resumeId}/{section}/{itemId}` - Update a resume section item
- `DELETE /api/resumes/{resumeId}/{section}/{itemId}` - Delete a resume section item

Valid `{section}` values: `work-experiences`, `educations`, `skills`, `projects`, `certifications`, `languages`, `awards`, `recommendations`

### Invoice Endpoints

**Public (no authentication)**

- `POST /api/invoices/export/pdf` - Export an invoice as a downloadable PDF from a JSON payload (no database save)
- `POST /api/invoices/export/html` - Export an invoice as a downloadable HTML file from a JSON payload (no database save)

**Protected (Sanctum Authentication)**

Customers can only read their own invoices. Create, update, and delete require admin or vendor role.

- `GET /api/invoices` - List invoices (paginated; filterable by `order_id`, `user_id`, `status`; sortable)
- `GET /api/invoices/{id}` - Get a single invoice with items, order, and user
- `GET /api/invoices/{id}/pdf` - Download the invoice as a PDF file
- `POST /api/invoices` - Create an invoice from an order (auto-generates items from order lines) *(admin, vendor)*
- `PUT /api/invoices/{id}` - Update invoice fields and sync items *(admin, vendor)*
- `DELETE /api/invoices/{id}` - Delete an invoice *(admin, vendor)*

**Invoice statuses:** `draft`, `issued`, `paid`, `cancelled`

**Invoice item types:** `product`, `shipping`, `discount`, `adjustment`

### Blog Endpoints

**Public (no authentication)**

- `GET /api/blogs` - List published blog posts (`visibility=true`), paginated. Supports `per_page`, `sort_by` (`id`, `title`, `created_at`), `sort_dir`
- `GET /api/blogs/{id}` - Get a single published blog post with author and category
- `GET /api/blog-categories` - List all blog categories

**Admin only (Sanctum Authentication + Admin Role)**

- `GET /api/admin/blogs` - List all blog posts including hidden drafts, paginated. Supports same query params plus `visibility` as sort field
- `POST /api/blogs` - Create a blog post
- `PUT /api/blogs/{id}` - Update a blog post (send only fields to change)
- `DELETE /api/blogs/{id}` - Delete a blog post
- `POST /api/blog-categories` - Create a category (slug auto-generated from name)
- `PUT /api/blog-categories/{id}` - Update a category
- `DELETE /api/blog-categories/{id}` - Delete a category (linked blogs have category set to null)

**Blog post fields:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `title` | string | yes | Post title (max 255) |
| `excerpt` | string | no | Short description shown in listings |
| `content` | string | yes | Full post content (HTML supported) |
| `blog_category_id` | integer | no | ID of an existing category |
| `feature_image` | string | no | URL or path to the featured image |
| `tags` | array of strings | no | e.g. `["laravel", "php"]` |
| `visibility` | boolean | no | `true` = published, `false` = draft (default) |

**Example — create a blog post:**
```bash
curl -X POST http://localhost:8000/api/blogs \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Getting started with Laravel",
    "excerpt": "A short intro to building APIs with Laravel.",
    "content": "<p>Laravel makes building APIs enjoyable...</p>",
    "blog_category_id": 1,
    "tags": ["laravel", "php", "api"],
    "visibility": true
  }'
```

**Example — publish / unpublish (toggle only):**
```bash
curl -X PUT http://localhost:8000/api/blogs/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"visibility": true}'
```

### Admin Endpoints (Sanctum Authentication + Admin Role)

- `POST /api/admin/thumbnails/regenerate` - Regenerate all thumbnails across all records
- `DELETE /api/admin/thumbnails` - Purge all thumbnails across all records
- `POST /api/admin/thumbnails/products/{id}/regenerate` - Regenerate thumbnails for a product
- `DELETE /api/admin/thumbnails/products/{id}` - Purge thumbnails for a product
- `POST /api/admin/thumbnails/resumes/{id}/regenerate` - Regenerate photo thumbnails for a resume
- `DELETE /api/admin/thumbnails/resumes/{id}` - Purge photo thumbnails for a resume

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

- **`Dockerfile`**: Single-stage build with PHP-FPM + Nginx (API-only, no Node.js build step)
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
