# Jussilog — Laravel Backend

**RESTful API backend powered by Laravel 10, deployed on Google Cloud Run.**

Covers product catalog, orders, invoices, resume building with PDF/HTML export, blog publishing, visitor tracking, file uploads to GCS, and full user authentication with Google OAuth.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 10 (PHP 8.2+) |
| Database | MySQL 8.0 · SQLite (lightweight alternative) |
| Web server | Nginx + PHP-FPM |
| Auth | Laravel Sanctum + Google OAuth |
| Storage | Google Cloud Storage (GCS) · local filesystem |
| Containerization | Docker & Docker Compose |
| Infrastructure | Google Cloud Run · Cloud SQL · Terraform |

---

## Quick Start

**Requirements:** Docker, Docker Compose, Git

```bash
git clone https://github.com/jussipalanen/jussilog-backend.git
cd jussilog-backend
./dev init   # copy .env, generate APP_KEY, run migrations
./dev up     # build and start containers
```

- API: http://localhost:8000
- Health check: http://localhost:8000/api/hello
- Swagger UI: http://localhost:8000/api/docs

---

## Dev Script Reference

All common tasks run through `./dev <command>`:

| Command | Description |
|---|---|
| `up` | Build and start containers |
| `down` | Stop and remove containers |
| `restart` | Down then up |
| `status` | Show container status |
| `logs` | Tail container logs |
| `shell` | Open shell in app container |
| `init` | Copy `.env`, generate key, run migrations |
| `artisan [args]` | Run `php artisan` inside the container |
| `composer [args]` | Run `composer` inside the container |
| `npm [args]` | Run `npm` inside the container |
| `generate-postman` | Regenerate `postman/collection.json` from live routes |
| `db-export [--local\|--cloud] [file]` | Export database to `.sql` |
| `db-import [--local\|--cloud] <file>` | Import `.sql` into local or Cloud SQL |
| `secrets-update [KEY [VALUE]]` | Push secrets to GCP Secret Manager |
| `env-update` | Push `.env.production` vars to Cloud Run (no rebuild) |
| `env-get` | Fetch live env vars from Cloud Run |
| `migrate-cloud` | Run migrations against Cloud SQL via proxy |
| `tf-init` | Initialize Terraform (run once) |
| `tf-plan` | Preview infrastructure changes |
| `tf-apply` | Apply infrastructure changes |
| `tf-import` | Import existing GCP resources into Terraform state |
| `tf-output` | Show deployed URLs, connection names, service account |

---

<details>
<summary><strong>Features</strong></summary>

- **Product Management** — Full CRUD with inventory tracking, pricing, images, and visibility controls
- **Order Management** — Full CRUD for orders and order items, with authenticated user order history
- **Invoice Management** — Full CRUD, auto-generated from orders with sequential invoice numbers (`INV-YYYY-NNNNN`), status lifecycle (draft → issued → paid → cancelled), PDF/HTML export, customer-scoped access
- **Resume Builder** — Full CRUD with section management (work experience, education, skills, projects, certifications, languages, awards, recommendations)
- **Resume Photo Upload** — Upload and store a professional photo per resume, with automatic thumbnail generation (thumb 80×80, small 200×200, medium 400×400)
- **Resume Export** — PDF or HTML with theme and template selection, Finnish/English language support
- **User Authentication** — Register, login, logout, session check via Laravel Sanctum
- **Google OAuth** — Sign in with Google via token-based authentication
- **Password Reset** — Lost password and reset flows with email notification
- **User Management** — CRUD for users with role assignment (admin, vendor, customer)
- **Visitor Tracking** — Track and query daily and total visitor counts
- **Blog** — Full CRUD for blog posts with categories, tags, featured image, excerpt, visibility toggle, and author tracking. Public read, admin-only write
- **Admin Thumbnail Management** — Regenerate or purge product and resume photo thumbnails
- **Cloud Run Ready** — Warmup endpoint and Cloud Scheduler keep-warm job to avoid cold starts

