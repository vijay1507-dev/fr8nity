@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <h1>Hello, {{ auth()->user()->name }}!</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 