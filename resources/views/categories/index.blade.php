<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="{{ asset('css/pages/category.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <x-header />

    <div>
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="header-title">Category List</h3>
                <h4 class="section-title">Edit the category here</h4>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-restore">
                <i class="fas fa-plus mr-1"></i> Create Category
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allCategories as $category)
                <tr class="@if($category->trashed()) bg-gray-100 @endif">
                    <td class="px-6 py-4">{{ $category->name }}</td>
                    <td class="px-6 py-4">
                        @if($category->trashed())
                            <div class="status-deactivated">Deactivated</div>
                        @else
                            <div class="status-active">Active</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($category->trashed())
                            <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-restore">
                                    <i class="fas fa-undo mr-1"></i> Restore
                                </button>
                            </form>
                        @else
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('categories.deactivate', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-deactivate"
                                    onclick="return confirm('Deactivate this category?')">
                                    <i class="fas fa-ban mr-1"></i> Deactivate
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>