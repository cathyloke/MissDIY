@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/pages/orders.css') }}">

    <div class="container mt-5">
        <h3 class="mb-4">My Orders</h3>

        @if (Auth::user()->isCustomer())
            @if ($orders->isEmpty())
                <div class="alert alert-info">
                    You have not placed any orders yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead style="background-color: #98afc7;">
                            <tr>
                                <th>Order Date</th>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Net Total</th>
                                <th>Status</th>
                                <th>Details</th>
                                @if (Auth::user()->isCustomer())
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
                                        <span
                                            class="badge bg-{{ $order->status == 'completed'
                                                ? 'success'
                                                : ($order->status == 'pending'
                                                    ? 'warning'
                                                    : ($order->status == 'delivering'
                                                        ? 'info'
                                                        : ($order->status == 'returned'
                                                            ? 'secondary'
                                                            : 'danger'))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-light btn-sm" data-bs-toggle="collapse"
                                            data-bs-target="#details-{{ $order->id }}" aria-expanded="false"
                                            aria-controls="details-{{ $order->id }}">
                                            View Details
                                        </button>
                                    </td>

                                    @can('update', $order)
                                        <td>
                                            @if (Auth::user()->isCustomer() && $order->status == 'delivering')
                                                <form action="{{ route('sale.complete', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-light btn-sm">Received</button>
                                                </form>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                                <tr class="collapse" id="details-{{ $order->id }}">
                                    <td colspan="6">
                                        <div class="card">
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
                                                                <td>${{ number_format($detail->product->price, 2) }}</td>
                                                                <td>${{ number_format($detail->quantity * $detail->product->price, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @else
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Pending
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('profile.ordersTable', [
                                'title' => 'pending',
                                'orders' => $pendingOrders,
                                'showActions' => Auth::user()->isAdmin(),
                            ])
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Delivering
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('profile.ordersTable', [
                                'title' => 'delivering',
                                'orders' => $deliveringOrders,
                                'showActions' => false,
                            ])
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Completed
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('profile.ordersTable', [
                                'title' => 'completed',
                                'orders' => $completedOrders,
                                'showActions' => false,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

