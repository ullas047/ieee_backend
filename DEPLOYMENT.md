# Production deployment

## Laravel backend

1. Copy `deploy/.env.production.example` to the production host as `.env` and replace every placeholder. Keep the existing `APP_KEY`; never generate a new key for an existing application.
2. Set `APP_URL` to the public backend URL. API image URLs are generated from this value.
3. Install dependencies and deploy database changes:

   ```sh
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. Run a persistent queue worker if queued jobs are used:

   ```sh
   php artisan queue:work --tries=3 --timeout=90
   ```

5. Configure HTTPS at the web server or reverse proxy. The web root must be Laravel's `public` directory.

## React frontend

1. Create `.env.production.local` in the React project with the public backend URL:

   ```env
   VITE_API_URL=https://backend.example.com
   ```

2. Build and deploy only the generated `dist/` directory:

   ```sh
   npm ci
   npm run build
   ```

Do not deploy `.env.development.local`; it is only for local development.
