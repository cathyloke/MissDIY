document.addEventListener("DOMContentLoaded", function(){
    const checkboxes = document.querySelectorAll("input[name='selected_product']");
    
    checkboxes.forEach(checkbox=>{
        checkbox.addEventListener("change", updateSubtotal);
    });
});

function increment(button){
    let input = button.previousElementSibling;
    let quantity = parseInt(input.value);
    input.value = quantity + 1;
    updateTotalPrice(input);
}

function decrement(button){
    let input = button.nextElementSibling;
    let quantity = parseInt(input.value);
    if(quantity > 1){
        input.value = quantity - 1;
        updateTotalPrice(input);
    }
}

function updateTotalPrice(input){
    let product = input.closest(".single-product");
    let price = parseFloat(product.querySelector(".price").innerText);
    let quantity = parseInt(input.value);
    let total = product.querySelector(".total");
    total.innerText = (price*quantity).toFixed(2);

    let checkbox = product.querySelector("input[name='selected_product']");
    if(checkbox.checked){
        updateSubtotal();
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

function removeProduct(button){
    let product = button.closest(".single-product");
    product.remove();
    updateSubtotal();
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