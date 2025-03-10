<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/app.css"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <!--Navbar-->

    <!--Product-->
    <section class="cart">
        <div class="single-product">
            <div class="remove-icon">
                <button type="submit">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
            <div class="product-image">
                <img src="public\favicon.ico" alt="product image">
            </div>
            <div class="product-name-price-quantity">
                <div class="product-name">Product Name</div>
                <div class="product-price">RM 100.00</div>
                <div class="product-quantity">
                    <button type="submit" name="decrement" onclick="decrement">-</button>
                    <input type="text" name="product-quantity" value="2" min="1">
                    <button type="submit" name="increment" onclick="increment">+</button>
                </div>
            </div>
            <div class="total-price">
                <p>RM 200.00</p>
            </div>
        </div>
    </section>

    <!--Apply voucher-->

    <!--Subtotal-->

    <!--Checkout button-->

</body>
</html>

<style>
    .single-product{
        display: flex;
        flex-direction: row;
        border: 1px solid black;
    }

    .single-product .remove-icon{
        display: flex;
        align-items: center;
        margin: 15px;
    }

    .single-product .remove-icon button{
        background-color: transparent;
        border: none;
    }

    .single-product .product-image{
        display: flex;
        align-items: center;
        justify-items: center;
        margin: 15px;
    }

    .single-product .product-image img{
        width: 150px;
        height: 150px;
    }

    .single-product .product-name-price-quantity{
        display: flex;
        flex-direction: column;
        margin: 15px;
        gap: 15px;
    }

    .single-product .product-name-price-quantity .product-name{
        font-size: 18px;
        font-weight: 600;
        margin-top: 15px;
    }

    .single-product .product-name-price-quantity .product-price{
        font-size: 15px;
        font-weight: 500;
    }

    .single-product .product-name-price-quantity .product-quantity{
        display: flex;
        flex-direction: row;
        margin-top: 25px;
    }

    .single-product .total-price{
        margin: 15px;
        padding-top: 90px; 
        text-align: center;
    }

</style>