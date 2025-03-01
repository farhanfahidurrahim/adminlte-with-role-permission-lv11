<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background: #f4f4f4;
        }
        .image {
            text-align: center;
            margin-top: 10px;
        }
        .status {
            font-weight: bold;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status.published {
            background: green;
        }
        .status.draft {
            background: red;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title">Post Details</div>

    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $data->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $data->name }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $data->date }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $data->category->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Created By</th>
            <td>{{ $data->createdBy->name ?? 'Unknown' }}</td>
        </tr>
        <tr>
            <th>Updated By</th>
            <td>{{ $data->updatedBy->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="status {{ $data->status }}">{{ ucfirst($data->status) }}</span>
            </td>
        </tr>
    </table>
</div>
