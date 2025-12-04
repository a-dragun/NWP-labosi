<x-app-layout>
    <h2 class="text-2xl font-bold mb-4">{{ __('My Tasks') }}</h2>

    <table class="border-collapse border border-gray-300 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-2 py-1">{{ __('Title (HR)') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Title (EN)') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Study Type') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Applications') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td class="border border-gray-300 px-2 py-1">{{ $task->title }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $task->title_en }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ __('study_types.' . $task->study_type) }}</td>
                    <td class="border border-gray-300 px-2 py-1">
                        <a href="{{ route('tasks.applications', $task->id) }}" class="bg-blue-500 text-white px-2 py-1">{{ __('View Applications') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
