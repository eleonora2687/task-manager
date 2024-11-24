<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Notifications\TaskAddedNotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    
    
    /**
     * Show the form to create a new task.
     */
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('tasks.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validate the status before updating the task
        $status = $request->status;
        if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
            return redirect()->route('tasks.create')->with('error', 'Invalid status value.');
        }

        DB::table('tasks')
            ->where('id', 113)
            ->update(['status' => 'in_progress']);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today|before_or_equal:2100-12-31',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        if (empty($request->description)) {
            return redirect()
                ->back()
                ->with('warning', 'Task created successfully, but the description is missing!');
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully!');
        }

    public function show($id)
        {
            $task = Task::findOrFail($id);
            return view('tasks.detail', compact('task'));
        }

        public function index(Request $request)
        {
            $search = $request->input('search');
            $sortBy = $request->input('sortBy', 'random'); // Default sorting by random if not specified
        
            // Retrieve tasks with search and sorting functionality
            $tasks = Task::when($search, function ($query, $search) {
                                return $query->where('title', 'like', "%{$search}%")
                                             ->orWhere('description', 'like', "%{$search}%");
                            })
                            ->when($sortBy == 'category', function ($query) {
                                return $query->join('categories', 'tasks.category_id', '=', 'categories.id')
                                             ->orderBy('categories.name', 'asc');
                            })
                            ->when($sortBy == 'priority', function ($query) {
                                return $query->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low')");
                            })
                            ->when($sortBy == 'title', function ($query) {
                                return $query->orderBy('title', 'asc'); // Sort by title
                            })
                            ->when($sortBy == 'due_date', function ($query) {
                                return $query->orderBy('due_date', 'asc'); // Sort by due date (nearest first)
                            })
                            ->when($sortBy == 'random', function ($query) {
                                return $query->inRandomOrder(); // Default random order
                            })
                            ->select('tasks.*')
                            ->paginate(20);
        
            // Return JSON response if AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'tasks' => view('tasks.partials.task_rows', compact('tasks'))->render(),
                    'paginationInfo' => 'Showing ' . $tasks->firstItem() . '-' . $tasks->lastItem() . ' of ' . $tasks->total() . ' results',
                    'paginationLinks' => $tasks->appends([
                        'search' => $request->search,
                        'sortBy' => $request->sortBy,
                    ])->links('pagination::bootstrap-4')->render() // Ensure you're using the correct pagination style
                ]);
            }
        
            return view('tasks.index', compact('tasks', 'search', 'sortBy'));
        }
        
                              

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        // Capture the current page number from the request
        $page = $request->input('page', 1);

        // Redirect back to the current page with any necessary query parameters
        return redirect()->route('tasks.index', [
            'page' => $page,
            'search' => $request->input('search'),
            'sortBy' => $request->input('sortBy'),
        ])->with('success', 'Task deleted successfully!');
    }


    public function edit(Task $task)
    {
        $categories = Category::all(); // Get all categories

        // No need for the check `if (!$task)` because Task::findOrFail does this automatically.

        return view('tasks.edit', compact('task', 'categories'));
    }


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today|before_or_equal:2100-12-31',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Update the task with valid status
        
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
        $task->status = $request->input('status');
        $task->category_id = $request->input('category_id'); 

        $task->save(); 

        if (empty($request->description)) {
            return redirect()
                ->back()
                ->with('warning', 'Task updated successfully, but the description is missing!');
        }

    return redirect()
        ->back()
        ->with('success', 'Task updated successfully!');}
    

    public function analytics()
    {
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();

        $tasksByCategory = Task::selectRaw('category_id, COUNT(*) as count')
                            ->groupBy('category_id')
                            ->with('category') // Ensure categories are loaded
                            ->get();

        return view('analytics.index', compact('totalTasks', 'completedTasks', 'pendingTasks','inProgressTasks', 'tasksByCategory'));
    }

   

}
