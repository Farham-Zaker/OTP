# Laravel OTP Verification System

This is a simple Laravel-based OTP (One Time Password) verification system using jobs and queues.  
It allows users to request a code via SMS and verify their phone number.

---

## 📦 Features

- Phone number input & OTP validation  
- OTP sent via queued job  
- OTP expiration and single-use  
- Laravel API-ready structure  

---
## 🚀 Setup

1. Clone the repository:

```bash
git clone https://github.com/Farham-Zaker/OTP.git
cd OTP
```

2. Install dependencies:

```bash
composer install
```

3. Copy `.env` file and set your configs:

```bash
cp .env.example .env
php artisan key:generate
```

4. Set database and SMS config in `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

API_KEY=<SMD Yar api key>
SMS_TEMPLATE=<SMS Yar template code>
```

5. Run migrations:

```bash
php artisan migrate
```

6. Start the Laravel development server:

```bash
php artisan serve
```

7. Start the queue worker (important!):

```bash
php artisan queue:work
```

---

## 📮 API Endpoints

- `POST /api/send` – Request OTP by phone number  
- `POST /api/verify` – Verify OTP and complete authentication  

---

## 🛠 Technologies

- Laravel 12  
- Jobs & Queues  
- Validation Rules  
- MySQL 

---

## ⚠️ Notes

- Make sure the queue worker is running, otherwise OTPs won't be sent.  
- Use tools like Supervisor on production for running workers continuously.  

---

## 📃 License

MIT – feel free to use and modify.
