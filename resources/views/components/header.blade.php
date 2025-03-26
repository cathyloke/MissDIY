<div class="topnav">
    <div class="topnav-left">
        <a href="/"><img src="{{ asset('images/missDIY.png') }}" class="logo"> <span class="title">Miss DIY</span> </a>
    </div>
    <div class="topnav-right">
        <a href="/">Home</a>
        <div class="dropdown">
            <a href="{{ route('products.index') }}" class="dropbtn">
                Products <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-content">
                <a href="{{ route('products.index') }}">All Categories</a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['categoryId' => $category->id]) }}">{{ $category->name }} </a>
                @endforeach
            </div>
        </div>
        <a href="">Orders</a>
        <a href="cart"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href=""><i class="fa-solid fa-user"></i></a>
        <a href=""><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
    </div>
</div>