@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/pages/cart.css') }}" />
<script src="{{ asset('js/pages/cart.js') }}"></script>

@section('content')
    @if (session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <!--Product-->
    @if ($cartItems->isEmpty())
        <div class="empty-cart">
            <h2>Your cart is empty!</h2>
            <p>Looks like you haven't added anything to your cart yet.</p>
            <p>Start <a href="{{ route('products.index') }}">shopping</a> now!</p>
        </div>
    @else
        <section class="cart">
            <!-- Select all checkbox -->
            <div class="checkbox">
                <input type="checkbox" id="select-all" onchange="selectAll(this)">
                <label for="select-all">Select all</label>
            </div>

            @foreach ($cartItems as $cartItem)
                <div class="single-product {{ $cartItem->product->trashed() || $cartItem->product->quantity <= 0 ? 'unavailable' : '' }}"
                    data-id="{{ $cartItem->id }}">
                    <div class="checkbox">
                        <input type="checkbox" class="selected-product" value="{{ $cartItem->id }}"
                            {{ $cartItem->product->quantity <= 0 ? 'disabled' : '' }}>
                        <button type="submit" class="remove-icon" onclick="removeProduct('{{ $cartItem->id }}')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>

                    <div class="product-image">
                        <img src="{{ asset('images/' . $cartItem->product->image) }}" alt="product image">
                    </div>
                    <div class="product-name-price-quantity">
                        <div class="product-name">{{ $cartItem->product->name }} </div>
                        <div class="product-price">RM <span
                                class="price">{{ number_format($cartItem->product->price, 2) }}</span></div>

                        <div class="available-stock">Available stock: <span>{{ $cartItem->product->quantity }}</span></div>
                        @if ($cartItem->product->trashed() || $cartItem->product->quantity <= 0)
                            <p class="unavailable-message">This product is unavailable.</p>
                        @else
                            <div class="product-quantity">
                                <button type="button" name="decrement"
                                    onclick="updateQuantity('{{ $cartItem->id }}', -1)">-</button>
                                <input type="text" name="product-quantity" id="product-quantity-{{ $cartItem->id }}"
                                    class="product-quantity-input" value="{{ $cartItem->quantity }}" min="1"
                                    data-available="{{ $cartItem->product->quantity }}"
                                    onChange="setQuantityFromInput('{{ $cartItem->id }}')" />

                                <button type="button" name="increment"
                                    onclick="updateQuantity('{{ $cartItem->id }}', 1)">+</button>
                                <span class="error">
                                    {{ $errors->first("product-quantity.{$cartItem->id}") }}
                                </span>
                            </div>
                        @endif

                    </div>
                    <div class="total-price">
                        <p>RM <span class="total">{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}
                            </span></p>
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    <section class="fixed-bottom-bar">

        <div class="subtotal-checkout">
            <!--Subtotal-->
            <div class="subtotal">
                <h3>Subtotal: RM <span class="subtotal-amount">{{ session('subtotal') ?? 0.0 }}</span></h3>
            </div>

            <!-- Checkout Form -->
            <form id="checkout-form" action="{{ route('payment.index') }}" method="GET">
                @csrf
                <button type="submit" class="checkout">Checkout</button>
            </form>
        </div>
    </section>

    <div id="errorToast" class="toast position-fixed top-0 start-50 translate-middle-x" role="alert" aria-live="assertive"
        aria-atomic="true" style="z-index: 1000; margin-top: 50px; background-color:#FFD1DC; display: none;">
        <div class="d-flex">
            <div class="toast-body" id="errorToastBody"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                onclick="document.getElementById('errorToast').style.display='none'"></button>
        </div>
    </div>

@endsection
