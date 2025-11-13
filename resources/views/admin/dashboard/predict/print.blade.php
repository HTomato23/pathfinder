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
                <th>Student ID</th>
                <th>Details</th>
                <th>Program</th>
                <th>Year Level</th>
                <th>Employability</th>
                <th>Employability Probability</th>
                <th>Predicted Employment Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->student_id}}</td>
                    <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                    <td>{{ $client->program }}</td>
                    <td>{{ $client->year_level }}</td>
                    <td>{{ $client->employability ?? 'N/A'}}</td>
                    <td>{{ $client->employability_probability ?? 'N/A'}}</td>
                    <td>{{ $client->predicted_employment_rate ?? 'N/A'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
