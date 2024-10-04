<!-- resources/views/admin/roles-permissions.blade.php -->

<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Gestion des rôles et permissions</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif



    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">Utilisateurs</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                    aria-controls="dashboard" aria-selected="false">Attribuer un rôle</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                    aria-controls="settings" aria-selected="false">Révoquer un rôle</button>
            </li>
            <li role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                    aria-controls="contacts" aria-selected="false">Contacts</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="profile" role="tabpanel"
            aria-labelledby="profile-tab">
            <table class="table-auto w-full bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 rounded shadow-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Rôles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @foreach ($user->roles as $role)
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded">{{ $role->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="dashboard" role="tabpanel"
            aria-labelledby="dashboard-tab">
            <form action="{{ route('admin.roles.assign') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-200">Utilisateur</label>
                    <select name="user_id" id="user_id" class="form-input mt-1 block w-full">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-200">Rôle</label>
                    <select name="role" id="role" class="form-input mt-1 block w-full">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Attribuer le rôle</button>
                </div>
            </form>
        </div>
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="settings" role="tabpanel"
            aria-labelledby="settings-tab">
            <form action="{{ route('admin.roles.revoke') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="user_id_revoke" class="block text-sm font-medium text-gray-200">Utilisateur</label>
                    <select name="user_id" id="user_id_revoke" class="form-input mt-1 block w-full">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="role_revoke" class="block text-sm font-medium text-gray-200">Rôle</label>
                    <select name="role" id="role_revoke" class="form-input mt-1 block w-full">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Révoquer le rôle</button>
                </div>
            </form>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
            aria-labelledby="contacts-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                    class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>.
                Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                classes to control the content visibility and styling.</p>
        </div>
    </div>

</x-app-layout>
