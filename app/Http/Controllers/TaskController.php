<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * عرض قائمة المهام مع ملخص لحالاتها.
     */
    public function index(): View
    {
        $tasks = Task::query()
            ->latest()
            ->paginate(9);

        $tasksCount = Task::query()->count();
        $completedTasksCount = Task::query()->where('is_completed', true)->count();
        $pendingTasksCount = $tasksCount - $completedTasksCount;

        return view('tasks.index', compact(
            'tasks',
            'tasksCount',
            'completedTasksCount',
            'pendingTasksCount',
        ));
    }

    /**
     * عرض نموذج إنشاء مهمة جديدة.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * التحقق من بيانات المهمة الجديدة ثم حفظها.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = Task::query()->create([
            ...$request->safe()->only(['title', 'description']),
            'is_completed' => $request->boolean('is_completed'),
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'تم إنشاء المهمة بنجاح.');
    }

    /**
     * عرض تفاصيل مهمة واحدة عبر ربط النموذج التلقائي.
     */
    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * عرض نموذج تعديل المهمة المحددة.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * التحقق من البيانات الجديدة ثم تحديث المهمة.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update([
            ...$request->safe()->only(['title', 'description']),
            'is_completed' => $request->boolean('is_completed'),
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'تم تحديث المهمة بنجاح.');
    }

    /**
     * حذف المهمة ثم العودة إلى قائمة المهام.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح.');
    }
}
