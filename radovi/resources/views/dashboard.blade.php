<x-app-layout>
    <h2 class="text-2xl font-bold mb-4">{{ __('Dashboard') }}</h2>

    @if(auth()->user()->role === 'nastavnik')
        <div class="mb-2">
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-black px-4 py-2 inline-block mb-2">{{ __('Create Task') }}</a>
        </div>
        <div class="mb-2">
            <a href="{{ route('teacher.tasks') }}" class="bg-green-500 text-black px-4 py-2 inline-block">{{ __('My Tasks') }}</a>
        </div>
    @elseif(auth()->user()->role === 'student')
        <div class="mb-2">
            <a href="{{ route('student.tasks') }}" class="bg-purple-500 text-black px-4 py-2 inline-block">{{ __('Available Tasks') }}</a>
        </div>
    @elseif(auth()->user()->role === 'admin')
        <div class="mb-2">
            <a href="{{ route('admin.dashboard') }}" class="bg-red-500 text-black px-4 py-2 inline-block">{{ __('Admin Dashboard') }}</a>
        </div>
    @endif
</x-app-layout>

