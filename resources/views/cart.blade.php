<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('css/pages/cart.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/pages/cart.js') }}"></script>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>

<body>
    <!--Navbar-->
    <x-header />
    <!--Product-->
    <section class="cart">
        @foreach ($cartItems as $cartItem)
            <div class="single-product" data-id="{{ $cartItem->id }}">
                <div class="checkbox">
                    <input type="checkbox" name="selected_product" value="$cartItem->id">
                    <button type="submit" class="remove-icon" onclick="removeProduct('{{ $cartItem->id }}')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

                <div class="product-image">
                    <img src="{{ asset('images/' . $cartItem->productImg) }}" alt="product image">
                </div>
                <div class="product-name-price-quantity">
                    <div class="product-name">{{ $cartItem->productName }} </div>
                    <div class="product-price">RM <span
                            class="price">{{ number_format($cartItem->productPrice, 2) }}</span></div>
                    <div class="product-quantity">
                        <button type="button" name="decrement"
                            onclick="updateQuantity('{{ $cartItem->id }}', -1)">-</button>
                        <input type="text" name="product-quantity" id="product-quantity-{{ $cartItem->id }}"
                            class="product-quantity-input" value="{{ $cartItem->product_qty }}" min="1">
                        <button type="button" name="increment"
                            onclick="updateQuantity('{{ $cartItem->id }}', 1)">+</button>
                    </div>
                </div>
                <div class="total-price">
                    <p>RM <span class="total">{{ number_format($cartItem->productPrice * $cartItem->productQty, 2) }}
                        </span></p>
                </div>
            </div>
        @endforeach
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
                <h3>Subtotal: RM <span class="subtotal-amount">{{ session('subtotal') ?? 0.00 }}</span></h3>
            </div>

            <!--Checkout button-->
            <form action="{{ route('payment.index') }}" method="GET">
                @csrf
                <button type="submit" class="checkout">Checkout</button>
            </form>
        </div>
    </section>

</body>

</html>