</details>

---

<details>
<summary><strong>API Reference</strong></summary>

### Swagger UI

Generate or refresh docs:

```bash
php artisan scribe:generate
# then open: http://localhost:8000/api/docs
```

---

### Public endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/hello` | Health check |
| `POST` | `/api/register` | Register user |
| `POST` | `/api/login` | Login, returns Sanctum token |
| `POST` | `/api/auth/google` | Sign in with Google ID token |
| `POST` | `/api/lost-password` | Request password reset email |
| `POST` | `/api/reset-password` | Reset password with token |
| `GET` | `/api/products` | List products (supports `page`, `per_page`) |
| `GET` | `/api/products/{id}` | Get product |
| `POST` | `/api/products` | Create product |
| `PUT` | `/api/products/{id}` | Update product |
| `DELETE` | `/api/products/{id}` | Delete product |
| `GET` | `/api/orders` | List orders |
| `POST` | `/api/orders` | Create order |
| `GET` | `/api/orders/{id}` | Get order |
| `PUT` | `/api/orders/{id}` | Update order |
| `DELETE` | `/api/orders/{id}` | Delete order |
| `GET` | `/api/users/roles` | List roles |
| `GET` | `/api/users` | List users with roles |
| `GET` | `/api/users/{id}` | Get user with roles |
| `PATCH` | `/api/users/update-role` | Update user role |
| `POST` | `/api/visitors/track` | Track a visitor |
| `GET` | `/api/visitors/today` | Today's visitor count |
| `GET` | `/api/visitors/total` | Total visitor count |
| `GET` | `/api/blogs` | List published posts (paginated, `per_page`, `sort_by`, `sort_dir`) |
| `GET` | `/api/blogs/{id}` | Get published post with author and category |
| `GET` | `/api/blog-categories` | List blog categories |
| `GET` | `/api/resumes/export/options` | Available themes, templates, languages |
| `POST` | `/api/resumes/export/pdf` | Export resume PDF from JSON payload (no auth) |
| `POST` | `/api/resumes/export/html` | Export resume HTML from JSON payload (no auth) |
| `POST` | `/api/invoices/export/pdf` | Export invoice PDF from JSON payload (no auth) |
| `POST` | `/api/invoices/export/html` | Export invoice HTML from JSON payload (no auth) |
| `POST` | `/api/upload-test` | Upload image to configured disk |

---

