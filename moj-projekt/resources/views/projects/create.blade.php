<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Novi projekt</h2>
    </x-slot>

    <div class="py-6">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div>
                <label>Naziv projekta</label>
                <input type="text" name="naziv_projekta" required>
            </div>
            <div>
                <label>Opis projekta</label>
                <textarea name="opis_projekta"></textarea>
            </div>
            <div>
                <label>Cijena projekta</label>
                <input type="number" step="0.01" name="cijena_projekta">
            </div>
            <div>
                <label>Datum početka</label>
                <input type="date" name="datum_pocetka">
            </div>
            <div>
                <label>Datum završetka</label>
                <input type="date" name="datum_zavrsetka">
            </div>
            <h4>Dodaj članove tima</h4>
            <select name="members[]" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2">Spremi</button>
        </form>
    </div>
</x-app-layout>
