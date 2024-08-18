@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('contents')
<header>
    <div class="container mt-4 py-6 sm:px-6 lg:px-8">
        <div class="row px-2 py-6 sm:px-0">
            <div class="col">
                <h5>Tasks</h5>
            </div>
        </div>
        <div class="container mt-3 py-6 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>
    </div>
</header>
<main class="mt-4">
    <div class="container py-6 sm:px-6 lg:px-8">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Deadline</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    @if ($task->count() > 0)
                    @foreach ($task as $data)
                    <tr>
                        <td>{{$data->task_title}}</td>
                        <td>{{$data->description}}</td>
                        <td>{{date('h:i A - F j, Y', strtotime($data->deadline))}}</td>
                        <td>
                            <div class="container">
                                <div class="row">
                                    <div class="col text-center">
                                        <!-- View Button -->
                                        <button type="button" class="btn btn-success view-btn" style="font-size: 0.7rem" data-bs-toggle="modal" data-bs-target="#studentViewModal" data-id="{{ $data->id }}" data-title="{{ $data->task_title }}" data-description="{{ $data->description }}" data-date="{{ $data->date }}" data-deadline="{{ $data->deadline }}" >View</button>

                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning edit-btn" style="font-size: 0.7rem" data-bs-toggle="modal" data-bs-target="#studentEditModal" data-id="{{ $data->id }}" data-title="{{ $data->task_title }}" data-description="{{ $data->description }}" data-deadline="{{ $data->deadline }}">Edit</button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.delete', $data->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.7rem" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</main>
<section class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-body">
                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <div class="mb-3">
                    <label for="task">Task Title</label>
                    <input type="text" name="task" class="form-control" id="edit-task" />
                </div>
                <div class="mb-3">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" id="edit-deadline" />
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="4" id="edit-description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Task</button>
            </div>
        </form>            
        </div>
    </div>
</section>
<section class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
            <div class="modal-body">
                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <div class="mb-3">
                    <label for="task">Date</label>
                    <input type="text" name="date" class="form-control" id="view-date" readonly/>
                </div>
                <div class="mb-3">
                    <label for="task">Task Title</label>
                    <input type="text" name="task" class="form-control" id="view-task" readonly/>
                </div>
                <div class="mb-3">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" id="view-deadline" readonly/>
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="4" id="view-description" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(function(button) {

            button.addEventListener('click', function() {
                var taskDate = this.getAttribute('data-date');
                var taskId = this.getAttribute('data-id');
                var taskTitle = this.getAttribute('data-title');
                var taskDescription = this.getAttribute('data-description');
                var taskDeadline = this.getAttribute('data-deadline');

                 // Format the taskDeadline to the desired format
                var date = new Date(taskDate);
                var options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
                var formattedDate_date = date.toLocaleString('en-US', options);

                document.getElementById('view-date').value = formattedDate_date;
                document.getElementById('view-task').value = taskTitle;
                document.getElementById('view-description').value = taskDescription;
                document.getElementById('view-deadline').value = taskDeadline;
            });
        });

        var editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var taskId = this.getAttribute('data-id');
                var taskTitle = this.getAttribute('data-title');
                var taskDescription = this.getAttribute('data-description');
                var taskDeadline = this.getAttribute('data-deadline');

                var route = '{{ route("admin.edit", ":id") }}';
                route = route.replace(':id', taskId);

                // Set the form action
                var editForm = document.querySelector('#studentEditModal form');
                editForm.setAttribute('action', route);

                document.getElementById('edit-id').value = taskId;
                document.getElementById('edit-task').value = taskTitle;
                document.getElementById('edit-description').value = taskDescription;
                document.getElementById('edit-deadline').value = taskDeadline;
            });
        });
    });
</script>
@endsection