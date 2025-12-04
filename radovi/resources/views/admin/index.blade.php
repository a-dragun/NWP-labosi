<x-app-layout>
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>

    <table class="table-auto w-full">
        <thead>
            <tr class="border-b">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Ime</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Uloga</th>
                <th class="px-4 py-2">Promjena uloge</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->role }}</td>
                <td class="px-4 py-2">
                    <form action="{{ route('admin.updateRole', $user) }}" method="POST">
                        @csrf
                        <select name="role" class="border rounded px-2 py-1">
                            <option value="admin" @selected($user->role=='admin')>Admin</option>
                            <option value="nastavnik" @selected($user->role=='nastavnik')>Nastavnik</option>
                            <option value="student" @selected($user->role=='student')>Student</option>
                        </select>
                        <button class="bg-blue-500 text-black px-3 py-1 rounded ml-2">Spremi</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
