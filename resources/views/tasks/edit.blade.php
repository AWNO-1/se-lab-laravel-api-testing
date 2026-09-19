<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('tasks.show', $task) }}" class="mb-3 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 transition hover:text-indigo-800">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10.5 19.5-7.5-7.5m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    العودة إلى تفاصيل المهمة
                </a>
                <h1 class="text-2xl font-bold text-slate-950 sm:text-3xl">تعديل المهمة</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">حدّث التفاصيل أو غيّر حالة الإنجاز ثم احفظ التعديلات.</p>
            </div>
            <span class="hidden size-14 items-center justify-center rounded-2xl bg-violet-50 text-violet-600 sm:flex">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
            </span>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8">
            @include('tasks.partials.form', [
                'task' => $task,
                'action' => route('tasks.update', $task),
                'method' => 'PUT',
                'submitLabel' => 'حفظ التعديلات',
                'cancelUrl' => route('tasks.show', $task),
            ])
        </div>
    </div>
</x-app-layout>
