@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Profile</h1>
    <p>Name: {{ Auth::user()->name }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    
</div>
@endsection