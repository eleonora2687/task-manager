@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1>Analytics Dashboard</h1>
    </div>

    <div class="row mt-4">
        <!-- Total Tasks -->
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Tasks</h5>
                    <p class="card-text">{{ $totalTasks }}</p>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Completed Tasks</h5>
                    <p class="card-text">{{ $completedTasks }} ({{ number_format(($completedTasks / $totalTasks) * 100, 2) }}%)</p>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending Tasks</h5>
                    <p class="card-text">{{ $pendingTasks }} ({{ number_format(($pendingTasks / $totalTasks) * 100, 2) }}%)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- In Progress Tasks -->
    <div class="row mt-4">
        <!-- In Progress Tasks -->
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">In Progress Tasks</h5>
                    <p class="card-text">{{ $inProgressTasks }} ({{ number_format(($inProgressTasks / $totalTasks) * 100, 2) }}%)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks by Category -->
    <div class="mt-5">
        <h3>Tasks by Category</h3>
        <ul>
            @foreach($tasksByCategory as $task)
                <li>
                    {{ $task->category->name }}: {{ $task->count }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