### Protected endpoints (Sanctum token required)

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/user` | Authenticated user with roles |
| `GET` | `/api/me` | Authenticated user with metadata |
| `POST` | `/api/logout` | Revoke current token |
| `GET` | `/api/check-auth` | Validate token |
| `GET` | `/api/my-orders` | Orders for authenticated user |
| `POST` | `/api/users` | Create user |
| `PUT` | `/api/users/{id}` | Update user |
| `DELETE` | `/api/users/{id}` | Delete user |
| `GET` | `/api/resumes` | List resumes for authenticated user |
| `POST` | `/api/resumes` | Create resume |
| `GET` | `/api/resumes/{id}` | Get resume with all sections |
| `PUT` | `/api/resumes/{id}` | Update resume |
| `DELETE` | `/api/resumes/{id}` | Delete resume |
| `GET` | `/api/resumes/{id}/export/pdf` | Download resume as PDF |
| `GET` | `/api/resumes/{id}/export/html` | Download resume as HTML |
| `GET` | `/api/resumes/{resumeId}/{section}` | List section items |
| `POST` | `/api/resumes/{resumeId}/{section}` | Add section item |
| `PUT` | `/api/resumes/{resumeId}/{section}/{itemId}` | Update section item |
| `DELETE` | `/api/resumes/{resumeId}/{section}/{itemId}` | Delete section item |
| `GET` | `/api/invoices` | List invoices (filterable by `order_id`, `user_id`, `status`) |
| `GET` | `/api/invoices/{id}` | Get invoice with items, order, user |
| `GET` | `/api/invoices/{id}/pdf` | Download invoice as PDF |
| `POST` | `/api/invoices` | Create invoice from order *(admin, vendor)* |
| `PUT` | `/api/invoices/{id}` | Update invoice *(admin, vendor)* |
| `DELETE` | `/api/invoices/{id}` | Delete invoice *(admin, vendor)* |

Valid `{section}` values: `work-experiences`, `educations`, `skills`, `projects`, `certifications`, `languages`, `awards`, `recommendations`

Invoice statuses: `draft` · `issued` · `paid` · `cancelled`

---

### Admin endpoints (Sanctum + admin role)

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/admin/blogs` | All posts including hidden drafts |
| `POST` | `/api/blogs` | Create blog post |
| `PUT` | `/api/blogs/{id}` | Update blog post |
| `DELETE` | `/api/blogs/{id}` | Delete blog post |
| `POST` | `/api/blog-categories` | Create category |
| `PUT` | `/api/blog-categories/{id}` | Update category |
| `DELETE` | `/api/blog-categories/{id}` | Delete category |
| `POST` | `/api/admin/thumbnails/regenerate` | Regenerate all thumbnails |
| `DELETE` | `/api/admin/thumbnails` | Purge all thumbnails |
| `POST` | `/api/admin/thumbnails/products/{id}/regenerate` | Regenerate product thumbnails |
| `DELETE` | `/api/admin/thumbnails/products/{id}` | Purge product thumbnails |
| `POST` | `/api/admin/thumbnails/resumes/{id}/regenerate` | Regenerate resume photo thumbnails |
| `DELETE` | `/api/admin/thumbnails/resumes/{id}` | Purge resume photo thumbnails |

---

### Resume export query parameters

| Parameter | Values | Default |
|---|---|---|
| `lang` | `en`, `fi` | Resume's language setting, fallback `en` |
| `theme` | `green`, `blue`, `red`, `yellow`, `cyan`, `orange`, `violet`, `black`, `white`, `grey` | Resume's theme setting, fallback `green` |
| `template` | `default`, `dark` | Resume's template setting, fallback `default` |

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/resumes/1/export/pdf?lang=fi&theme=blue" \
  --output resume.pdf
```

---

### Public resume export — request body

Export from a JSON payload without auth. Nothing is stored in the database.

| Field | Type | Required | Description |
|---|---|---|---|
| `full_name` | string | yes | Full name |
| `email` | string | yes | Email address |
| `phone` | string | no | Phone number |
| `location` | string | no | City / country |
| `linkedin_url` | string | no | LinkedIn URL |
| `portfolio_url` | string | no | Portfolio URL |
| `github_url` | string | no | GitHub URL |
| `title` | string | no | Role / resume label |
| `summary` | string | no | Professional summary |
| `language` | `en` \| `fi` | no | Output language (default: `en`) |
| `theme` | see options | no | Colour theme (default: `green`) |
| `template` | `default`, `dark` | no | Layout (default: `default`) |
| `photo` | string | no | Base64 image (JPEG/PNG/GIF/WebP, max ~5 MB) |
| `work_experiences` | array | no | See section fields below |
| `educations` | array | no | |
| `skills` | array | no | |
| `projects` | array | no | |
| `certifications` | array | no | |
| `languages` | array | no | |
| `awards` | array | no | |
| `recommendations` | array | no | |

**Section field reference**

`work_experiences[]` — `job_title`\*, `company_name`\*, `location`, `start_date`\*, `end_date`, `is_current`, `description`, `sort_order`

`educations[]` — `degree`\*, `field_of_study`\*, `institution_name`\*, `location`, `graduation_year`, `gpa`, `sort_order`

`skills[]` — `name`\*, `proficiency`\* (`beginner`/`basic`/`intermediate`/`advanced`/`expert`), `category`, `sort_order`

`projects[]` — `name`\*, `description`, `technologies[]`, `live_url`, `github_url`, `sort_order`

`certifications[]` — `issuing_organization`\*, `name`, `issue_date`, `sort_order`

`languages[]` — `language`\*, `proficiency`\* (`native`/`fluent`/`conversational`/`basic`), `sort_order`

`awards[]` — `title`\*, `issuer`, `date`, `description`, `sort_order`

`recommendations[]` — `full_name`\*, `title`, `company`, `email`, `phone`, `recommendation`, `sort_order`

(\* = required)

```bash
curl -X POST http://localhost:8000/api/resumes/export/pdf \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Ada Lovelace",
    "email": "ada@example.com",
    "location": "Helsinki, Finland",
    "title": "Software Engineer",
    "theme": "blue",
    "language": "en",
    "work_experiences": [
      { "job_title": "Senior Engineer", "company_name": "Acme Corp", "start_date": "2020-01-01", "is_current": true }
    ],
    "skills": [
      { "category": "Backend", "name": "PHP", "proficiency": "expert" }
    ]
  }' --output ada-lovelace-resume.pdf
