<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Pathfinder | Print Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-outfit p-5">
    <h2 class="text-2xl font-bold mb-4">Admin Table</h2>

    <table class="table w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Admin Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->admin_id }}</td>
                    <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->role }}</td>
                    <td>{{ $admin->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
