<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('tasks.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 transition hover:text-indigo-800">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10.5 19.5-7.5-7.5m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    العودة إلى المهام
                </a>
                <h1 class="text-2xl font-bold text-slate-950 sm:text-3xl">إنشاء مهمة جديدة</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">أضف عنوانًا واضحًا وتفاصيل تساعدك على إنجاز المهمة.</p>
            </div>
            <span class="hidden size-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 sm:flex">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </span>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_260px]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8">
                @include('tasks.partials.form', [
                    'task' => null,
                    'action' => route('tasks.store'),
                    'method' => 'POST',
                    'submitLabel' => 'إنشاء المهمة',
                    'cancelUrl' => route('tasks.index'),
                ])
            </div>

            <aside class="h-fit rounded-3xl bg-slate-900 p-6 text-white shadow-xl shadow-slate-300">
                <span class="flex size-11 items-center justify-center rounded-2xl bg-white/10 text-indigo-300">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 18.75a6 6 0 0 0 6-6c0-1.657-.672-3.157-1.757-4.243A6 6 0 1 0 12 18.75Zm0 0v2.25m-3 0h6" />
                    </svg>
                </span>
                <h2 class="mt-5 text-base font-bold">نصيحة لتنظيم أفضل</h2>
                <p class="mt-3 text-xs leading-7 text-slate-300">اكتب عنوانًا يصف النتيجة المطلوبة، ثم أضف في الوصف الخطوات أو الموعد أو أي ملاحظات مهمة.</p>
            </aside>
        </div>
    </div>
</x-app-layout>
