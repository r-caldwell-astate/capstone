# Capstone App

A web application built with **Laravel 12**, **Vite**, and **Vue 3**.

---

## 🚀 Getting Started

Follow these steps to get your local development environment running.

### 1. Clone the repository

```bash
git clone git@github.com:r-caldwell-astate/capstone.git
cd capstone
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node.js dependencies

```bash
npm install
```

### 4. Set up environment file

Copy the example `.env` file and generate a new application key:

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your local database and environment settings as needed.

### 5. Run the development servers

Run Laravel backend:

```bash
php artisan serve
```

In another terminal, start Vite for frontend assets:

```bash
npm run dev
```

Your app should now be available at:

* **Backend (Laravel)** → [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Frontend (Vite assets)** → auto-injected by Laravel

---

## 🗂 Project Structure

* `app/` → Laravel backend (controllers, models, etc.)
* `resources/js/` → Vue 3 components and frontend logic
* `resources/views/` → Blade templates (connects Laravel + Vue)
* `public/` → Compiled assets and static files

---

## ✅ Useful Commands

### Run database migrations

```bash
php artisan migrate
```

### Clear caches (if things break)

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Build assets for production

```bash
npm run build
```

---

## 👥 Team Setup Notes

* **Do not commit `.env`** or other local-only files.
* Run `composer install` and `npm install` whenever new dependencies are added.
* Create feature branches for new work (`git checkout -b feature/my-feature`).
* Open a pull request when ready to merge changes into `main`.

---

## 📖 References

* [Laravel Documentation](https://laravel.com/docs)
* [Vue 3 Documentation](https://vuejs.org/guide/introduction.html)
* [Vite Documentation](https://vitejs.dev/guide/)

---
