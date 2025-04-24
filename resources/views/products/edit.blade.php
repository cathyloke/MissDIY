<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('css/pages/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <x-header/>
    
    <!-- Edit Product Form -->
    <div class="edit-product-container">
        <h2>Edit Product</h2>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                @error('quantity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="categoryId" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == old('categoryId', $product->categoryId) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('categoryId')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="available" {{ !$product->trashed() ? 'selected' : '' }}>Available</option>
                    <option value="unavailable" {{ $product->trashed() ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            

            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" id="image" name="image">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-preview">
                @endif
            </div>

            <button type="submit" class="save-btn">Save Changes</button>
        </form>


        <a href="{{ route('products.index') }}" class="back-to-list-btn">Back to Products List</a>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.querySelector('.product-image-preview');

            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>


</body>
</html>
