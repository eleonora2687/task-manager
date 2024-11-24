@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container details-container bg-light rounded shadow-sm p-4">
        <h1 class="text-center mb-4">Task Details</h1>
        <ul class="list-group">
            <li class="list-group-item"><strong>Title:</strong> {{ $task->title }}</li>
            <li class="list-group-item"><strong>Description:</strong> {{ $task->description }}</li>
            <li class="list-group-item"><strong>Priority:</strong> {{ ucfirst($task->priority) }}</li>
            <li class="list-group-item"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('F d, Y') }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($task->status) }}</li>
            <li class="list-group-item"><strong>Category:</strong> {{ $task->category ? $task->category->name : 'Uncategorized' }}</li>
        </ul>
    </div>
@endsection
