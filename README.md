<div dir="rtl">

# ⚡ Task Manager REST API — من الصفر إلى الاختبار الآلي

### تطبيق معايير RESTful API المتقدمة في Laravel 13 مع مصادقة Sanctum واختبارات Pest
**المقرر:** هندسة البرمجيات — الجانب العملي  
**إشراف:** م. ساهر القائد (الهمداني)  
**المرجع:** [`Qaidsaher/laravel-api-from-zero-to-testing`](https://github.com/Qaidsaher/laravel-api-from-zero-to-testing)

---

## 🌟 نظرة عامة
مشروع متكامل لتطبيق أفضل الممارسات الهندسية في بناء واجهات برمجة التطبيقات (REST APIs) في بيئة **Laravel 13** و **PHP 8.4**، يشمل:
* **المصادقة الآمنة:** عبر `Laravel Sanctum` والـ Bearer Tokens.
* **فصل الاهتمامات (Separation of Concerns):**
  * التحقق المنفصل عبر `Form Requests`.
  * تنسيق وتوحيد استجابات JSON عبر `API Resources`.
  * عزل الصلاحيات وحماية الموارد عبر `Policies`.
* **التصنيفات والفلترة (Lab 04 Final Challenge):** دعم التصنيفات `categories`، وفلترة المهام حسب الحالة والتصنيف، والبحث النصي، والترقيم التلقائي (Pagination).
* **الميزة الإضافية (Bonus):** نقطة نهاية سريعة لإكمال المهمة `PATCH /api/tasks/{task}/complete`.
* **الاختبارات الآلية (Pest):** تغطية شاملة لـ 54 اختباراً و 149 تأكيداً تضمن استقرار النظام وسلامة الصلاحيات وحالات الحافة.

---

## 🛣️ جدول نقاط النهاية (API Endpoints)

### 1. المصادقة (Authentication)
| الطريقة | المسار | الوظيفة | الحماية | كود الاستجابة |
|---|---|---|---|:---:|
| `POST` | `/api/register` | تسجيل مستخدم جديد وإصدار Token | عام | `201 Created` |
| `POST` | `/api/login` | تسجيل الدخول وإصدار Token | عام | `200 OK` |
| `POST` | `/api/logout` | إلغاء وحذف رمز الوصول الحالي | `auth:sanctum` | `200 OK` |
| `GET` | `/api/me` | استرجاع بيانات المستخدم المسجل | `auth:sanctum` | `200 OK` |

### 2. التصنيفات (Categories — Lab 04)
| الطريقة | المسار | الوظيفة | الحماية | كود الاستجابة |
|---|---|---|---|:---:|
| `GET` | `/api/categories` | استعراض فئات المستخدم المسجل | `auth:sanctum` | `200 OK` |
| `POST` | `/api/categories` | إنشاء فئة جديدة | `auth:sanctum` | `201 Created` |
| `GET` | `/api/categories/{id}` | استعراض فئة محددة | `auth:sanctum` + Policy | `200 OK` |
| `DELETE` | `/api/categories/{id}` | حذف فئة محددة | `auth:sanctum` + Policy | `204 No Content` |

### 3. المهام (Tasks — CRUD & Features)
| الطريقة | المسار | الوظيفة | الحماية | كود الاستجابة |
|---|---|---|---|:---:|
| `GET` | `/api/tasks` | قائمة المهام (مرقمة 10/صفحة) | `auth:sanctum` | `200 OK` |
| `GET` | `/api/tasks?category_id=X` | فلترة المهام حسب الفئة | `auth:sanctum` | `200 OK` |
| `GET` | `/api/tasks?status=completed` | فلترة المهام حسب الحالة | `auth:sanctum` | `200 OK` |
| `GET` | `/api/tasks?search=keyword` | بحث نصي في العنوان والوصف | `auth:sanctum` | `200 OK` |
| `POST` | `/api/tasks` | إنشاء مهمة جديدة مع ربط الفئة | `auth:sanctum` | `201 Created` |
| `GET` | `/api/tasks/{id}` | عرض تفاصيل مهمة للمالك | `auth:sanctum` + Policy | `200 OK` |
| `PATCH` | `/api/tasks/{id}` | تعديل مهمة | `auth:sanctum` + Policy | `200 OK` |
| `PATCH` | `/api/tasks/{id}/complete` | إكمال المهمة مباشرة (Bonus) | `auth:sanctum` + Policy | `200 OK` |
| `DELETE` | `/api/tasks/{id}` | حذف مهمة | `auth:sanctum` + Policy | `204 No Content` |

---

## 🏗️ معمارية وقواعد الأمان

```
Client (Postman / App)
         ↓  (Authorization: Bearer <token>)
   Sanctum Middleware
         ↓
   Form Requests (التحقق من المدخلات وتبعيات المعرفات)
         ↓
   Controller (نحيف)
         ↓
   Policies (TaskPolicy / CategoryPolicy — فحص 403 Forbidden للملكية)
         ↓
   Model / Database (SQLite)
         ↓
   API Resources (تنسيق مخرجات JSON بشكل موحد)
```

---

## 🚀 التثبيت والتشغيل المحلي

### 1. المتطلبات
* PHP 8.3 أو 8.4
* Composer 2
* SQLite

### 2. خطوات التشغيل السريع
```bash
# نسخ المستودع
git clone https://github.com/AWNO-1/se-lab-laravel-api-testing.git
cd se-lab-laravel-api-testing

# إعداد البيئة
copy .env.example .env
composer install

# إنشاء قاعدة البيانات ومفتاح التطبيق
php artisan key:generate
php artisan migrate

# تشغيل الخادم المحلي
php artisan serve
```

---

## 🧪 تشغيل الاختبارات الآلية (Pest Tests)

تم فحص كافة حالات النجاح والأخطاء وحالات الحافة:

```bash
php artisan test
```

### نتيجة الفحص:
```text
   PASS  Tests\Feature\AuthApiTest
  ✓ user can register via api and receives token
  ✓ user cannot register with duplicate email
  ✓ user can login with valid credentials
  ✓ user cannot login with invalid credentials
  ✓ authenticated user can view profile via me endpoint
  ✓ authenticated user can logout and revoke token

   PASS  Tests\Feature\CategoryApiTest
  ✓ authenticated user can create category
  ✓ category name is required
  ✓ authenticated user can list own categories
  ✓ task can belong to category
  ✓ invalid category id rejected
  ✓ user cannot assign another users category

   PASS  Tests\Feature\TaskApiTest
  ✓ guest cannot access tasks
  ✓ user can list own tasks
  ✓ user can create a task
  ✓ title is required
  ✓ status must be valid
  ✓ user can view own task
  ✓ missing task returns 404
  ✓ user cannot view another users task
  ✓ user can update own task
  ✓ user cannot update another users task
  ✓ user can delete own task
  ✓ tasks can be filtered by status
  ✓ tasks can be filtered by category
  ✓ tasks can be searched
  ✓ tasks are paginated
  ✓ user can mark task as complete via bonus endpoint
  ✓ user cannot mark another users task as complete

Tests:    54 passed (149 assertions)
Duration: 3.82s
```

---

## 📁 أدوات الاختبار المرفقة
* **مجموعة Postman:** تجدها في `postman/Task-Manager-API.postman_collection.json` جاهزة للاستيراد المباشر.
* **ملف REST Client:** تجده في `examples/http/task-api.http` لتجربة المسارات مباشرة من داخل المحرر.

---

## 📄 الترخيص
MIT — مشروع عملي أكاديمي لمقرر هندسة البرمجيات 2026.

</div>
