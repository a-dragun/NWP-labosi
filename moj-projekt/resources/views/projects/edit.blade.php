<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Uredi projekt</h2>
    </x-slot>

    <div class="py-6">
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label>Naziv projekta</label>
                <input type="text" name="naziv_projekta" value="{{ $project->naziv_projekta }}" @if(auth()->id() != $project->user_id) readonly @endif>
            </div>

            <div>
                <label>Opis projekta</label>
                <textarea name="opis_projekta" @if(auth()->id() != $project->user_id) readonly @endif>{{ $project->opis_projekta }}</textarea>
            </div>

            <div>
                <label>Cijena projekta</label>
                <input type="number" step="0.01" name="cijena_projekta" value="{{ $project->cijena_projekta }}" @if(auth()->id() != $project->user_id) readonly @endif>
            </div>

            <div>
                <label>Obavljeni poslovi</label>
                <textarea name="obavljeni_poslovi">{{ $project->obavljeni_poslovi }}</textarea>
            </div>

            <div>
                <label>Datum početka</label>
                <input type="date" name="datum_pocetka" value="{{ $project->datum_pocetka }}" @if(auth()->id() != $project->user_id) readonly @endif>
            </div>

            <div>
                <label>Datum završetka</label>
                <input type="date" name="datum_zavrsetka" value="{{ $project->datum_zavrsetka }}" @if(auth()->id() != $project->user_id) readonly @endif>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2">Spremi</button>
        </form>

        @if(auth()->id() == $project->user_id)
            <hr class="my-4">
            <h3 class="font-semibold mb-2">Dodaj člana tima</h3>
            <form action="{{ route('projects.addMember', $project) }}" method="POST">
                @csrf
                <select name="user_id">
                    @foreach($users as $user)
                        @if(!$project->members->contains($user->id))
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Dodaj</button>
            </form>

            <h4 class="mt-4 font-semibold">Članovi tima:</h4>
            <ul class="list-disc ml-5">
                @foreach($project->members as $member)
                    <li>{{ $member->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
