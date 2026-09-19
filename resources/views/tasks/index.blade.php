<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-indigo-600">مساحة العمل</p>
                <h1 class="text-2xl font-bold text-slate-950 sm:text-3xl">إدارة المهام</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">تابع تقدم أعمالك واحتفظ بكل التفاصيل في مكان واحد.</p>
            </div>
            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-l from-indigo-600 to-violet-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:shadow-xl">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                إضافة مهمة
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- رسالة نجاح العملية السابقة. --}}
        @if (session('success'))
            <div class="mb-8 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm" role="status">
                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-bold">تمت العملية بنجاح</p>
                    <p class="mt-1 text-xs text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- بطاقات الإحصاءات السريعة. --}}
        <section class="mb-10 grid gap-4 sm:grid-cols-3" aria-label="إحصاءات المهام">
            <div class="rounded-3xl border border-white bg-white/90 p-5 shadow-sm shadow-slate-200/70">
                <div class="flex items-center justify-between">
                    <span class="flex size-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="text-3xl font-bold text-slate-950">{{ $tasksCount }}</span>
                </div>
                <p class="mt-4 text-sm font-bold text-slate-700">إجمالي المهام</p>
                <p class="mt-1 text-xs text-slate-400">جميع المهام المسجلة</p>
            </div>

            <div class="rounded-3xl border border-white bg-white/90 p-5 shadow-sm shadow-slate-200/70">
                <div class="flex items-center justify-between">
                    <span class="flex size-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="text-3xl font-bold text-slate-950">{{ $pendingTasksCount }}</span>
                </div>
                <p class="mt-4 text-sm font-bold text-slate-700">قيد التنفيذ</p>
                <p class="mt-1 text-xs text-slate-400">مهام تحتاج إلى المتابعة</p>
            </div>

            <div class="rounded-3xl border border-white bg-white/90 p-5 shadow-sm shadow-slate-200/70">
                <div class="flex items-center justify-between">
                    <span class="flex size-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12.75 2.25 2.25 4.5-6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="text-3xl font-bold text-slate-950">{{ $completedTasksCount }}</span>
                </div>
                <p class="mt-4 text-sm font-bold text-slate-700">المهام المكتملة</p>
                <p class="mt-1 text-xs text-slate-400">أعمال أُنجزت بنجاح</p>
            </div>
        </section>

        {{-- شبكة بطاقات المهام. --}}
        @if ($tasks->isNotEmpty())
            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3" aria-label="قائمة المهام">
                @foreach ($tasks as $task)
                    <article class="group flex min-h-72 flex-col rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-100/70">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <span class="{{ $task->is_completed ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/10' : 'bg-amber-50 text-amber-700 ring-amber-600/10' }} inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-[11px] font-bold ring-1 ring-inset">
                                <span class="{{ $task->is_completed ? 'bg-emerald-500' : 'bg-amber-500' }} size-1.5 rounded-full"></span>
                                {{ $task->is_completed ? 'مكتملة' : 'قيد التنفيذ' }}
                            </span>
                            <time datetime="{{ $task->created_at->toDateString() }}" class="text-[11px] font-medium text-slate-400">
                                {{ $task->created_at->format('Y/m/d') }}
                            </time>
                        </div>

                        <div class="flex-1">
                            <a href="{{ route('tasks.show', $task) }}" class="block">
                                <h2 class="text-lg font-bold leading-8 text-slate-900 transition group-hover:text-indigo-700">{{ $task->title }}</h2>
                            </a>
                            <p class="mt-3 text-sm leading-7 text-slate-500">
                                {{ $task->description ? \Illuminate\Support\Str::limit($task->description, 125) : 'لا يوجد وصف مضاف لهذه المهمة.' }}
                            </p>
                        </div>

                        <div class="mt-6 flex items-center gap-2 border-t border-slate-100 pt-4">
                            <a href="{{ route('tasks.show', $task) }}"
                                class="flex-1 rounded-xl bg-indigo-50 px-3 py-2.5 text-center text-xs font-bold text-indigo-700 transition hover:bg-indigo-100">
                                عرض التفاصيل
                            </a>
                            <a href="{{ route('tasks.edit', $task) }}"
                                class="rounded-xl bg-slate-100 p-2.5 text-slate-600 transition hover:bg-slate-200 hover:text-slate-900"
                                aria-label="تعديل المهمة">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                </svg>
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذه المهمة؟ لا يمكن التراجع عن هذا الإجراء.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-xl bg-red-50 p-2.5 text-red-500 transition hover:bg-red-100 hover:text-red-700"
                                    aria-label="حذف المهمة">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </section>

            <div class="mt-8">
                {{ $tasks->links() }}
            </div>
        @else
            {{-- الحالة الفارغة تظهر عندما لا توجد أي مهام. --}}
            <section class="rounded-3xl border border-dashed border-slate-300 bg-white/80 px-6 py-16 text-center">
                <span class="mx-auto flex size-16 items-center justify-center rounded-3xl bg-indigo-50 text-indigo-600">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3.75 18.75V7.5A2.25 2.25 0 0 1 6 5.25h12a2.25 2.25 0 0 1 2.25 2.25v11.25M3.75 18.75A2.25 2.25 0 0 0 6 21h12a2.25 2.25 0 0 0 2.25-2.25M3.75 18.75v-7.5A2.25 2.25 0 0 1 6 9h12a2.25 2.25 0 0 1 2.25 2.25v7.5" />
                    </svg>
                </span>
                <h2 class="mt-5 text-xl font-bold text-slate-900">لا توجد مهام حتى الآن</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500">ابدأ بإضافة أول مهمة، ثم تابع حالتها وتفاصيلها من هذه الصفحة.</p>
                <a href="{{ route('tasks.create') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-indigo-700">
                    إضافة أول مهمة
                </a>
            </section>
        @endif
    </div>
</x-app-layout>
