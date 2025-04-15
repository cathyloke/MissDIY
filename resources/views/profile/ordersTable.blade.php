@if ($orders->isEmpty())
    <p>No {{ $title }} order.</p>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead style="background-color: #98afc7;">
                <tr>
                    <th>Order Date</th>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Net Total</th>
                    <th>Details</th>
                    @if ($showActions)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d M Y, h:i A') }}</td>
                        <td>{{ $order->id }}</td>
                        <td>${{ number_format($order->totalAmount, 2) }}</td>
                        <td>${{ number_format($order->netTotalAmount, 2) }}</td>

                        <td>
                            <button class="btn btn-outline-dark btn-sm" data-bs-toggle="collapse"
                                data-bs-target="#details-{{ $order->id }}" aria-expanded="false"
                                aria-controls="details-{{ $order->id }}">
                                View Details
                            </button>
                        </td>

                        @if ($showActions)
                            <td>
                                <form action="{{ route('sale.delivering', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success btn-sm">Shipped</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                    <tr class="collapse" id="details-{{ $order->id }}">
                        <td colspan="6">
                            <div class="card" style="z-index: 0;">
                                <div class="card-body">
                                    <h5 class="mb-3">Product Details</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Quantity Purchased</th>
                                                <th>Price Per Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->details as $detail)
                                                <tr>
                                                    <td>
                                                        <div class="detail-image-container">
                                                            <img src="{{ asset('images/' . $detail->product->image) }}"
                                                                alt="{{ $detail->product->name }}"
                                                                class="detail-image">
                                                        </div>
                                                    </td>
                                                    <td>{{ $detail->product->name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>${{ number_format($detail->product->price, 2) }}
                                                    </td>
                                                    <td>${{ number_format($detail->quantity * $detail->product->price, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-3">Customer details</h5>
                                    <p>Customer ID: {{ $order->user->id }}</p>
                                    <p>Name: {{ $order->user->name }}</p>
                                    <p>Email: {{ $order->user->email }}</p>
                                    <p>Contact Number: {{ $order->user->contact_number }}</p>
                                    <p>Address: {{ $order->user->address }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
