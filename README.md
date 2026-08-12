<h1 align="center">✝️ Grace Evangelical Church</h1>

<p align="center">
  A full-featured web application and content management system built for Grace Evangelical Church —
  empowering the ministry with tools to manage books, sermons, subscribers, and site content.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css" alt="TailwindCSS">
</p>

---

## 📖 About The Project

The **Grace Evangelical Church Web Application** is a custom-built platform designed to serve the digital presence of Grace Evangelical Church. It provides an elegant public-facing front end for visitors and a powerful admin panel for church administrators to manage all site content without requiring technical knowledge.

The platform was built with a focus on simplicity, reliability, and expandability — making it easy for church staff to publish books, manage chapters (sermons/lessons), respond to visitor inquiries, and grow the subscriber community.

---

## ✨ Core Features

### 🌐 Public Frontend
- **Welcome Page** — A branded landing page that introduces the church to visitors.
- **Login & Authentication** — Secure login for church administrators.

### 📚 Book & Chapter Management
- **Books** — Create, edit, activate/deactivate, and delete church books or sermon series.
- **Chapters** — Attach audio chapters/sermons to books with support for chapter numbering, dates, and duration.
- **Categories** — Organise books into categories for easy discovery.
- **Auto-Notification** — Automatically notifies all subscribers via email when a new book or chapter is published.

### 📬 Subscriber Management
- **Subscriber List** — View and manage email subscribers who have signed up for updates.
- **Email Notifications** — Queued email delivery via Laravel's mail system to keep subscribers informed.

### 📥 Inbox / Site Messages
- **Contact Messages** — Receive and manage messages submitted by visitors through the church website.
- **Read/Unread Tracking** — Quickly identify unread messages from the dashboard and sidebar badge counter.

### 🛠️ Admin Panel (CMS)
- **Dashboard** — At-a-glance summary of total books, chapters, subscribers, and unread messages with quick-access links.
- **About Us** — Manage the church's "About Us" page content directly from the admin panel.
- **System Settings** — Configure site name, logo, admin branding, and email settings.
- **Profile Settings** — Administrators can update their own profile information, password, and avatar.
- **Dynamic Pages** — Create and manage custom content pages (e.g., Terms, Privacy Policy).
- **FAQs** — Manage frequently asked questions with drag-and-drop priority ordering.
- **User Management** — Create, edit, activate/deactivate, and manage admin users.
- **Role & Permission System** — Spatie-powered role-based access control for fine-grained permission management.

### 🔒 Security
- CSRF protection on all forms.
- Role-based route guards via middleware.
- JWT authentication support for API routes.
- Bcrypt password hashing.

### 📡 API Support
- RESTful API endpoints secured with Laravel Sanctum and JWT Auth for external integrations or mobile apps.

---

## 🎯 Purpose Of The Project

This application serves as the **digital backbone of Grace Evangelical Church's online ministry**, with the following goals:

1. **Grow the Community** — Allow visitors to discover the church, read about its mission, and sign up for updates.
2. **Distribute the Word** — Publish and organise sermon series (books) and individual sermons (chapters) with audio support.
3. **Communicate Effectively** — Enable the church to receive inquiries and respond to the congregation via email.
4. **Empower Non-Technical Staff** — Provide a simple, intuitive CMS so church administrators can manage all content without needing developer assistance.
5. **Scale with the Ministry** — The modular architecture supports future growth, including potential mobile app integration via the existing API layer.

---

## 🏗️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 11.x |
| **Language** | PHP 8.2+ |
| **Database** | MySQL |
| **Authentication** | Laravel Breeze + JWT Auth + Laravel Sanctum |
| **Authorization** | Spatie Laravel Permission |
| **Frontend** | Blade Templates + Bootstrap 5 + TailwindCSS |
| **JS Bundler** | Vite |
| **Tables** | Yajra DataTables |
| **Email** | Laravel Mail (SMTP / log driver) |
| **File Storage** | Local (configurable via `FILESYSTEM_DISK`) |
| **Queue** | Database driver |
| **Real-time** | Laravel Reverb (WebSockets) |
| **Flash Messages** | PHP Flasher |
| **Image Handling** | Intervention Image |

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL database

### Installation

**1. Clone the repository**
```bash
git clone <repository-url>
cd pdrashed
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install Node dependencies**
```bash
npm install
```

**4. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configure your `.env` file**
```env
APP_NAME="Grace Evangelical Church"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="no-reply@graceec.org"
MAIL_FROM_NAME="${APP_NAME}"
```

**6. Run migrations and seeders**
```bash
php artisan migrate --seed
```

**7. Build frontend assets**
```bash
npm run build
```

**8. Start the development server**
```bash
composer run dev
```
> This runs the Laravel server, queue worker, log monitor, and Vite dev server concurrently.

---

## 📂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Web/
│   │   │   └── backend/          # Admin panel controllers
│   │   │       ├── BookController.php
│   │   │       ├── ChapterController.php
│   │   │       ├── CategoryController.php
│   │   │       ├── SettingController.php
│   │   │       ├── UserController.php
│   │   │       ├── InboxController.php
│   │   │       └── ...
│   │   └── Api/                  # API controllers
├── Models/
│   ├── Book.php
│   ├── Chapter.php
│   ├── Category.php
│   ├── Subscriber.php
│   ├── SiteMessage.php
│   └── ...
├── Mail/                         # Mailable classes (NewBookLaunched, etc.)
resources/
├── views/
│   ├── backend/                  # Admin panel Blade templates
│   └── frontend/                 # Public-facing Blade templates
routes/
├── web.php                       # Public routes
├── backend.php                   # Admin panel routes
├── api.php                       # API routes
└── auth.php                      # Authentication routes
```

---

## 🔑 Default Admin Access

After seeding, log in using the credentials defined in your database seeder.

> ⚠️ **Important:** Change the default admin password immediately after first login.

---

## 📧 Email Notifications

The application sends queued emails to subscribers on:
- **New Book Published** — via `NewBookLaunched` Mailable
- **New Chapter Published** — via `NewChapterLaunched` Mailable

Ensure the queue worker is running for emails to be delivered:
```bash
php artisan queue:listen --tries=1
```

---

## 🛡️ Security Considerations

- Set `APP_DEBUG=false` and `APP_ENV=production` in your production `.env`.
- Always use HTTPS in production. Set `APP_URL` to your HTTPS domain.
- Keep your `APP_KEY` secret — never commit it to version control.
- Review role assignments regularly to maintain principle of least privilege.

---

## 📋 Roadmap / Planned Improvements

- [ ] Public sermon/book reading page for visitors
- [ ] Mobile app integration via the existing API layer
- [ ] Advanced search for books and chapters
- [ ] Sermon audio streaming improvements
- [ ] Online giving / donation module
- [ ] Event calendar for church activities
- [ ] Multi-language support

---

## 📄 License

This project is proprietary software developed for **Grace Evangelical Church**.  
All rights reserved © Grace Evangelical Church.
