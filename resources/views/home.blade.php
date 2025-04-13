@extends('layouts.app')

@section('content')
<section class="welcome">
    <div class="welcome-content">
        <h1>Welcome to Miss DIY</h1>
        <p>Your one-stop shop for DIY home projects and tools.</p>
        <a href="#about-us" class="explore-btn">Explore</a>
    </div>
</section>

<!--About us-->
<section class="about-us" id="about-us">
    <div class="about-content">
        <div class="about-text">
            <h2>About Us</h2>
            <p>Miss DIY is dedicated to providing high-quality DIY materials and tools to help you bring your creative ideas to life. Whether you're a beginner or an expert, we have everything you need for your projects.</p>
            <p>Our mission is to inspire creativity and make DIY accessible to everyone. We offer affordable, eco-friendly products with a commitment to quality and customer satisfaction.</p>
        </div>
        <div class="about-image">
            <img src="{{ asset('images/missDIY.png') }}" alt="About Us">
        </div>
    </div>
</section>

<!--Product-->
<section class="featured-products">
    <h2>New Arrivals</h2>
    <div class="product-grid">
        @foreach($newProducts as $product)
        <div class="product">
            <img src="{{ asset('images/'. $product->image) }}" alt="{{ $product->name }}">
            <h3>{{ $product->name }}</h3>
            <p>$ {{ number_format($product->price, 2) }}</p>
        </div>
        @endforeach
    </div>
    <a href={{ route('products.index') }} class="explore-btn">Shop now</a>
</section>
@if (session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif

@endsection
