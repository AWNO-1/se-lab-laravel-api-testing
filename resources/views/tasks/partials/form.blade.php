{{-- نموذج مشترك بين صفحتي الإنشاء والتعديل لتجنب تكرار الحقول. --}}
<form action="{{ $action }}" method="POST" class="space-y-7">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4" role="alert">
            <div class="flex items-start gap-3">
                <span class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-0.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-bold text-red-800">يرجى مراجعة البيانات المدخلة</p>
                    <p class="mt-1 text-xs leading-6 text-red-600">صحّح الحقول الموضحة أدناه ثم أعد المحاولة.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- عنوان المهمة. --}}
    <div>
        <label for="title" class="mb-2 block text-sm font-bold text-slate-800">
            عنوان المهمة
            <span class="text-red-500">*</span>
        </label>
        <input id="title" name="title" type="text" maxlength="255" required autofocus
            value="{{ old('title', $task?->title) }}"
            placeholder="مثال: إعداد عرض المشروع النهائي"
            class="block w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500">
        @error('title')
            <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600">
                <span class="size-1.5 rounded-full bg-red-500"></span>
                {{ $message }}
            </p>
        @else
            <p class="mt-2 text-xs leading-5 text-slate-500">اختر عنوانًا واضحًا ومختصرًا من 3 إلى 255 حرفًا.</p>
        @enderror
    </div>

    {{-- وصف المهمة. --}}
    <div>
        <div class="mb-2 flex items-center justify-between gap-3">
            <label for="description" class="block text-sm font-bold text-slate-800">وصف المهمة</label>
            <span class="text-[11px] font-medium text-slate-400">اختياري · حتى 1000 حرف</span>
        </div>
        <textarea id="description" name="description" rows="7" maxlength="1000"
            placeholder="اكتب التفاصيل والخطوات أو الملاحظات المرتبطة بالمهمة..."
            class="block w-full resize-y rounded-2xl border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-7 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500">{{ old('description', $task?->description) }}</textarea>
        @error('description')
            <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600">
                <span class="size-1.5 rounded-full bg-red-500"></span>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- حالة الإنجاز ترسل قيمة صريحة حتى عند إلغاء التحديد. --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
        <input type="hidden" name="is_completed" value="0">
        <label for="is_completed" class="flex cursor-pointer items-start gap-3">
            <input id="is_completed" name="is_completed" type="checkbox" value="1"
                @checked(old('is_completed', $task?->is_completed ?? false))
                class="mt-1 size-5 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <span>
                <span class="block text-sm font-bold text-slate-800">تم إنجاز المهمة</span>
                <span class="mt-1 block text-xs leading-5 text-slate-500">فعّل هذا الخيار إذا كانت المهمة مكتملة بالفعل.</span>
            </span>
        </label>
        @error('is_completed')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- أزرار تنفيذ النموذج والعودة. --}}
    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
        <a href="{{ $cancelUrl }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
            إلغاء
        </a>
        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-l from-indigo-600 to-violet-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75 10.5 18l9-13.5" />
            </svg>
            {{ $submitLabel }}
        </button>
    </div>
</form>
