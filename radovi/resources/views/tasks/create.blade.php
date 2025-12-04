<x-app-layout>
    <h2 class="text-2xl font-bold mb-4">{{ __('Add a new Task') }}</h2>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>{{ __('Title (HR)') }}</label>
            <input type="text" name="title" class="border p-1 w-full" value="{{ old('title') }}">
            @error('title') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
            <label>{{ __('Title (EN)') }}</label>
            <input type="text" name="title_en" class="border p-1 w-full" value="{{ old('title_en') }}">
            @error('title_en') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
            <label>{{ __('Description') }}</label>
            <textarea name="description" class="border p-1 w-full">{{ old('description') }}</textarea>
            @error('description') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="mb-2">
            <label>{{ __('Study Type') }}</label>
            <select name="study_type" class="border p-1 w-full">
                <option value="stručni">{{ __('messages.study_types.stručni') }}</option>
                <option value="preddiplomski">{{ __('messages.study_types.preddiplomski') }}</option>
                <option value="diplomski">{{ __('messages.study_types.diplomski') }}</option>
            </select>

            @error('study_type') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">{{ __('Add Task') }}</button>
    </form>
</x-app-layout>
