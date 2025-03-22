<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('css/pages/cart.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <script src="{{ asset('js/pages/cart.js') }}"></script>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <!--Navbar-->
    <x-header/>
    <!--Product-->
    <section class="cart">
        @for($i=1; $i<=4; $i++)
        <div class="single-product">
            <div class="remove-icon">
                <input type="checkbox" name="selected_product" value="product_id">
                <button type="submit" onclick="removeProduct(this)">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="product-image">
                <img src="{{ asset('images/missDIY.png') }}" alt="product image">
            </div>
            <div class="product-name-price-quantity">
                <div class="product-name">Product Name</div>
                <div class="product-price">RM <span class="price">100.00</span></div>
                <div class="product-quantity">
                    <button type="submit" name="decrement" onclick="decrement(this)">-</button>
                    <input type="text" name="product-quantity" id="product-quantity" value="1" min="1">
                    <button type="submit" name="increment" onclick="increment(this)">+</button>
                </div>
            </div>
            <div class="total-price">
                <p>RM <span class="total">100.00</span></p>
            </div>
        </div>
        @endfor
    </section>

    <section class="fixed-bottom-bar">
        <!--Apply voucher-->
        <div class="voucher">
            <div class="apply-voucher">
                <i class="fa-solid fa-ticket"></i>
                <input type="text" id="voucher-code" placeholder="Enter voucher code">
                <button onclick="applyVoucher()">Apply</button>
            </div>
            <p id="voucher-message"></p>
        </div>

        <div class="subtotal-checkout">
            <!--Subtotal-->
            <div class="subtotal">
                <h3>Subtotal: RM <span class="subtotal-amount">0.00</span></h3>
            </div>
    
            <!--Checkout button-->
            <div class="checkout">
                <button type="button">Checkout</button>
            </div>
        </div>
    </section>
    
</body>
</html>