```

---

### Blog post fields

| Field | Type | Required | Description |
|---|---|---|---|
| `title` | string | yes | Post title (max 255) |
| `excerpt` | string | no | Short description for listings |
| `content` | string | yes | Full content (HTML supported) |
| `blog_category_id` | integer | no | Existing category ID |
| `feature_image` | string | no | URL or path to featured image |
| `tags` | array of strings | no | e.g. `["laravel", "php"]` |
| `visibility` | boolean | no | `true` = published, `false` = draft |

---

### Example API usage

```bash
# List products
curl http://localhost:8000/api/products

# Paginated
curl "http://localhost:8000/api/products?page=2&per_page=25"

# Create product
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{"title":"Headphones","price":299.99,"quantity":50,"visibility":"published"}'

# List users
curl http://localhost:8000/api/users

# Create blog post
curl -X POST http://localhost:8000/api/blogs \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"My Post","content":"<p>Hello</p>","tags":["laravel"],"visibility":true}'
```

</details>

---

<details>
<summary><strong>User Management</strong></summary>

### Artisan commands (local / Docker)

Valid roles: `admin` · `vendor` · `customer`

```bash
# Create
php artisan user:create \
  --first-name="Ada" --last-name="Lovelace" \
  --username="ada.lovelace" --name="Ada Lovelace" \
  --email=ada@example.com --password=secret --role=admin

# Interactive (no flags)
php artisan user:create

# Update (by id or email)
php artisan user:update --id=12 --name="Ada L." --role=vendor
php artisan user:update --email=ada@example.com --new-email=ada.new@example.com

# Delete
php artisan user:delete --email=ada@example.com

# List
php artisan user:list
```

---

### Cloud Run jobs (production)

Use Cloud Run Jobs to run Artisan commands in production without SSH access.

```bash
export PROJECT_ID="client-jussimatic"
export REGION="europe-north1"
export IMAGE="europe-north1-docker.pkg.dev/${PROJECT_ID}/jussilog-backend/jussilog-backend:latest"

# Create reusable jobs
gcloud run jobs create user-create-job \
  --project "$PROJECT_ID" --region "$REGION" --image "$IMAGE" \
  --command php \
  --args artisan,user:create,--first-name=Admin,--last-name=User,--username=admin,--name=Admin\ User,--email=admin@example.com,--password=ChangeMe123!,--role=admin

gcloud run jobs create user-update-job \
  --project "$PROJECT_ID" --region "$REGION" --image "$IMAGE" \
  --command php \
  --args artisan,user:update,--email=admin@example.com,--role=admin

# Execute
gcloud run jobs execute user-create-job --project "$PROJECT_ID" --region "$REGION" --wait
gcloud run jobs execute user-update-job --project "$PROJECT_ID" --region "$REGION" --wait

