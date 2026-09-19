<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('tasks.index') }}" class="mb-3 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 transition hover:text-indigo-800">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10.5 19.5-7.5-7.5m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    العودة إلى جميع المهام
                </a>
                <h1 class="text-2xl font-bold text-slate-950 sm:text-3xl">تفاصيل المهمة</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">راجع معلومات المهمة وحالتها وآخر تحديث لها.</p>
            </div>
            <a href="{{ route('tasks.edit', $task) }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-slate-300 transition hover:-translate-y-0.5 hover:bg-indigo-700">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
                تعديل المهمة
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- رسالة نجاح الإنشاء أو التعديل. --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-bold text-emerald-700" role="status">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_280px]">
            {{-- البطاقة الرئيسية لتفاصيل المهمة. --}}
            <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
                <div class="border-b border-slate-100 bg-gradient-to-l from-indigo-50 via-white to-violet-50 p-6 sm:p-8">
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                        <span class="{{ $task->is_completed ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold">
                            <span class="{{ $task->is_completed ? 'bg-emerald-500' : 'bg-amber-500' }} size-2 rounded-full"></span>
                            {{ $task->is_completed ? 'مكتملة' : 'قيد التنفيذ' }}
                        </span>
                        <span class="text-xs font-medium text-slate-400">رقم المهمة #{{ $task->id }}</span>
                    </div>
                    <h2 class="text-2xl font-bold leading-10 text-slate-950 sm:text-3xl">{{ $task->title }}</h2>
                </div>

                <div class="p-6 sm:p-8">
                    <h3 class="text-sm font-bold text-slate-800">وصف المهمة</h3>
                    @if ($task->description)
                        <p class="mt-4 whitespace-pre-line text-sm leading-8 text-slate-600">{{ $task->description }}</p>
                    @else
                        <div class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-sm text-slate-400">
                            لم يُضف وصف لهذه المهمة.
                        </div>
                    @endif
                </div>
            </article>

            {{-- معلومات إضافية وإجراءات المهمة. --}}
            <aside class="space-y-5">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900">معلومات المهمة</h3>
                    <dl class="mt-5 space-y-5">
                        <div>
                            <dt class="text-[11px] font-bold text-slate-400">تاريخ الإنشاء</dt>
                            <dd class="mt-1.5 text-sm font-semibold text-slate-700">
                                <time datetime="{{ $task->created_at->toIso8601String() }}">{{ $task->created_at->format('Y/m/d - H:i') }}</time>
                            </dd>
                        </div>
                        <div class="border-t border-slate-100 pt-5">
                            <dt class="text-[11px] font-bold text-slate-400">آخر تحديث</dt>
                            <dd class="mt-1.5 text-sm font-semibold text-slate-700">
                                <time datetime="{{ $task->updated_at->toIso8601String() }}">{{ $task->updated_at->format('Y/m/d - H:i') }}</time>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-3xl border border-red-100 bg-red-50/70 p-6">
                    <h3 class="text-sm font-bold text-red-800">حذف المهمة</h3>
                    <p class="mt-2 text-xs leading-6 text-red-600">سيُحذف السجل نهائيًا ولا يمكن استعادته بعد ذلك.</p>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="mt-4"
                        onsubmit="return confirm('هل أنت متأكد من حذف هذه المهمة؟ لا يمكن التراجع عن هذا الإجراء.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-xs font-bold text-white transition hover:bg-red-700">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            حذف المهمة
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
