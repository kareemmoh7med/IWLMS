# IWLMS - منصة إدارة التعلم التفاعلية

## 📋 المتطلبات
- PHP >= 8.1
- Composer
- Node.js >= 18
- MySQL
- Laragon (بيئة العمل المحلية)

---

## 🚀 خطوات التثبيت (افعل هذا بالترتيب)

### 1️⃣ إنشاء مشروع Laravel جديد

افتح Terminal وشغّل:

```bash
laravel new IWLMS
```

اختر من القائمة:
- Starter kit: **Breeze**
- Breeze stack: **Vue with Inertia**
- Dark mode: **No**
- Testing: **Pest**
- Database: **MySQL**

### 2️⃣ انسخ ملفات هذا الـ ZIP داخل مجلد المشروع

بعد ما تخلص الإنشاء، انسخ كل الملفات من الـ ZIP وضعها داخل مجلد `IWLMS` — الملفات هتتمرج مع اللي موجود.

### 3️⃣ تثبيت الحزم المطلوبة

```bash
# Laravel Permission (إدارة الأدوار)
composer require spatie/laravel-permission

# Laravel Socialite (تسجيل الدخول بـ Google)
composer require laravel/socialite

# تثبيت حزم الـ Frontend
npm install

# تثبيت Flowbite
npm install flowbite
```

### 4️⃣ نشر إعدادات Spatie Permission

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 5️⃣ إعداد قاعدة البيانات

افتح **Laragon** وشغّل MySQL. ثم أنشئ قاعدة بيانات اسمها `iwlms`:

```sql
CREATE DATABASE iwlms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6️⃣ إعداد ملف .env

انسخ ملف `.env.example` وسمّيه `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

عدّل في `.env`:

```env
DB_DATABASE=iwlms
DB_USERNAME=root
DB_PASSWORD=
```

### 7️⃣ إعداد Google OAuth

1. اذهب إلى [Google Cloud Console](https://console.cloud.google.com)
2. أنشئ مشروع جديد
3. فعّل **Google+ API** أو **Google Identity**
4. اذهب إلى **Credentials** → **Create OAuth 2.0 Client ID**
5. في **Authorized redirect URIs** أضف: `http://localhost/auth/google/callback`
6. انسخ الـ Client ID والـ Client Secret وضعهم في `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
```

### 8️⃣ تشغيل الـ Migrations والـ Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 9️⃣ رفع الـ Storage

```bash
php artisan storage:link
```

### 🔟 تشغيل المشروع

افتح **Terminal منفصلَين**:

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

افتح المتصفح على: **http://localhost:8000**

---

## 👤 بيانات الدخول الافتراضية

| الدور | الإيميل | الباسورد |
|-------|---------|----------|
| Admin | admin@iwlms.com | admin123 |
| Student | student@iwlms.com | student123 |

---

## 📁 هيكل المشروع

```
IWLMS/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php   ← لوحة تحكم الأدمن
│   │   │   └── CourseController.php      ← CRUD الكورسات والمحاضرات
│   │   ├── Student/
│   │   │   └── CourseController.php      ← عرض + اشتراك الطالب
│   │   └── Auth/
│   │       └── GoogleController.php      ← تسجيل دخول Google
│   └── Models/
│       ├── User.php
│       ├── Course.php
│       ├── Lecture.php
│       └── Enrollment.php
├── database/
│   ├── migrations/                       ← جداول DB
│   └── seeders/DatabaseSeeder.php        ← بيانات تجريبية
├── resources/js/Pages/
│   ├── Welcome.vue                       ← الصفحة الرئيسية
│   ├── Admin/
│   │   ├── Dashboard.vue
│   │   └── Courses/ (Index, Create, Edit)
│   └── Student/
│       ├── MyCourses.vue
│       └── Courses/ (Index, Show)
├── routes/web.php                        ← كل الروتات
└── config/services.php                   ← إعدادات Google
```

---

## 🛠️ المشاكل الشائعة

**خطأ في الـ Permissions؟**
```bash
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear
```

**خطأ في Google OAuth؟**
- تأكد إن الـ redirect URI في Google Console طابق ما في `.env` بالظبط
- تأكد إن `GOOGLE_CLIENT_ID` و `GOOGLE_CLIENT_SECRET` مضبوطين

**الصور مش ظاهرة؟**
```bash
php artisan storage:link
```
