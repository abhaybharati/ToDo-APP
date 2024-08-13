<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
    

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {

       var baseUrl = window.location.origin; 
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
    function showMessage(type, message) {
        const messageBox = $('#message');
        messageBox.removeClass('d-none alert-success alert-danger').addClass('alert-' + type).text(message);
        setTimeout(() => {
            messageBox.addClass('d-none');
        }, 3000);
    }

    // Add Task
    $('#createNewTask').click(function () {
        $('#taskForm').trigger("reset");
        $('#modelHeading').html("Create New Task");
        $('#ajaxModal').modal('show');
        $('#task_id').val('');
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('todos.store') }}",
            type: "POST",
            data: $('#taskForm').serialize(),
            success: function (response) {
                $('#ajaxModal').modal('hide');
                showMessage('success', 'Task added successfully.');
                loadTasks(); 
            },
            error: function (xhr) {
                showMessage('danger', xhr.responseText);
            }
        });
    });

    // Load tasks into the table
    function loadTasks() {
    $.ajax({
        type: "GET",
        url: "{{ route('todos.index') }}",
        success: function (response) {
            $('tbody').html('');
            $.each(response.todo, function (key, item) {

                let todoRow = `
                <tr data-id="${item.id}"data-name="${item.name}">
                  
                    <td class="text-capitalize">${item.name}</td>
                    <td>
                        <i role="button" class="fa fa-trash text-danger delete-todo"></i>
                        </td>
                        <td>
                            <input type="checkbox" class="task-checkbox" ${item.completed ? 'checked' : ''}>
                        </td>
                </tr>`;
            $('tbody').append(todoRow);
            });
        }
    });
}


    // Mark Task as Completed
    $(document).on('change', '.task-checkbox', function () {
        let todos_id = $(this).closest('tr').data('id');
        let name = $(this).closest('tr').data('name').toUpperCase();

        $.ajax({
            url: `/todos/${todos_id}`,
            type: "PATCH",
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                showMessage('success', `${name} status updated.`);
                loadTasks();
            }
        });
    });

    // Delete Task
    $('body').on('click', '.delete-todo', function () {

var todos_id = $(this).closest('tr').data('id');

// confirm before delete task data
var confirmation = confirm("Are you sure you want to remove this task from the list?");
let name = $(this).closest('tr').data('name').toUpperCase();
if(confirmation){

    $.ajax({
        type: "DELETE",
        url: baseUrl + '/todos/' +todos_id,
        success: function (data) {
            loadTasks();
            showMessage('danger', `${name} is deleted from the task list`);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}else{
    showMessage('success', `${name} is safe in the task list`);
}
});
loadTasks();
});

</script>