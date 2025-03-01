<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2>Posts Export</h2>
<table>
    <thead>
    <tr>
        <th>SL</th>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Category</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Updated By</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->date }}</td>
            <td>{{ $item->category->name }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->createdBy->name }}</td>
            <td>{{ $item->updatedBy ? $item->updatedBy->name : 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
