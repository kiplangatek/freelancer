# Freelancer Platform

A Laravel-based service exchange platform where clients hire freelancers by category and skill, track applications, and manage ratings, chats, and more.

---

## 🚀 Features

- **User roles**: Clients and freelancers
- **Authentication**: Registration, login, email verification
- **Profile management**
- **Job postings**: Create, search (by skill), filter, apply
- **Application tracking** for clients
- **Real-time chat** between clients and freelancers
- **Ratings & reviews** on services
- Built with **Laravel** & **SQLite** (can switch to MySQL)

---

## 🛠️ Tech Stack

- PHP 8+, Laravel 10+  
- SQLite (default; works with MySQL/PostgreSQL)  
- Blade templates & Laravel Mix/Vite  
- Tailwind CSS (optional for UI enhancements)

---

## ⚙️ Requirements

- PHP >= 8.1  
- Composer  
- Node.js & NPM  
- SQLite (or MySQL/Postgres)

---

## 🛠️ Installation

```bash
# 1. Clone
git clone https://github.com/kiplangatek/freelancer.git
cd freelancer

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database
# (default: SQLite) — ensure `database/database.sqlite` exists, then:
php artisan migrate --seed

# 5. Optional build
npm run build

🚧 Usage (local dev)

php artisan serve
npm run dev

Visit http://127.0.0.1:8000, register, and explore as a client or freelancer.
📁 Deployment (production)

    Use composer install --optimize-autoloader --no-dev

    Set up cronjobs (php artisan schedule:run)

    Use Supervisor or queues for chat notifications


🤝 Contributing

Contributions are welcome! Please:

    Fork the project

    Create a feature branch (git checkout -b feature/YourFeature)

    Commit with clear messages
