<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .custom-input {
            border: none;
            border-bottom: 2px solid #007bff;
            border-radius: 0;
            padding: 10px 0;
            box-shadow: none;
            transition: border-bottom 0.3s ease;
            appearance: none;
        }

        .custom-input:focus {
            outline: none;
            border-bottom: 3px solid #0056b3;
            box-shadow: none;
        }

        input[type="text"],
        input[type="datetime-local"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: transparent;
        }

        .spacing-bottom {
            margin-bottom: 60px;
        }

        .btn-custom {
            border-radius: 5px;
            padding: 10px 15px;
        }

        .list-group-item {
            border-radius: 15px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .icon-button {
            border: none;
            background: none;
            cursor: pointer;
        }

        .fas {
            font-size: 1.25rem;
        }

        .list-group-item:hover {
            background-color: #f9f9f9;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <h1>Edit Task</h1>

        {{-- Display validation errors --}}
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Edit task form --}}
        <div class="form-container">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="title" class="form-label">Task Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">Task Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control"
                        value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>