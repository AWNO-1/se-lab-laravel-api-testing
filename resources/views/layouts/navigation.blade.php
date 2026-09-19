<nav x-data="{ open: false }" class="relative z-20 border-b border-white/70 bg-white/85 shadow-sm shadow-slate-200/40 backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            {{-- هوية التطبيق وروابط التنقل الرئيسية. --}}
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3">
                    <span class="flex size-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-200 transition group-hover:-translate-y-0.5">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-slate-900">مساحة المهام</span>
                        <span class="block text-[11px] text-slate-500">نظّم يومك بوضوح</span>
                    </span>
                </a>

                <div class="hidden items-center gap-2 md:flex">
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition">
                        لوحة التحكم
                    </a>
                    <a href="{{ route('tasks.index') }}"
                        class="{{ request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition">
                        المهام
                    </a>
                </div>
            </div>

            {{-- قائمة المستخدم في الشاشات المتوسطة والكبيرة. --}}
            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-slate-300 transition hover:-translate-y-0.5 hover:bg-indigo-700">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    مهمة جديدة
                </a>

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2 text-start transition hover:border-indigo-200 hover:bg-indigo-50/50">
                            <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold text-indigo-700">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <span class="hidden lg:block">
                                <span class="block max-w-32 truncate text-xs font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                                <span class="block max-w-32 truncate text-[10px] text-slate-500">{{ Auth::user()->email }}</span>
                            </span>
                            <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            الملف الشخصي
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                تسجيل الخروج
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- زر القائمة المتجاوبة للهواتف. --}}
            <button @click="open = ! open"
                class="inline-flex size-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 md:hidden"
                type="button" aria-label="فتح قائمة التنقل">
                <svg x-show="! open" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="open" x-cloak class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- قائمة الهاتف. --}}
    <div x-show="open" x-cloak class="border-t border-slate-100 bg-white md:hidden">
        <div class="space-y-2 px-4 py-4">
            <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                لوحة التحكم
            </a>
            <a href="{{ route('tasks.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                المهام
            </a>
            <a href="{{ route('tasks.create') }}" class="block rounded-xl bg-indigo-600 px-4 py-3 text-center text-sm font-semibold text-white">
                إضافة مهمة جديدة
            </a>
        </div>

        <div class="border-t border-slate-100 px-4 py-4">
            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ Auth::user()->email }}</p>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('profile.edit') }}" class="flex-1 rounded-xl bg-slate-100 px-3 py-2 text-center text-xs font-semibold text-slate-700">
                    الملف الشخصي
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-red-50 px-3 py-2 text-xs font-semibold text-red-600">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
