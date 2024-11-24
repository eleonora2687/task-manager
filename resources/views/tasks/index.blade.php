@extends('layouts.app')

@section('content')
<style>
    /* Ensure pagination and result count are horizontally scrollable only on small screens */
    @media (max-width: 768px) {
        .pagination-info-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap;
        }

        .pagination-info-container .pagination {
            display: inline-block;
        }

        .pagination-info-container .page-item {
            display: inline-block;
        }

        /* Stack "Showing x-y of z results" and pagination vertically on small screens */
        .pagination-info-container {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* On larger screens, position the "Showing x-y of z results" and pagination links in a row */
    @media (min-width: 769px) {
        .pagination-info-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }
    }
</style>

<div class="container mt-5">
    <div class="text-center">
        <h1>All Tasks</h1>
    </div>

    <!-- Check if there are any tasks -->
    @if($tasks->isEmpty())
        <div class="alert alert-info">No tasks found.</div>
    @else
    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<form action="{{ route('tasks.index') }}" method="GET" class="mb-3">
    <div class="d-flex flex-column flex-md-row mb-3">
        <!-- Sort By Dropdown -->
        <div class="d-flex mt-2 mt-md-0 ms-md-3 mb-3 mb-md-0">
            <select name="sortBy" class="form-control form-control-md" onchange="this.form.submit()">
                <option value="" disabled selected>-- Sort Tasks By --</option>
                {{-- <option value="random" {{ request('sortBy') == 'random' ? 'selected' : '' }}>Sort Randomly</option> --}}
                <option value="title" {{ request('sortBy') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                <option value="priority" {{ request('sortBy') == 'priority' ? 'selected' : '' }}>Sort by Priority</option>
                <option value="due_date" {{ request('sortBy') == 'due_date' ? 'selected' : '' }}>Sort by Due Date</option>
                <option value="category" {{ request('sortBy') == 'category' ? 'selected' : '' }}>Sort by Category</option>
            </select>
        </div>

        <!-- Search Bar -->
        <div class="d-flex mb-2 mb-md-0 ms-md-3">
            <input type="text" name="search" class="form-control form-control-md" placeholder="Search tasks.." value="{{ request('search') }}">
        </div>
    </div>
</form>

    

        
        <!-- Task table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Category</th>
                        <th>Priority</th> <!-- Add Priority column -->

                        <th class="text-center d-none d-md-table-cell">Actions</th> <!-- Hide on mobile -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->category->name }}</td>
                            <td>{{ $task->priority }}</td>

                            <td class="text-center d-none d-md-table-cell">
                                <!-- Buttons for larger screens -->
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('tasks.detail', $task->id) }}" class="btn btn-info btn-sm w-100">View Details</a>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm w-100">Edit</a>
                                    <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">
                                        <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                    </form>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr class="d-md-none"> <!-- Show only on mobile -->
                            <td colspan="3" class="text-center">
                                <!-- Buttons for mobile screens -->
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('tasks.detail', $task->id) }}" class="btn btn-info btn-sm w-100">View Details</a>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm w-100">Edit</a>
                                    <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="sortBy" value="{{ request('sortBy') }}">
                                        <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                    </form>
                                    
                                    
                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination info and links container -->
        <!-- Pagination info and links container -->
<div class="pagination-info-container mt-3">
    <div class="text-start">
        Showing {{ $tasks->firstItem() }}-{{ $tasks->lastItem() }} of {{ $tasks->total() }} results
    </div>
    <div class="pagination-wrapper">
        {{ $tasks->appends(['search' => request('search'), 'sortBy' => request('sortBy')])->links('pagination::bootstrap-4') }}
    </div>
</div>


<script>
    $(document).ready(function() {
    // When the sort dropdown value changes
    $('#sortBy').change(function() {
        var sortBy = $(this).val();  // Get the selected sort option
        var search = $('input[name="search"]').val();  // Get the search value
        
        // Send an AJAX request to the server to fetch the sorted tasks
        $.ajax({
            url: "{{ route('tasks.index') }}",  // Use the existing index route
            method: "GET",
            data: { 
                sortBy: sortBy,
                search: search,
                page: 1 // Reset to the first page for new search or sort
            },
            success: function(response) {
                // Update the task rows and pagination
                $('tbody').html(response.tasks); // Update only the task rows
                $('.pagination-wrapper').html(response.pagination); // Update pagination
            }
        });
    });

    // When the search input changes
    $('input[name="search"]').on('input', function() {
        var search = $(this).val();  // Get the search value
        var sortBy = $('#sortBy').val();  // Get the selected sort option
        
        // Send an AJAX request to the server to fetch the filtered tasks
        $.ajax({
            url: "{{ route('tasks.index') }}",  // Use the existing index route
            method: "GET",
            data: { 
                search: search,
                sortBy: sortBy,
                page: 1 // Reset to the first page for new search
            },
            success: function(response) {
                // Update the task rows and pagination
                $('tbody').html(response.tasks); // Update only the task rows
                $('.pagination-info-container .text-start').html(response.paginationInfo);
            $('.pagination-wrapper').html(response.paginationLinks); // Update pagination links
            }
        });
    });
});

</script>
        
    @endif
</div>
@endsection
