<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Pathfinder | Print Client</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-outfit p-5">
    <h2 class="text-2xl font-bold mb-4">User Table</h2>

    <table class="table w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Admin ID</th>
                <th>Author Name</th>
                <th>Blog Count</th>
                <th>Email</th>
                <th>Facebook</th>
                <th>Instagram</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->admin_admin_id }}</td>
                    <td>{{ $author->first_name }} {{ $author->last_name }}</td>
                    <td>{{ $author->blogs_count }}</td>
                    <td>{{ $author->email }}</td>
                    <td>{{ $author->facebook }}</td>
                    <td>{{ $author->instagram }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
