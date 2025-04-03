// const { error } = require("laravel-mix/src/Log");

document.addEventListener("DOMContentLoaded", function(){
    const checkboxes = document.querySelectorAll("input[name='selected_product']");
    
    checkboxes.forEach(checkbox=>{
        checkbox.addEventListener("change", updateSubtotal);
    });
});

function removeProduct(productId){
    //remove product in cart database 
    fetch(`/cart/remove/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(response => response.json())
    .then(data=>{
        if(data.success){
            //remove the product from cart page
            const cartItem = document.querySelector(`.single-product[data-id="${productId}"]`);
            if(cartItem){
                cartItem.remove();
                //update subtotal
                updateSubtotal();
            }
            console.log(data.success);
        }else{
            console.log(data.error);
        }
    })
    .catch(error=>{
        console.error("Error:", error);
    });
}


function updateQuantity(productId, change){
    let cartItem = document.querySelector(`.single-product[data-id="${productId}"]`);
    if(cartItem){
        //update quantity input
        let quantityInput = cartItem.querySelector(".product-quantity-input");
        let currentQuantity = parseInt(quantityInput.value);
        let newQuantity = currentQuantity + change;
        if(newQuantity < 1){
            return;
        }
        quantityInput.value = newQuantity;

        //update total price of the product
        let price = parseFloat(cartItem.querySelector(".price").innerText);
        let total = cartItem.querySelector(".total");
        total.innerText = (price*newQuantity).toFixed(2);
        //update subtotal if the product is selected
        let checkbox = cartItem.querySelector("input[name='selected_product']");
        if(checkbox.checked){
            updateSubtotal();
        }
        
        // update product quantity in database
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ quantity: quantityInput.value })
        })
        .then(response=>{
            if(!response.ok){
                throw new Error("Response was not ok");
            }
            return response.json();
        })
        .then(data=>{
            if(data.success){
                console.log(data.success);
            }else{
                console.log(data.error);
            }
        })
        .catch(error=>{
            console.error("Error:", error);
        })
    }
}


function updateSubtotal(){
    const checkboxes = document.querySelectorAll("input[name='selected_product']");
    const subtotalElement = document.querySelector(".subtotal-amount");
    let subtotal = 0;

    checkboxes.forEach(checkbox=>{
        if(checkbox.checked){
            let product = checkbox.closest(".single-product");
            let total = parseFloat(product.querySelector(".total").innerText);
            subtotal+=total;
        }
    });
    subtotalElement.innerText = subtotal.toFixed(2);
}

function applyVoucher(){
    let voucherInput = document.getElementById("voucher-code").value;
    let deliveryFee = 8;
    if(voucherInput === "freedelivery"){
        deliveryFee = 0;
        document.getElementById("voucher-message").innerText = "Voucher Applied: Free Delivery!";
    }else{
        document.getElementById("voucher-message").innerText = "Invalid Voucher!";
    }

}