# Update job args when needed
gcloud run jobs update user-update-job \
  --project "$PROJECT_ID" --region "$REGION" \
  --command php --args artisan,user:update,--id=1,--role=vendor
```

Optional shell helpers:

```bash
create_admin_user() {
  gcloud run jobs update user-create-job \
    --project "$PROJECT_ID" --region "$REGION" --command php \
    --args "artisan,user:create,--first-name=$1,--last-name=$2,--username=$3,--name=$1\ $2,--email=$4,--password=$5,--role=admin" && \
  gcloud run jobs execute user-create-job --project "$PROJECT_ID" --region "$REGION" --wait
}

update_user_role() {
  gcloud run jobs update user-update-job \
    --project "$PROJECT_ID" --region "$REGION" --command php \
    --args "artisan,user:update,--email=$1,--role=$2" && \
  gcloud run jobs execute user-update-job --project "$PROJECT_ID" --region "$REGION" --wait
}

create_admin_user "Ada" "Lovelace" "ada.lovelace" "ada@example.com" "StrongPass123!"
update_user_role "ada@example.com" "vendor"
```

**Security note:** avoid passing passwords in shell history. Store them in Secret Manager and inject at runtime:

```bash
printf '%s' 'StrongPass123!' | gcloud secrets create ADMIN_USER_PASSWORD \
  --project "$PROJECT_ID" --replication-policy=automatic --data-file=-

ADMIN_PASSWORD="$(gcloud secrets versions access latest --secret=ADMIN_USER_PASSWORD --project "$PROJECT_ID")"
```

</details>

---

<details>
<summary><strong>Infrastructure (Terraform)</strong></summary>

All GCP infrastructure is managed as code in `terraform/`. It covers Cloud Run, Cloud SQL, Artifact Registry, GCS, Secret Manager, IAM, and the Cloud Build trigger.

### Prerequisites

- [Terraform >= 1.5](https://developer.hashicorp.com/terraform/install)
- [gcloud CLI](https://cloud.google.com/sdk/docs/install)

```bash
gcloud auth application-default login
gcloud config set project client-jussimatic
```

### Dev script commands

```bash
./dev tf-init      # Initialize Terraform and download providers (run once)
./dev tf-plan      # Preview what will change
./dev tf-apply     # Apply changes
./dev tf-output    # Show deployed URLs, connection names, service account
./dev tf-import    # Import existing GCP resources into state (run once on existing projects)
```

`DB_PASSWORD` is read automatically from `.env.production`, or set it explicitly:

```bash
export TF_VAR_db_password="your-db-password"
```

---

### Option A — Fresh / empty GCP project

```bash
./dev tf-init

# Enable APIs first — everything else depends on them
./dev tf-plan -target=google_project_service.apis
./dev tf-apply -target=google_project_service.apis

# Apply remaining resources
./dev tf-plan
./dev tf-apply
```

After apply, populate the Secret Manager secrets (Terraform creates containers, not values):

```bash
PROJECT=client-jussimatic

