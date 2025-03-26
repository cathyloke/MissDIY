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
                    class="detail-image">
            </div>

            <!-- Product Info Column -->
            <div class="detail-info">
                <h3 class="detail-name">{{ $product->name }}</h3>

                <h4 class="detail-price">${{ number_format($product->price, 2) }}</h4>

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

                <!-- If CUSTOMER -- > Add To Cart; ADMIN -- > Edit -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" id="formQuantity" value="1">
                    <button type="submit" class="add-to-cart-btn">
                        <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>