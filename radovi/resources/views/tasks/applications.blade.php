<x-app-layout>
    <h2 class="text-2xl font-bold mb-4">{{ $task->title }}</h2>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    <table class="border-collapse border border-gray-300 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-2 py-1">{{ __('Student Name') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Email') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Priority') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Status') }}</th>
                <th class="border border-gray-300 px-2 py-1">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td class="border border-gray-300 px-2 py-1">{{ $student->name }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $student->email }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $student->pivot->priority }}</td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $student->pivot->accepted ? __('Accepted') : __('Pending') }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        @if(!$student->pivot->accepted && $student->pivot->priority == 1)
                        <form action="{{ route('tasks.acceptStudent', [$task->id, $student->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-2 py-1">{{ __('Accept') }}</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
