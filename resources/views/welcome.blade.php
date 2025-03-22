<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | MissDIY</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/pages/welcome.css') }}"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <x-header/>
    <section class="welcome">
        <div class="welcome-content">
            <h1>Welcome to Miss DIY</h1>
            <p>Your one-stop shop for DIY home projects and tools.</p>
            <a href="#about-us" class="btn">Explore</a>
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
        <h2>Featured Products</h2>
        <div class="product-grid">
            <div class="product">
                <img src="images/missDIY.png" alt="Product 1">
                <h3>Wooden Craft Kit</h3>
                <p>RM 15.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="images/missDIY.png" alt="Product 2">
                <h3>DIY Paint Set</h3>
                <p>RM 9.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="images/missDIY.png" alt="Product 3">
                <h3>Tool Organizer</h3>
                <p>RM 12.49</p>
                <button>Add to Cart</button>
            </div>
        </div>
        <a href="/" class="btn">Shop now</a>
    </section>

</body>
</html>