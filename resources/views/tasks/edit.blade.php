@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
    <h1>Edit Task</h1></div>

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif




    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
                        <input 
                type="date" 
                id="due_date" 
                name="due_date" 
                min="{{ now()->toDateString() }}" 
                max="2100-12-31" 
                required 
                class="form-control modern-date-picker" 
                title="Select a due date"
                value="{{ old('due_date', $task->due_date) }}"
            >

        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" id="priority" class="form-select">
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select a Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ isset($task) && $task->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Add margin below the button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    
    </form>
    
</div>
@endsection
