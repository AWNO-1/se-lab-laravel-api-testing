# قائمة التحقق من مخرجات واجهات برمجة التطبيقات — Deliverables Checklist & Rubric
### المقرر: هندسة البرمجيات — الجانب العملي (معمل REST API من الصفر إلى الاختبار)
**إشراف: م. ساهر القائد (الهمداني)**

---

## 🎯 جدول درجات التقييم (Rubric — 20 Marks)

| المحور الهندسي | الدرجة المستحقة | الحالة | التفاصيل والمخرجات المنجزة |
|---|:---:|:---:|---|
| **1. REST Design** | **3 / 3** | مكتمل ✅ | تصميم RESTful قياسي: استخدام HTTP Verbs المناسبة (`GET`, `POST`, `PATCH`, `PUT`, `DELETE`)، وحالات استجابة دقيقة (`200 OK`, `201 Created`, `204 No Content`, `401 Unauthorized`, `403 Forbidden`, `404 Not Found`, `422 Unprocessable`). مسارات كائنية نظيفة وStateless بالكامل. |
| **2. Validation / Resources** | **3 / 3** | مكتمل ✅ | - طلبات تحقق مستقلة: `StoreTaskRequest`, `UpdateTaskRequest`, `StoreCategoryRequest`, `LoginRequest`, `RegisterRequest`.<br>- موارد API مخصصة لتنسيق الـ JSON: `TaskResource`, `CategoryResource`, `UserResource`.<br>- التحقق من صحة الفئة وتبعيتها للمستخدم الحالي. |
| **3. Auth / Authorization** | **3 / 3** | مكتمل ✅ | - مصادقة الـ API عبر `Laravel Sanctum` (`Bearer Token`).<br>- مسارات مصادقة كاملة: `register`, `login`, `logout`, `me`.<br>- سياسات الأمان: `TaskPolicy` و `CategoryPolicy` لمنع التعديل أو القراءة لغير المالك والرد برمز `403 Forbidden`. |
| **4. CRUD Implementation** | **3 / 3** | مكتمل ✅ | - عمليات CRUD متكاملة للمهام والفئات.<br>- الفلترة عبر المعاملات: `GET /api/tasks?status=completed` و `GET /api/tasks?category_id=X`.<br>- البحث النصي: `GET /api/tasks?search=keyword`.<br>- الترقيم التلقائي الموحد (Pagination): 10 مهام لكل صفحة مع روابط الميتا.<br>- **Bonus:** نقطة إكمال المهمة المباشرة `PATCH /api/tasks/{task}/complete`. |
| **5. Feature Tests** | **5 / 5** | مكتمل ✅ | جناح اختبارات آلية عبر Pest يغطي كافة متطلبات التحقق الـ 12 المطلوبة بالترتيب:<br>✓ list, create, show, update, delete.<br>✓ 401 unauthenticated, 403 forbidden, 404 not found, 422 unprocessable.<br>✓ Database assertions (`assertDatabaseHas`, `assertDatabaseMissing`).<br>✓ Filtering by status and category, Search, Pagination.<br>✓ 54 اختبار ناجح بنسبة 100% (149 تأكيداً). |
| **6. Code Quality / Naming** | **2 / 2** | مكتمل ✅ | - الالتزام الصارم بتسميات Laravel ومبادئ Clean Code.<br>- فصل الاهتمامات بين الـ Controller والـ Policy والـ Request والـ Resource.<br>- استخدام Type Hinting و Modern PHP 8.4 syntax. |
| **7. README / Run Instructions** | **1 / 1** | مكتمل ✅ | - توثيق كامل باللغة العربية مع جداول الـ Endpoints وكيفية التثبيت والتشغيل.<br>- تضمين مجموعة Postman الجاهزة للاستيراد: `postman/Task-Manager-API.postman_collection.json`.<br>- تضمين ملف عميل REST المباشر: `examples/http/task-api.http`. |
| **المجموع النهائي** | **20 / 20** | **مكتمل بالكامل 💯** | **تم استيفاء كافة المعايير الهندسية والأكاديمية المطلوبة.** |

---

## 🧪 التحقق الآلي من الاختبارات (Pest Suite)

```bash
php artisan test
```

```text
Tests:    54 passed (149 assertions)
Duration: 3.82s
```
