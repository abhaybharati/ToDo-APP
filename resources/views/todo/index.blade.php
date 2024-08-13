@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for To-Do List -->
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('To-Do List') }}</div>

                <div class="card-body">
                    <!-- Success or Error Message -->
                    <div id="message" class="alert d-none"></div>

                    <!-- Button to add a new task -->
                    <button class="btn btn-success mb-3 bg-dark text-white" id="createNewTask">Add Task</button>

                    <!-- Table to display tasks -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Actions</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody id="tasksTable">
                            <!-- The data will be populated here using JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Task Form -->
<div class="modal fade" id="ajaxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taskForm" name="taskForm" class="form-horizontal">
                    <input type="hidden" name="task_id" id="task_id">
                    
                    <div class="form-group">
                        <label for="task" class="col-sm-2 control-label">Task</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="task" name="name" placeholder="Enter Task" value="" maxlength="255" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-dark" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
