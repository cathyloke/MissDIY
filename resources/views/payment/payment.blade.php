<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/payment.css') }}" />
</head>

<body>
    <x-header />

    <div class="payment-header">
        <h1>Payment</h1>
    </div>

    @if (session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <section class="payment-page">
        <div class="payment-container">
            <div class="left-section">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    @foreach ($selectedItems as $item)
                        <div class="order-item">
                            <img src="{{ asset('images/' . $item->product->image) }}" alt="Product Image"
                                class="order-image">
                            <div class="order-details">
                                <p>{{ $item->product->name }}</p>
                                <p><strong>Price:</strong> RM {{ number_format($item->product->price, 2) }}</p>
                                <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="right-section">
                <div class="user-address">
                    <h3>Shipping Address</h3>
                    @if ($userAddress)
                        <p>{{ $userAddress }}</p>
                    @else
                        <p>No address found. <a href="{{ route('profile.edit') }}">Edit your address</a> in your
                            profile.</p>
                    @endif
                </div>

                <p class="subtotal">Subtotal: RM <span id="subtotal-amount">{{ number_format($subtotal, 2) }}</span></p>

                <!-- Discount Code Section -->
                <div class="discount-section">
                    <label for="discount_code">Discount Code:</label>
                    <input type="text" name="discount_code" id="discount_code" placeholder="Enter discount code"
                        value="{{ old('discount_code') }}">
                    <button type="button" id="apply_discount" class="apply-discount-btn">Apply</button>
                    
                    <!-- List of applied discounts -->
                    <div id="applied_discounts_list"></div>

                    <p id="discount_message" class="discount-message"></p>
                    <p id="discounted_total" class="discounted-total" style="display:none;">Discounted Total: RM <span
                            id="discounted_amount"></span></p>
                </div>

                <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="payment-section">
                        <div class="payment-method">
                            <label for="payment_method" class="payment-label">Select Payment Method:</label>
                            <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
                                <option value="">-- Choose --</option>
                                <option value="touch_n_go"
                                    {{ old('payment_method') == 'touch_n_go' ? 'selected' : '' }}>Touch 'n Go eWallet
                                </option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                                    Credit/Debit Card</option>
                                <option value="online_banking"
                                    {{ old('payment_method') == 'online_banking' ? 'selected' : '' }}>Online Banking
                                </option>
                            </select>

                            <div class="error-message" id="payment_method_error"></div>
                        </div>

                        {{-- Card Payment --}}
                        <div id="card-fields" style="display:none;">
                            <label for="card_number">Card Number:</label>
                            <input type="text" name="card_number" value="{{ old('card_number') }}">
                            <div class="error-message" id="card_number_error"></div>

                            <label for="cardholder_name">Cardholder Name:</label>
                            <input type="text" name="cardholder_name" value="{{ old('cardholder_name') }}">
                            <div class="error-message" id="cardholder_name_error"></div>

                            <label for="expiry_date">Expiry Date:</label>
                            <input type="text" name="expiry_date" value="{{ old('expiry_date') }}"
                                placeholder="MM/YY">
                            <div class="error-message" id="expiry_date_error"></div>

                            <label for="cvv">CVV:</label>
                            <input type="text" name="cvv" value="{{ old('cvv') }}">
                            <div class="error-message" id="cvv_error"></div>

                        </div>

                        {{-- Online Banking --}}
                        <div id="banking-fields" style="display:none;">
                            <label for="bank_name">Select Bank:</label>
                            <select name="bank_name">
                                <option value="">-- Choose Bank --</option>
                                <option value="maybank" {{ old('bank_name') == 'maybank' ? 'selected' : '' }}>Maybank
                                </option>
                                <option value="cimb" {{ old('bank_name') == 'cimb' ? 'selected' : '' }}>CIMB</option>
                                <option value="rhb" {{ old('bank_name') == 'rhb' ? 'selected' : '' }}>RHB</option>
                                <option value="public_bank" {{ old('bank_name') == 'public_bank' ? 'selected' : '' }}>
                                    Public Bank</option>
                            </select>
                            <div class="error-message" id="bank_name_error"></div>

                            <label for="account_number">Account Number:</label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}">
                            <div class="error-message" id="account_number_error"></div>
                        </div>

                        {{-- Touch n Go --}}
                        <div id="touch-n-go-fields" style="display:none;">
                            <div class="qr-container">
                                <img src="{{ asset('images/TNG_QR.png') }}" class="qr-code" alt="Touch n Go QR code">
                            </div>
                        </div>

                        <button type="submit" class="payment-btn">Proceed to Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function togglePaymentFields() {
            const method = document.getElementById('payment_method').value;
            document.getElementById('card-fields').style.display = (method === 'card') ? 'block' : 'none';
            document.getElementById('banking-fields').style.display = (method === 'online_banking') ? 'block' : 'none';
            document.getElementById('touch-n-go-fields').style.display = (method === 'touch_n_go') ? 'block' : 'none';
        }

        // discount code functionality
        let appliedDiscounts = [];
        let originalSubtotal = 0;

        $(document).ready(function () {
            togglePaymentFields();
            $('#payment_method').on('change', togglePaymentFields);

            // initialize originalSubtotal on page load
            originalSubtotal = parseFloat($('#subtotal-amount').text());
        });

        $('#apply_discount').click(function () {
            let discountCode = $('#discount_code').val().trim();

            if (discountCode) {
                if (appliedDiscounts.includes(discountCode.toUpperCase())) {
                    $('#discount_message').html('This code has already been applied.');
                    return;
                }

                $.ajax({
                    url: "{{ route('payment.apply_discount') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        discount_code: discountCode,
                        subtotal: originalSubtotal, // always send original
                    },
                    success: function (response) {
                        if (response.success) {
                            const discountAmount = parseFloat(response.discountAmount);
                            const upperCode = discountCode.toUpperCase();
                            appliedDiscounts.push(upperCode);

                            $('#applied_discounts_list').append(
                                `<p class="applied-discount-message">Discount applied: -RM ${discountAmount.toFixed(2)} (${upperCode})</p>`
                            );

                            // sum all discounts from the applied discount messages
                            let totalDiscount = 0;
                            $('#applied_discounts_list .applied-discount-message').each(function () {
                                const match = $(this).text().match(/RM ([\d.]+)/);
                                if (match) {
                                    totalDiscount += parseFloat(match[1]);
                                }
                            });

                            const discountedTotal = originalSubtotal - totalDiscount;
                            $('#discounted_amount').html(discountedTotal.toFixed(2));
                            $('#discounted_total').show();

                        } else {
                            $('#discount_message').html('Invalid discount code.');
                            $('#discounted_total').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error applying discount:', error);
                    }
                });

            } else {
                $('#discount_message').html('Please enter a discount code.');
                $('#discounted_total').hide();
            }
        });

        $('#payment-form').submit(function(e) {
            e.preventDefault();

            $('.error-message').html(''); // clear previous errors

            let selectedItems = @json($selectedItems->pluck('id')); // outputs an array of selected item IDs from PHP
            let formData = $(this).serialize() 
                            + '&selected_items=' + JSON.stringify(selectedItems) 
                            + '&discounted_total=' + $('#discounted_amount').text() 
                            + '&discount_code=' + JSON.stringify(appliedDiscounts);

            $.ajax({
                type: 'POST',
                url: "{{ route('payment.process') }}",
                data: formData,
                success: function(response) {
                    alert(response.message);
                    window.location.href = "{{ route('home') }}";
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $('#' + field + '_error').html(errors[field][0]);
                        }
                    } else if (xhr.status === 404) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            $('#' + field + '_error').html(errors[field][0]);
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
