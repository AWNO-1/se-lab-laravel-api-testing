# سجل استخدام الذكاء الاصطناعي — AI Usage Log
# مشروع: واجهات برمجة التطبيقات من الصفر إلى الاختبار (Laravel API: From Zero to Testing)

> **المقرر:** هندسة البرمجيات — الجانب العملي (2026/2027)  
> **المشروع:** نظام إدارة المهام والتصنيفات عبر REST API مع مصادقة Sanctum واختبارات Pest  
> **إشراف:** م. ساهر القائد (الهمداني)  
> **الهدف:** توثيق الاستعانة بأدوات الذكاء الاصطناعي بشفافية كأداة هندسية مساعدة في بناء الـ API والاختبارات الآلية.

---

## Entry 01

### Date
2026-09-19

### Student
AWMO-1 (فريق العمل الهندسي)

### Tool
Antigravity AI / Gemini 3.8 Flash

### Purpose
استشارة الذكاء الاصطناعي في تنظيم مسارات الـ REST API في Laravel 13، وتهيئة مصادقة Sanctum، وتطبيق معمارية Form Requests و API Resources و Policies، وصياغة اختبارات Pest Feature Tests تغطي الـ 12 حالة فحص المطلوبة في دليل الأستاذ بما فيها حالات الفلترة والبحث وحماية الموارد المتعددة (Multi-tenant ownership).

### Prompt Summary
طلبنا مراجعة المعايير القياسية لتصميم الـ API وفق معايير REST (حالات 200, 201, 204, 401, 403, 404, 422)، وكيفية ربط جدول `categories` بنموذج المهام `tasks` وفحص منع المستخدم من إسناد مهمة إلى تصنيف يملكه مستخدم آخر في قاعدة البيانات عبر قواعد التحقق `Rule::exists('categories', 'id')->where(...)`.

### AI Suggestions
1. **المصادقة:** استخدام `Laravel\Sanctum\HasApiTokens` لإصدار رموز وصول Bearer Tokens وإلغائها عند تسجيل الخروج.
2. **التحقق والصلاحيات:** استخدام `Rule::exists` داخل `StoreTaskRequest` لضمان أن `category_id` ينتمي إلى `auth()->id()`.
3. **التحدي الإضافي (Bonus):** إنشاء نقطة نهاية مخصصة `PATCH /api/tasks/{task}/complete` محمية بالسياسة `TaskPolicy::complete`.
4. **الاختبارات:** كتابة 3 ملفات اختبارات (`TaskApiTest`, `CategoryApiTest`, `AuthApiTest`) لتغطية كافة الحالات.
5. **اقتراح مكتبات خارجية:** اقتراح استخدام GraphQL أو حزم التوثيق التلقائية مثل Swagger/Scribe.

### Accepted Suggestions
- قبول معمارية الـ REST القياسية باستخدام Form Requests و Resources و Policies.
- قبول التحقق من ملكية الفئة مباشرة في الـ Form Request لمنع الوصول غير المصرح به.
- قبول كتابة اختبارات Pest الـ 54 الشاملة لتغطية كل الحالات والـ Edge Cases.
- قبول ميزة الـ Bonus `PATCH /api/tasks/{task}/complete`.

### Rejected Suggestions
- **استخدام GraphQL أو Swagger:** تم الرفض التام للالتزام بتعليمات الأستاذ الصريحة في دليل المعمل (التركيز على RESTful API النقية واختبارات Pest الآلية دون حزم توثيق زائدة).

### Reason for Rejection
الحفاظ على بساطة المعمارية والالتزام بمخرجات معمل الأستاذ المحددة.

### Human Review
قام الطالب بتشغيل الاختبارات الآلية بالكامل عبر `php artisan test`، والتأكد من اجتياز جميع الفحوصات الـ 54 (149 تأكيداً / Assertions) بنسبة 100%، وتجربة المسارات عبر ملف Postman وملف الـ HTTP.