echo -n "base64:..."         | gcloud secrets versions add LARAVEL_BACKEND_APP_KEY --data-file=- --project=$PROJECT
echo -n "your-db-pass"       | gcloud secrets versions add LARAVEL_BACKEND_DB_PASSWORD --data-file=- --project=$PROJECT
echo -n "your-gcs-key-id"    | gcloud secrets versions add LARAVEL_BACKEND_GCS_ACCESS_KEY_ID --data-file=- --project=$PROJECT
echo -n "your-gcs-secret"    | gcloud secrets versions add LARAVEL_BACKEND_GCS_SECRET_ACCESS_KEY --data-file=- --project=$PROJECT
echo -n "your-mail-pass"     | gcloud secrets versions add LARAVEL_BACKEND_MAIL_PASSWORD --data-file=- --project=$PROJECT
echo -n "your-mail-user"     | gcloud secrets versions add LARAVEL_BACKEND_MAIL_USERNAME --data-file=- --project=$PROJECT
echo -n "from@yourdomain.com"| gcloud secrets versions add LARAVEL_BACKEND_MAIL_FROM_ADDRESS --data-file=- --project=$PROJECT
echo -n "your-google-id"     | gcloud secrets versions add LARAVEL_BACKEND_GOOGLE_CLIENT_ID --data-file=- --project=$PROJECT
echo -n "random-string"      | gcloud secrets versions add LARAVEL_BACKEND_UPDATE_USER_ROLE_SECRET --data-file=- --project=$PROJECT
echo -n "random-string"      | gcloud secrets versions add LARAVEL_BACKEND_ROLE_UPDATE_KEY --data-file=- --project=$PROJECT
```

Then connect the GitHub repo in GCP console: **Cloud Build → Repositories → Connect Repository**.

---

### Option B — Existing GCP project

Import all existing resources into Terraform state, then apply:

```bash
./dev tf-init
./dev tf-import   # imports all GCP resources — already-imported ones are skipped
./dev tf-plan     # review drift carefully before applying
./dev tf-apply
```

---

### Remote state (recommended)

By default Terraform stores state locally. Enable the GCS backend in `terraform/backend.tf` (instructions are in that file as comments) for team use or CI/CD.

</details>

---

<details>
<summary><strong>Cloud Run Deployment</strong></summary>

Deployments are triggered automatically on push to `master` via Cloud Build (`cloudbuild.yaml`). Cloud Build builds and pushes the Docker image; Terraform manages the service configuration.

### Manual deploy (without Cloud Build)

```bash
# 1. Authenticate
gcloud auth login
gcloud config set project client-jussimatic
gcloud auth configure-docker europe-north1-docker.pkg.dev

# 2. Build and push
docker build -t europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest .
docker push europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest

# 3. Update image only (config is managed by Terraform)
gcloud run deploy jussilog-backend-production \
  --image europe-north1-docker.pkg.dev/client-jussimatic/jussilog-backend/jussilog-backend:latest \
  --region europe-north1 \
  --platform managed

# 4. Test
curl https://backend-jussilog.jussialanen.com/api/hello
```

### Notes

- **Logging** — logs go to stdout/stderr, available in Cloud Logging
- **Port** — Cloud Run injects `PORT`; the entrypoint script handles it automatically
- **Startup** — migrations and cache warming are skipped at startup by default to reduce cold-start time
- **Startup flags** — set `RUN_MIGRATIONS_AT_STARTUP=true`, `WARM_LARAVEL_CACHE_AT_STARTUP=true`, or `FIX_PERMISSIONS_AT_STARTUP=true` only when explicitly needed

</details>

---

<details>
<summary><strong>Database</strong></summary>

### MySQL with Docker (default for local dev)

The `docker-compose.yml` includes a MySQL 8.0 service with persistent storage.

`.env` defaults (from `.env.example`):

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=jussilog
DB_USERNAME=jussilog
DB_PASSWORD=jussilog
MYSQL_ROOT_PASSWORD=rootpassword
```

```bash
./dev up   # starts MySQL + app; entrypoint waits for MySQL and runs migrations automatically

# Access MySQL directly
docker-compose exec mysql mysql -u jussilog -pjussilog jussilog
mysql -h 127.0.0.1 -P 3306 -u jussilog -pjussilog jussilog  # from host
```

---

### SQLite (lightweight alternative)

```bash
# .env
DB_CONNECTION=sqlite

touch database/database.sqlite
php artisan migrate
```

---

### Cloud SQL (production)

