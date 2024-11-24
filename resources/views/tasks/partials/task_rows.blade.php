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
