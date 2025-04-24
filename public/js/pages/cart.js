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
            
            // Check if cart is now empty
            const remainingItems = document.querySelectorAll('.single-product');
            if (remainingItems.length === 0) {
                location.reload();
            }
        }else{
            console.log(data.error);
        }
    })
    .catch(error=>{
        console.error("Error:", error);
    });
}

function setQuantityFromInput(productId) {
    console.log('setquantity')
    let cartItem = document.querySelector(`.single-product[data-id="${productId}"]`);
    if (cartItem) {
        let quantityInput = cartItem.querySelector(".product-quantity-input");
        let input = parseInt(quantityInput.value);
        let availableQuantity = parseInt(quantityInput.dataset.available);

        // ✅ Prevent update if it exceeds stock
        if (input > availableQuantity) {
            showToast("Quantity exceeds available stock!");
            input = 1;
        } else if (input < 1 || isNaN(input)) {
            input = 1;
        }

        quantityInput.value = input;

        // Update total price
        let price = parseFloat(cartItem.querySelector(".price").innerText);
        let total = cartItem.querySelector(".total");
        total.innerText = (price * input).toFixed(2);

        // Update subtotal
        updateSubtotal();

        // Send update to backend
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ quantity: input })
        })
        .then(response => {
            if (!response.ok) throw new Error("Response was not ok");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log(data.success);
            } else {
                showToast(data.error);
                quantityInput.value = 1; // fallback reset
            }
        })
        .catch(error => {
            showToast("Something went wrong while updating quantity.");
        });
    }
}

function updateQuantity(productId, change) {
    let cartItem = document.querySelector(`.single-product[data-id="${productId}"]`);
    if (cartItem) {
        let quantityInput = cartItem.querySelector(".product-quantity-input");
        let currentQuantity = parseInt(quantityInput.value);
        let availableQuantity = parseInt(quantityInput.dataset.available);
        let newQuantity = currentQuantity + change;

        if (newQuantity < 1) return;

        // ✅ Prevent update if it exceeds stock
        if (newQuantity > availableQuantity) {
            showToast("Quantity exceeds available stock!");
            newQuantity = 1;
            return;
        }

        quantityInput.value = newQuantity;

        // Update total price
        let price = parseFloat(cartItem.querySelector(".price").innerText);
        let total = cartItem.querySelector(".total");
        total.innerText = (price * newQuantity).toFixed(2);

        // Update subtotal
        updateSubtotal();

        // Send update to backend
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => {
            if (!response.ok) throw new Error("Response was not ok");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log(data.success);
            } else {
                showToast(data.error);
                quantityInput.value = 1; // fallback reset
            }
        })
        .catch(error => {
            showToast("Something went wrong while updating quantity.");
        });
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


// Select all checkboxes
function selectAll(source) {
    const checkboxes = document.querySelectorAll('.selected-product');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        if (!checkboxes[i].disabled) {
            checkboxes[i].checked = source.checked;
        }
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


function showToast(message) {
    const toast = document.getElementById('errorToast');
    const body = document.getElementById('errorToastBody');

    body.textContent = message;
    toast.style.display = 'block';

    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}