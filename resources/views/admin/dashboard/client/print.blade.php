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
                <th>Client Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
