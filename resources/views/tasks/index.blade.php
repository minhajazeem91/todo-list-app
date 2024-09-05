<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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
    </style>

</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4" style="text-align: center" ;>Todo-list-App</h1>

        {{-- Display success message --}}
        @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
        @endif

        {{-- Task creation form --}}
        <div class="spacing-bottom">
            <form action="{{ route('tasks.store') }}" method="POST" class="input-group mb-4">
                @csrf
                <div class="form-group me-2" style="flex: 1;">
                    <input type="text" name="title" class="form-control custom-input" placeholder="New Task" required>
                </div>
                <div class="form-group" style="flex: 0 0 200px;"> {{-- Set fixed width for the datetime input --}}
                    <input type="datetime-local" name="deadline" class="form-control custom-input" placeholder="Deadline" required>
                </div>
                <button type="submit" class="btn btn-primary ms-2" style="border-radius: 5px; padding: 10px 15px;">Add Task</button>
            </form>
        </div>
        {{-- List of tasks --}}
        <ul class="list-group">
            @foreach($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center"
                style="background-color: #f8f9fa; border: 2px solid #ccc; border-radius: 10px; margin-bottom: 10px; padding: 20px;">
                <div>
                    {{-- Checkbox form for marking task as completed --}}
                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" name="completed" id="task-{{ $task->id }}" {{ $task->completed ? 'checked' : '' }} onChange="this.form.submit()" class="form-check-input me-2">
                    </form>
                    {{-- Task title --}}
                    <span class="fw-bold">{{ $task->title }}</span>
                </div>

                <div class="d-flex align-items-center">
                    <!-- {{-- Task created date --}}
                    <small class="text-muted me-3">
                        <b>{{ $task->created_at->format('Y-m-d H:i') }}</b>
                    </small> -->

                    {{-- Task deadline --}}
                    <small class="me-3">
                        @php
                        $deadline = $task->deadline ? $task->deadline->setTimezone('Asia/Karachi') : null;
                        @endphp
                        @if($deadline && $deadline->isPast() && !$task->completed)
                        <span class="text-danger"><b>Deadline: {{ $deadline->format('Y-m-d H:i') }} (Deadline Passed)</b></span>
                        @elseif($deadline && $deadline->isToday() && !$task->completed)
                        <span class="text-warning"><b>Deadline: {{ $deadline->format('Y-m-d H:i') }} (Deadline Today)</b></span>
                        @elseif($deadline)
                        <span class="text-muted"><b>Deadline: {{ $deadline->format('Y-m-d H:i') }}</b></span>
                        @endif
                    </small>

                    {{-- Dynamic Task status --}}
                    @if($task->completed)
                    @if($task->deadline && $task->completed_at && $task->completed_at->lte($task->deadline))
                    <span class="badge bg-success me-3">Completed on time</span>
                    @else
                    <span class="badge bg-info me-3">Completed</span>
                    @endif
                    @else
                    <span class="badge bg-warning text-dark me-3">In Progress</span>
                    @endif

                    {{-- Edit icon --}}
                    <a href="{{ route('tasks.edit', $task) }}" class="icon-button me-2">
                        <i class="fas fa-edit text-warning"></i>
                    </a>

                    {{-- Delete icon --}}
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="icon-button">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>


        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Task pagination">
                <ul class="pagination">
                    {{-- Pagination links --}}
                    {{ $tasks->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
                </ul>
            </nav>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#success-message').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>

</html>