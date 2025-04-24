@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/pages/category.css') }}"/>
<div class="container">
    <h3 class="header-title">Edit Category</h3>
    <h4 class="sub-header">Update the details below</h4>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="input-group mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input type="text" name="name" id="name" class="input-field" value="{{ old('name', $category->name) }}" required>
            <span style="color: red">@error('name'){{ $message }}@enderror</span>
        </div>

        <div class="input-group mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="3" class="input-field">{{ old('description', $category->description) }}</textarea>
            <span style="color: red">@error('description'){{ $message }}@enderror</span>
        </div>

        <button type="submit" class="custom-restore-btn">Update</button>
        <a href="{{ route('categories.index') }}" class="custom-deactivate-btn">Cancel</a>
    </form>
</div>
@endsection
