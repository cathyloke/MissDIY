<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/pages/product.css') }}"/>  
</head>
<body>
    <div class="product-details">
        <button class="close-btn" onclick="closeModal()">&times;</button>
        <div class="modal-grid">
            <!-- Product Image Column -->
            <div class="detail-image-container">
                <img src="{{ asset('images/' . $product->image) }}" 
                    alt="{{ $product->name }}" 
                    class="p-detail-image">
            </div>

            <!-- Product Info Column -->
            <div class="detail-info">
                <h3 class="detail-name">{{ $product->name }}</h3>

                <h4 class="detail-price">${{ number_format($product->price, 2) }}</h4>

                <h4 class="detail-stock">Available stock: {{$product->quantity}}</h4>
                <!-- Note from RL: if want it to be ajax (no need reload every time), can use javascript function in the add to cart button to call fetch api -->
                <form action="{{ route('cart.add', ['productId'=> $product->id]) }}" method="POST" class="add-to-cart-form">
                    @csrf
                <!-- Note from RL: can add a validation for max quantity to add to cart -->
                @cannot('isAdmin')   
                    <div class="quantity-selector">
                        <label class="quantity-label">Quantity:</label>
                        <div class="quantity-controls">
                            <input type="number" 
                                name="quantity" 
                                value="1" 
                                min="1" 
                                class="quantity-input"
                                id="quantityInput">
                        </div>
                    </div>
                
                    <button type="submit" class="add-to-cart-btn">
                        <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                    </button>
                @endcan 
                    
                @can('isAdmin')
                    <a href="{{ route('products.edit', $product->id) }}" class="add-to-cart-btn">
                        <i class="fas fa-edit mr-2"></i>Edit Product
                    </a>
                @endcan                 

                </form>
            </div>
        </div>
    </div>    

</body>
</html>