<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة المهام</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">قائمة المهام</h2>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($tasks->isEmpty())
            <p>لا توجد مهام مضافة حالياً.</p>
        @else
            <ul class="list-group mt-4">
                @foreach ($tasks as $task)
                    <li class="list-group-item">{{ $task->title }} - {{ $task->description }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