Managed by Terraform. The app connects via Unix socket through the Cloud SQL Auth Proxy sidecar:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_SOCKET=/cloudsql/client-jussimatic:europe-north1:jussilog-db
DB_PORT=3306
DB_DATABASE=jussilog
DB_USERNAME=jussilog
```

**Test Cloud SQL connection locally:**

```bash
sudo mkdir -p /cloudsql && sudo chown "$USER":"$USER" /cloudsql
cloud-sql-proxy --unix-socket /cloudsql client-jussimatic:europe-north1:jussilog-db
```

Update `.env`:

```env
DB_SOCKET=/cloudsql/client-jussimatic:europe-north1:jussilog-db
DB_PASSWORD=YOUR_DB_PASSWORD
```

Verify:

```bash
php artisan tinker
# >>> DB::connection()->getPdo();

php artisan migrate --force   # create any missing tables
```

Or use the dev script:

```bash
./dev migrate-cloud
./dev db-export --cloud
./dev db-import --cloud data/snapshot.sql
```

</details>

---

<details>
<summary><strong>File Uploads</strong></summary>

Controlled by the `FILESYSTEM_DISK` env var.

### Local filesystem

```env
FILESYSTEM_DISK=public
```

```bash
php artisan storage:link
```

Files are stored under `storage/app/public/` and served at `/storage/...`.

### Google Cloud Storage (GCS)

```env
FILESYSTEM_DISK=gcs
GCS_ACCESS_KEY_ID=your-hmac-access-id
GCS_SECRET_ACCESS_KEY=your-hmac-secret
GCS_BUCKET=your-bucket-name
GCS_ENDPOINT=https://storage.googleapis.com
GCS_USE_PATH_STYLE_ENDPOINT=false
```

The bucket and its CORS config are managed by Terraform (`terraform/storage.tf`). HMAC keys are created in GCP console under **Cloud Storage → Settings → Interoperability**.

Signed URLs are returned for product images. Default expiry: 1 hour. If the bucket is made public, signed URLs still work but are not required.

</details>

---

<details>
<summary><strong>Local Development without Docker</strong></summary>

```bash
# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (SQLite)
touch database/database.sqlite
php artisan migrate
php artisan db:seed   # optional sample data

# Assets
npm run build

# Serve
php artisan serve
```

If route or config changes don't appear, clear caches:

```bash
php artisan optimize:clear
```

</details>

---

<details>
<summary><strong>Docker Configuration</strong></summary>

| File | Purpose |
|---|---|
| `Dockerfile` | Single-stage PHP-FPM + Nginx build (no Node.js build step) |
| `docker-compose.yml` | Local dev environment with MySQL and volume persistence |
| `docker-compose.sqlite.yml` | Lightweight SQLite variant |
| `docker/nginx.conf` | Laravel-optimized Nginx config |
| `docker/www.conf` | PHP-FPM pool config |
| `docker/opcache.ini` | OPcache settings for production |
| `docker/entrypoint.sh` | Startup script — waits for DB, handles port injection, optional startup tasks |
| `.dockerignore` | Excludes vendor, node_modules, and dev files from build context |

</details>

---

<details>
<summary><strong>Development</strong></summary>

### Tests

```bash
./dev artisan test         # via Docker
php artisan test           # directly
```

### Migrations

```bash
php artisan make:migration create_your_table
php artisan migrate
php artisan migrate:rollback
```

### Code style

```bash
./vendor/bin/pint
```

### API docs

```bash
php artisan scribe:generate
./dev generate-postman     # regenerate postman/collection.json
```

</details>

---

<details>
<summary><strong>Troubleshooting</strong></summary>

**Permission errors in Docker**

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

**SQLite database not found**

```bash
docker-compose exec app touch database/database.sqlite
docker-compose exec app php artisan migrate
```

**Port already in use**

Change the host port in `docker-compose.yml`:

```yaml
ports:
  - "8001:8080"
```

**Routes or config not updating**

```bash
./dev artisan optimize:clear
```

</details>

---

## Contributing

Contributions are welcome. Please submit a Pull Request.

## License

[MIT](https://opensource.org/licenses/MIT)

## Powered By

<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
</a>
</p>
