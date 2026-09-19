<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-indigo-600">مرحبًا {{ Auth::user()->name }}</p>
            <h1 class="text-2xl font-bold text-slate-950 sm:text-3xl">لوحة التحكم</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">ابدأ يومك بوضوح وحوّل خططك إلى مهام قابلة للإنجاز.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <section class="relative overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-12 text-white shadow-2xl shadow-slate-300 sm:px-10 lg:px-14">
            <div class="absolute -left-16 -top-24 size-72 rounded-full bg-indigo-600/30 blur-3xl"></div>
            <div class="absolute -bottom-32 right-0 size-80 rounded-full bg-violet-600/20 blur-3xl"></div>

            <div class="relative max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold text-indigo-200 ring-1 ring-white/10">
                    مساحة عملك اليومية
                </span>
                <h2 class="mt-6 text-3xl font-bold leading-[1.6] sm:text-4xl">كل مهمة واضحة تقرّبك خطوة من هدفك.</h2>
                <p class="mt-4 max-w-xl text-sm leading-8 text-slate-300">أنشئ مهامك، أضف التفاصيل المهمة، وتابع حالة الإنجاز من واجهة واحدة سهلة وسريعة.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('tasks.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-slate-900 transition hover:-translate-y-0.5 hover:bg-indigo-50">
                        عرض جميع المهام
                    </a>
                    <a href="{{ route('tasks.create') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-indigo-500">
                        إنشاء مهمة جديدة
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
