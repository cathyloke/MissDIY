<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Payment</title>
   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
   <x-header />

   <section class="payment-page">
      <h2>Payment</h2>

      <div class="order-summary">
         @foreach ($cartItems as $item)
               <div>
                  {{ $item->productName }} × {{ $item->productQty }} = RM {{ number_format($item->productQty * $item->productPrice, 2) }}
               </div>
         @endforeach
         <strong>Subtotal: RM {{ number_format($subtotal, 2) }}</strong>
      </div>

      <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
         @csrf

         <div>
            <label for="payment_method">Select Payment Method:</label>
            <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
               <option value="">-- Choose --</option>
               <option value="touch_n_go">Touch 'n Go eWallet</option>
               <option value="card">Credit/Debit Card</option>
               <option value="online_banking">Online Banking</option>
            </select>
         </div>

         {{-- Card Payment --}}
         <div id="card-fields" style="display:none;">
            <label>Card Number:</label>
            <input type="text" name="card_number">
            <label>Cardholder Name:</label>
            <input type="text" name="cardholder_name">
         </div>

         {{-- Online Banking --}}
         <div id="banking-fields" style="display:none;">
            <label>Select Bank:</label>
            <select name="bank_name">
                  <option value="">-- Choose Bank --</option>
                  <option value="maybank">Maybank</option>
                  <option value="cimb">Hong Leong Bank</option>
                  <option value="rhb">RHB</option>
                  <option value="public_bank">Public Bank</option>
            </select>
         </div>

         {{-- Touch n Go --}}
         <div id="touch-n-go-fields" style="display:none;">
            <p>A QR code will be shown on the next page for payment.</p>
         </div>

         <button type="submit">Proceed to Pay</button>
      </form>

      <script>
         function togglePaymentFields() {
            const method = document.getElementById('payment_method').value;

            document.getElementById('card-fields').style.display = (method === 'card') ? 'block' : 'none';
            document.getElementById('banking-fields').style.display = (method === 'online_banking') ? 'block' : 'none';
            document.getElementById('touch-n-go-fields').style.display = (method === 'touch_n_go') ? 'block' : 'none';
         }
      </script>

   </section>
</body>
</html>
