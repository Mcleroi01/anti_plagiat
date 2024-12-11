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
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="profile"
            role="tabpanel" aria-labelledby="profile-tab">
            <table
                class="table-auto w-full bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 rounded shadow-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-r">Nom</th>
                        <th class="px-4 py-2 border-r">Email</th>
                        <th class="px-4 py-2 border-r">Rôles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">{{ $user->email }}</td>
                            <td class="px-4 py-2 border">
                                @foreach ($user->roles as $role)
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded">{{ $role->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="dashboard"
            role="tabpanel" aria-labelledby="dashboard-tab">
            <x-assign-roles-table></x-assign-roles-table>
        </div>
        <div class="hidden p-4 rounded-lg bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200" id="settings"
            role="tabpanel" aria-labelledby="settings-tab">
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

    @section('script')
        <script>
            if (document.getElementById("usersRolesTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#usersRolesTable", {
                    searchable: false,
                    sortable: false,
                    pagging: false,
                    perPageSelect: false
                })
            }
        </script>

        <script>
            $(document).ready(function() {
                getUsersRoles();
            });
        </script>

        <script>
            function getUsersRoles() {
                $.ajax({
                    url: "{{ route('roles.users.index') }}",
                    method: "GET",
                    success: function(response) {
                        var users = response.users;
                        var roles = response.roles;
                        var userRoles = response.userRoles;

                        // Create the table header with roles
                        var header = '<tr class="bg-bg-chart"><th style="background-color: #d1d5db;"></th>';
                        roles.forEach(function(role) {
                            header +=
                                '<th class="text-center">' + role.name + '</th>';
                        });
                        header += '</tr>';
                        $('#usersRolesTable thead').html(header);

                        // Create the table body with users and checkboxes
                        var body = '';

                        // Initial rendering of the table
                        users.forEach(function(user) {
                            body +=
                                '<tr><th class="text-md text-start"><a href="#" class="hover:bg-[#] p-2" data-user-id="' +
                                user.id + '" data-user-name="' + user.name + '">' + user.name + '</a></th>';
                            roles.forEach(function(role) {
                                var checked = userRoles[user.id] && userRoles[user.id].includes(role
                                    .id) ? 'checked' : '';
                                body +=
                                    '<td class="text-center"><input type="checkbox" class="user-checkbox" data-role-id="' +
                                    role.id + '" data-user-id="' + user.id +
                                    '" ' + checked + '></td>';
                            });
                            body += '</tr>';
                        });

                        $('#usersRolesTable tbody').html(body);

                        // Attach change event listeners to checkboxes
                        var requestInProgress = false;

                        $('#usersRolesTable').on('change', 'input.user-checkbox', function() {
                            if (requestInProgress) {
                                return;
                            }

                            requestInProgress = true;

                            var roleId = $(this).data('role-id');
                            var userId = $(this).data('user-id');
                            var checked = $(this).is(':checked');
                            // Your existing AJAX logic to update user's roles on the server
                            $.ajax({
                                url: "{{ route('users.roles.update') }}",
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    role_id: roleId,
                                    user_id: userId,
                                    assign: checked
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Succès!',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        background: '#132329', // Fond sombre
                                        color: '#fff', // Couleur du texte blanche
                                        iconColor: '#ffdd57',
                                    });
                                    requestInProgress = false;
                                },
                                error: function(error) {
                                    Swal.fire({
                                        title: 'Erreur!',
                                        text: 'Il y a eu une erreur lors de l\'assignation du rôle.',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        background: '#132329', // Fond sombre
                                        color: '#fff', // Couleur du texte blanche
                                        iconColor: '#ffdd57',
                                    });
                                    requestInProgress = false;
                                }
                            });
                        });
                    },
                    error: function(error) {
                        console.error("There was an error fetching roles and permissions:", error);
                    }
                })
            }
        </script>
    @endsection
</x-app-layout>
