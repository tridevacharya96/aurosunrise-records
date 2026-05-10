# 🎵 Aurosunrise Records

> Laravel + Vue.js music label website

## ⚡ Quick Start

> **Auromax Digital already runs on `localhost:8000`**
> Aurosunrise Records uses **`localhost:8001`** to avoid conflicts.

### Terminal 1 — Laravel Backend
```bash
php artisan serve --port=8001
```
→ Open **http://localhost:8001**

### Terminal 2 — Vue.js Frontend (Vite HMR)
```bash
npm run dev
```
→ Vite runs on **http://localhost:5174** (used internally for hot reload)
→ You still visit **http://localhost:8001** in your browser

---

## 🗂 Your Running Apps

| App               | Laravel Port | Vite Port |
|-------------------|-------------|-----------|
| Auromax Digital   | :8000       | :5173     |
| Aurosunrise Records | **:8001** | **:5174** |

---

## 🛠 Full Setup (first time)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# Edit .env → set DB_DATABASE=aurosunrise_records
php artisan migrate --seed
php artisan storage:link
php artisan serve --port=8001   # Terminal 1
npm run dev                      # Terminal 2
```

## 📚 Learning Guide
See `docs/VUEJS_LEARNING_GUIDE.md` for the complete Vue.js + Laravel tutorial.
