# Laravel E-Commerce Mock Test

Quick setup to run this Laravel project locally.

## Requirements

- PHP >= 8.1  
- Composer  
- MySQL  

## Setup Steps

1. **Clone the repository**

```bash
git clone https://github.com/imjishnur/ecommwmocktest.git
cd ecommwmocktest
```

2. **Install PHP dependencies**

```bash
composer install
```
```bash
rm -rf node_modules
npm install
npm run build
```



3. **Copy `.env` file and generate app key**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Set database credentials in `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

6. **Start the server**

```bash
php artisan serve
```

Open in browser: `http://127.0.0.1:8000`

---

## Sample Login Credentials

| Area            | URL                                                      | Email               | Password  |
|-----------------|----------------------------------------------------------|-------------------|----------|
| Admin Dashboard | [http://127.0.0.1:8000/dashboard](http://127.0.0.1:8000/dashboard) | admin@example.com | password |
| Frontend        | [http://127.0.0.1:8000/](http://127.0.0.1:8000/)       | -       customercustomer@example.com          | password-        |

---


-

## Quick One-Line Setup (Optional)

```bash
composer install && cp .env.example .env && php artisan key:generate && php artisan migrate --seed &&  php artisan serve
```

This will set up everything and start the server.
