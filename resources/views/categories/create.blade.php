@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="header-title">Create New Category</h3>
    <h4 class="sub-header">Fill in the details below</h4>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="input-group mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input type="text" name="name" id="name" class="input-field" value="{{ old('name') }}" required>
            <span style="color: red">@error('name'){{ $message }}@enderror</span>
        </div>

        <div class="input-group mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="3" class="input-field">{{ old('description') }}</textarea>
            <span style="color: red">@error('description'){{ $message }}@enderror</span>
        </div>

        <button type="submit" class="btn btn-restore">Create</button>
        <a href="{{ route('categories.index') }}" class="btn btn-deactivate">Cancel</a>
    </form>
</div>
@endsection
