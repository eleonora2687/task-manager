<!DOCTYPE html>
<html lang="en">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>
    <script src="{{ asset('js/search.js') }}"></script>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
      .navbar-light .navbar-nav .nav-link {
          color: #f8f9fa; /* Light color for the text */
      }

      .navbar-light .navbar-brand {
          color: #f8f9fa; /* Light color for the brand */
      }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg bg-secondary navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('tasks.index') }}">All Tasks</a>
                <a class="nav-link" href="{{ route('tasks.create') }}">Create Task</a>
                <a class="nav-link" href="{{ route('analytics') }}">Analytics</a>

            </div>
        </div>
    </div>
</nav>

    <!-- Navigation Bar -->
    
    

    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Add Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
