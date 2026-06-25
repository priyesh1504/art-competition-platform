# RangKala Art Academy Web Platform

A **comprehensive web-based management system** designed for art academies to manage competitions, student portfolios, grading, certificate generation, and secure payments.

Built with **Laravel 11**, the platform connects four key user roles: **Admin, Teacher, Student, and Caregiver**, providing an integrated digital environment for managing art competitions and student progress.

---

## 1. Role-Based Access Control (RBAC)

The platform implements secure **role-based permissions** to ensure that users only access features relevant to their role.

**Admin**

* Manage users and system settings
* Manage competitions
* View and manage financial records

**Teacher**

* Create and manage competitions
* Grade student submissions
* Generate certificates

**Student**

* Register for competitions
* Upload artworks
* Manage personal portfolio
* Download certificates

**Caregiver**

* Monitor student progress
* View teacher feedback
* Receive notifications about competitions and grades

---

# 2. Competition Management

The system allows administrators and teachers to manage art competitions efficiently.

Features include:

* Create, edit, and delete competitions
* Define competition rules and deadlines
* Set registration fees
* Separate management dashboards for **Admin and Teachers**

---

# 3. Submission and Grading System

Students can submit artworks to competitions, while teachers evaluate and provide feedback.

**Key capabilities:**

* Artwork upload linked to competitions
* Teacher grading system (**0 – 100 score**)
* Textual feedback from teachers
* **Automatic certificate generation** after grading

Certificates are generated using **Intervention Image**.

---

# 4. Portfolio Management

Students can maintain a **personal art portfolio** within the system.

Features include:

* Categorized gallery (Sketching, Watercolour, Digital Art, etc.)
* Artwork filtering by **style and date**

---

# 5. Certificate Management

The platform automatically generates certificates for graded submissions.

Features:

* Automated **PDF certificate generation**
* Customizable certificate templates
* Digital signature support
* Certificates linked to **student profiles and competition records**

---

# 6. Payment and Financial Management

The system supports secure online payments for competition registration.

Features include:

* **Stripe payment integration**
* Secure checkout process
* **Automatic PDF receipts**
* Receipts emailed to students after payment
* Financial record history with **soft delete support**
* Admin access to download and manage transaction records

---

# 7. Notifications

Users receive real-time system notifications.

Examples:

* New competition announcements
* Grading feedback alerts
* Payment confirmations

Notifications appear through the **in-app notification bell icon**.

---

# 8. Security and Session Management

The platform includes several security features to protect user accounts and data.

Security mechanisms include:

* **Session timeout:** Automatic logout after **15 minutes of inactivity**
* **Account lockout:** Account temporarily locked after **5 failed login attempts**
* **Soft deletion:** Important data (payments and certificates) are archived instead of permanently deleted
* **Middleware protection:** Strict role-based access control for dashboards

---

# 🛠 Technology Stack

| Component               | Technology                    |
| ----------------------- | ----------------------------- |
| Backend                 | PHP 8.3                       |
| Framework               | Laravel 11                    |
| Frontend                | Blade Templates, Tailwind CSS |
| Database                | MySQL 8.0                     |
| Payment Gateway         | Stripe (Laravel Cashier)      |
| PDF Generation          | DomPDF                        |
| Image Processing        | Intervention Image            |
| Version Control         | Git                           |
| Development Environment | Laragon / XAMPP               |

---

# Prerequisites

Ensure the following tools are installed before running the system:

* PHP **8.2 or higher**
* Composer
* Node.js & NPM
* MySQL
* Git

---

# Installation and Setup

## 1. Clone the Repository

```bash
git clone https://github.com/your-username/rangkala-academy.git
cd rangkala-academy
```

---

## 2. Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install Node dependencies:

```bash
npm install
```

---

## 3. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Update your `.env` file:

```
DB_DATABASE=rangkala_db
DB_USERNAME=root
DB_PASSWORD=

# Stripe Keys (Use Test Keys for Development)
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
CASHIER_CURRENCY=usd

# Session Timeout
SESSION_LIFETIME=15
```

---

# 4. Database Setup

Run database migrations:

