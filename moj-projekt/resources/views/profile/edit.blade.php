<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <hr class="my-6">

    <h2 class="text-xl font-semibold mb-2">Projekti gdje ste voditelj:</h2>
    <ul>
        @forelse($ownedProjects as $project)
            <li>{{ $project->naziv_projekta }}</li>
        @empty
            <li>Niste voditelj nijednog projekta.</li>
        @endforelse
    </ul>

    <h2 class="text-xl font-semibold mt-6 mb-2">Projekti gdje ste član:</h2>
    <ul>
        @forelse($memberProjects as $project)
            <li>{{ $project->naziv_projekta }}</li>
        @empty
            <li>Niste član nijednog projekta.</li>
        @endforelse
    </ul>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
