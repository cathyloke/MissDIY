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
                        <img src="{{ asset('images/' . $item->productImg) }}" alt="Product Image" class="order-image">
                        <div class="order-details">
                              <p>{{ $item->productName }}</p>
                              <p><strong>Price:</strong> RM {{ number_format($item->productPrice, 2) }}</p>
                              <p><strong>Quantity:</strong> {{ $item->productQty }}</p>
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
                     <p>No address found. <a href="{{ route('profile.edit') }}">Edit your address</a> in your profile.</p>
                  @endif
            </div>

            <p class="subtotal">Subtotal: RM {{ number_format($subtotal, 2) }}</p>

            <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                  @csrf

                  <div class="payment-section">
                     <div class="payment-method">
                        <label for="payment_method" class="payment-label">Select Payment Method:</label>
                        <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
                              <option value="">-- Choose --</option>
                              <option value="touch_n_go" {{ old('payment_method') == 'touch_n_go' ? 'selected' : '' }}>Touch 'n Go eWallet</option>
                              <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                              <option value="online_banking" {{ old('payment_method') == 'online_banking' ? 'selected' : '' }}>Online Banking</option>
                        </select>

                        @error('payment_method')
                              <div class="error-message">{{ $message }}</div>
                        @enderror
                     </div>

                     {{-- Card Payment --}}
                     <div id="card-fields" style="display:none;">
                        <label for="card_number">Card Number:</label>
                        <input type="text" name="card_number" value="{{ old('card_number') }}">
                        @error('card_number')
                              <div class="error-message">{{ $message }}</div>
                        @enderror

                        <label for="cardholder_name">Cardholder Name:</label>
                        <input type="text" name="cardholder_name" value="{{ old('cardholder_name') }}">
                        @error('cardholder_name')
                              <div class="error-message">{{ $message }}</div>
                        @enderror

                        <label for="expiry_date">Expiry Date:</label>
                        <input type="text" name="expiry_date" value="{{ old('expiry_date') }}" placeholder="MM/YY">
                        @error('expiry_date')
                              <div class="error-message">{{ $message }}</div>
                        @enderror

                        <label for="cvv">CVV:</label>
                        <input type="text" name="cvv" value="{{ old('cvv') }}">
                        @error('cvv')
                              <div class="error-message">{{ $message }}</div>
                        @enderror
                     </div>

                     {{-- Online Banking --}}
                     <div id="banking-fields" style="display:none;">
                        <label for="bank_name">Select Bank:</label>
                        <select name="bank_name">
                              <option value="">-- Choose Bank --</option>
                              <option value="maybank" {{ old('bank_name') == 'maybank' ? 'selected' : '' }}>Maybank</option>
                              <option value="cimb" {{ old('bank_name') == 'cimb' ? 'selected' : '' }}>CIMB</option>
                              <option value="rhb" {{ old('bank_name') == 'rhb' ? 'selected' : '' }}>RHB</option>
                              <option value="public_bank" {{ old('bank_name') == 'public_bank' ? 'selected' : '' }}>Public Bank</option>
                        </select>
                        @error('bank_name')
                              <div class="error-message">{{ $message }}</div>
                        @enderror

                        <label for="account_number">Account Number:</label>
                        <input type="text" name="account_number" value="{{ old('account_number') }}">
                        @error('account_number')
                              <div class="error-message">{{ $message }}</div>
                        @enderror
                     </div>

                     {{-- Touch n Go --}}
                     <div id="touch-n-go-fields" style="display:none;">
                        <!-- No fields for Touch n Go -->
                     </div>

                     <button type="submit" class="payment-btn">Proceed to Pay</button>
                  </div>
            </form>
         </div>
      </div>
   </section>

   <script>
      function togglePaymentFields() {
         const method = document.getElementById('payment_method').value;

         document.getElementById('card-fields').style.display = (method === 'card') ? 'block' : 'none';
         document.getElementById('banking-fields').style.display = (method === 'online_banking') ? 'block' : 'none';
         document.getElementById('touch-n-go-fields').style.display = (method === 'touch_n_go') ? 'block' : 'none';
      }
   </script>
   
</body>
</html>
