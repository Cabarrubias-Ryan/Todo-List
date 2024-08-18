@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('contents')
<header>
    <div class="container mt-4 py-6 sm:px-6 lg:px-8">
        <div class="row px-2 py-6 sm:px-0">
            <div class="col">
                <h5>Users</h5>
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
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Task</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    @foreach ($users as $index => $data)
                        @if ($data->role == 'user')
                            <tr>
                                <td>{{ $index + 1}}</td>
                                <td>{{$data->username}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->task_count}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success view-btn" style="font-size: 0.7rem" data-bs-toggle="modal" data-bs-target="#studentViewModal">View</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <section class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')

</script>
@endsection