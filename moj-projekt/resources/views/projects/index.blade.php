<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Moji projekti</h2>
    </x-slot>

    <div class="py-6">
        <a href="{{ route('projects.create') }}">Novi projekt</a>

        <ul>
            @forelse($projects as $project)
                <li class="mb-2">
                    <a href="{{ route('projects.edit', $project) }}" class="text-blue-600">{{ $project->naziv_projekta }}</a>
                    ({{ $project->members->count() }} članova)
                </li>
            @empty
                <br>
                <li>Nema projekata</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
