import '../css/productview.css';

document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.getElementById("quantity");
    const buyQuantityInput = document.getElementById("buy-quantity");

    document.querySelectorAll(".quantity-btn").forEach(button => {
        button.addEventListener("click", function () {
            let amount = parseInt(this.getAttribute("data-amount"));
            updateQuantity(amount);
        });
    });

    function updateQuantity(amount) {
        let currentQuantity = parseInt(quantityInput.value);

        if (!isNaN(currentQuantity)) {
            let newQuantity = currentQuantity + amount;
            if (newQuantity < 1) newQuantity = 1;
            quantityInput.value = newQuantity;
            buyQuantityInput.value = newQuantity;
        }
    }

    const durationInput = document.getElementById("duration");
    const buyDurationInput = document.getElementById("buy-duration");

    document.querySelectorAll(".duration-btn").forEach(button => {
        button.addEventListener("click", function () {
            let amount = parseInt(this.getAttribute("data-amount"));
            updateDuration(amount);
        });
    });

    function updateDuration(amount) {
        let currentQuantity = parseInt(durationInput.value);

        if (!isNaN(currentQuantity)) {
            let newQuantity = currentQuantity + amount;
            if (newQuantity < 1) newQuantity = 1;
            durationInput.value = newQuantity;
            buyDurationInput.value = newQuantity;
        }
    }
});