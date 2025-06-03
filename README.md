# WireMart

**WireMart** is a modern multi-role eCommerce web application built with Laravel 12, Livewire 3.0, and Breeze.  
It supports three user roles — **Admin**, **Seller**, and **Customer** — each with its own dashboard and permissions.

---

## 🚀 Features

- 🔐 Multi-role system: Admin, Seller, Customer
- 🌐 Multi-language support: Arabic (ar), English (en), French (fr)
- 🧑‍💼 Admin dashboard with full control:
  - Manage users (sellers/customers)
  - Update homepage content (banners, offers, images)
- 🛍 Seller dashboard to manage products and view orders
- 👥 Customer dashboard for shopping, orders, and profile
- 💳 Integrated PayPal payment gateway
- 📦 Product management, categories, offers, and more
- 📈 Responsive and Bootstrap-powered UI
- ⚡ Livewire 3.0 for dynamic, real-time features
- 🧰 Built with Laravel Breeze for authentication and scaffolding

---

## 🧰 Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade + Bootstrap
- **Realtime**: Livewire 3.0
- **Authentication**: Laravel Breeze
- **Languages**: Arabic, English, French
- **Payment**: PayPal (Sandbox)

---

## 🛠 Installation

To run this project locally, follow these steps:

```bash
# 1. Clone the repository
git clone https://github.com/your-username/wiremart.git

# 2. Navigate into the project directory
cd wiremart

# 3. Install PHP dependencies
composer install

# 4. Create a copy of the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. Install frontend dependencies and compile assets
npm install && npm run dev

# 8. Start the local development server
php artisan serve
```

---

## 🧪 Test PayPal Account

To test the payment functionality, use the following PayPal **Sandbox** credentials:

- **Email:** `sb-9yflv42128533@personal.example.com`  
- **Password:** `7z{?F(&t`

⚠️ *This is a sandbox (test) account — no real payments will be processed.*