```bash
php artisan migrate
```

(Optional) Seed the database:

```bash
php artisan db:seed
```

---

# 5. Link Storage

Create a symbolic link for public file access:

```bash
php artisan storage:link
```

---

# 6. Compile Frontend Assets

```bash
npm run build
```

---

# Default Test Credentials

If database seeding is enabled:

| Role      | Email                                                 | Password |
| --------- | ----------------------------------------------------- | -------- |
| Admin     | [admin@example.com](mailto:admin@example.com)         | password |
| Teacher   | [teacher@example.com](mailto:teacher@example.com)     | password |
| Student   | [student@example.com](mailto:student@example.com)     | password |
| Caregiver | [caregiver@example.com](mailto:caregiver@example.com) | password |

Note: The **Admin must link Students to Caregivers** through the Manage Users page.

---

# Project Structure

```
app
 └── Http
      └── Controllers
           ├── Auth
           ├── AdminUserController
           ├── GradingController
           ├── PaymentController
           ├── StudentArtworkController
           └── StudentPortfolioController

 └── Models
      ├── User.php
      ├── Competition.php
      ├── Artwork.php
      ├── Certificate.php
      └── Payment.php

 └── Notifications
      └── PaymentReceivedNotification.php

 └── Middleware
      ├── IsAdmin.php
      ├── IsStudent.php
```

```
resources
 └── views
      ├── auth
      ├── dashboards
      ├── admin
      ├── teacher
      ├── student
      ├── caregiver
      └── pdf
           └── receipt.blade.php
```

---

# Testing

The project includes **PHPUnit tests** to ensure reliability.

### Run All Tests

```bash
php artisan test
```

### Run Specific Test Suites

Authentication tests

```bash
php artisan test --filter AuthTest
```

Payment tests

```bash
php artisan test --filter PaymentFeatureTest
```

Submission tests

```bash
php artisan test --filter StudentSubmissionTest
```

Certificate tests

```bash
php artisan test --filter CertificateGenerationTest
```

---

# What is Tested

* Role-based redirection
* Login security and account lockout
* Stripe payment redirection
* PDF receipt generation
* Email notifications (mocked)
* Soft deletion of financial records

---

#  Admin First-Time Setup

To activate the system:

### Upload Certificate Template

Navigate to:

Dashboard → Manage Certificates

Upload:

* Certificate background image (recommended **1123×794 px**)
* Optional digital signature

---

### Create a Competition

Dashboard → Manage Competitions → **Create New**

Define:

* Competition name
* Registration fee
* Deadline
* Rules

---

### Link Students to Caregivers

Dashboard → Manage Users

* Edit a student account
* Select caregiver from dropdown

---

# Configuration Details

## Session Management

* Timeout configured in `.env`
* Default: **15 minutes**

---

## File Uploads

Allowed formats:

* JPG
* JPEG
* PNG

Maximum file size:

* **5 MB**

Storage location:

```
storage/app/public/artworks
```

Access via:

```
php artisan storage:link
```

---

## Payments

Gateway: **Stripe Checkout**

Currency: **USD**

Receipts:

* Generated using **DomPDF**
* Stored in

```
storage/app/public/receipts
```

---

# Known Issues & Troubleshooting

### 403 Access Denied

Cause: User attempting to access a restricted role.

Solution: Verify middleware configuration in:

* `routes/web.php`
* `Kernel.php`

---

### 419 Page Expired

Cause: CSRF token mismatch due to session expiration.

Solution: The system redirects users to login automatically via the exception handler.

---

### Images or Certificates Not Displaying

Cause: Missing storage link.

Fix:

```bash
php artisan storage:link
```

---

### Stripe 500 Error

Cause: Incorrect API keys or missing configuration.

Fix:

```bash
php artisan vendor:publish --tag=cashier-config
```

Update `.env` with correct Stripe keys.

---

# License

This project was developed as a **Senior Development Project for Asia-Pacific International University**.

All rights reserved.

---

# Developer

**Priyesh Kumar**
Student ID: 202200209
Program: B.Sc. in Information Technology
Asia Pacific International University

---

