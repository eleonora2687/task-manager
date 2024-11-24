@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1>Create a New Task</h1>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    


    <!-- Task creation form -->
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
>

        </div>
        
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" id="priority" class="form-select">
                <option value="low" selected>Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="pending" selected>Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select a Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Create Task</button>
    </form>
</div>
@endsection
