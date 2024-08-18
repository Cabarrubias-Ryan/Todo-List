@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('contents')
<header>
    <div class="container">
        @if (Session::has('success'))
        <div class="card border-0 shadow my-5">
             <div class="card-header bg-light">
                 <h3 class="h5 pt-2">Dashboard</h3>
             </div>
             <div class="card-body">
                <div class="alert alert-success">{{ Session::get('success')}}</div>
             </div>
        </div>
        @endif
        
     </div>
</header>
@endsection
