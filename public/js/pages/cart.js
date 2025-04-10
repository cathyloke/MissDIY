// const { error } = require("laravel-mix/src/Log");

document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll("input[name='selected_product']");
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            updateSubtotal();
            // return true; // allow form submission
        });
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
    // const checkboxes = document.querySelectorAll("input[name='selected_product']");
    const checkboxes = document.querySelectorAll('.selected-product:checked');
    const subtotalElement = document.querySelector(".subtotal-amount");
    let subtotal = 0;

    checkboxes.forEach(checkbox => {
        if(checkbox.checked) {
            let product = checkbox.closest(".single-product");
            let total = parseFloat(product.querySelector(".total").innerText);
            subtotal += total;
        }
    });
    // subtotalElement.innerText = subtotal.toFixed(2);
    document.querySelector('.subtotal-amount').textContent = subtotal.toFixed(2);
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

// Select all checkboxes
function selectAll(source) {
    const checkboxes = document.querySelectorAll('.selected-product');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
    updateSubtotal(); // Call the updateSubtotal function
}

document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.selected-product');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSubtotal);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const checkoutForm = document.getElementById('checkout-form');
    
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
            // Remove any previously appended hidden inputs
            document.querySelectorAll('.dynamic-product-input').forEach(el => el.remove());

            const checkedItems = document.querySelectorAll('.selected-product:checked');

            if (checkedItems.length === 0) {
                e.preventDefault();
                alert('Please select at least one item to checkout.');
                return;
            }

            // Add hidden inputs for each selected checkbox
            checkedItems.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_product[]';
                input.value = checkbox.value;
                input.classList.add('dynamic-product-input');
                checkoutForm.appendChild(input);
            });
        });
    }
});

