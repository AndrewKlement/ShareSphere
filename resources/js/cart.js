import '../css/cart.css';

const checkboxes = document.querySelectorAll(".cart-checkbox");
const totalPriceElement = document.getElementById("total-price");
const purchaseBtn = document.getElementById("purchase-btn");
const selectedItemsInput = document.getElementById("selected-items");

function updateTotal() {
    let total = 0;
    let selectedItems = [];
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            total += parseInt(checkbox.dataset.price);
            selectedItems.push(checkbox.value);
        }
    });
    totalPriceElement.textContent = total;
    selectedItemsInput.value = selectedItems.join(",");
    purchaseBtn.disabled = selectedItems.length === 0;
}

checkboxes.forEach((checkbox) => checkbox.addEventListener("change", updateTotal));


document.querySelectorAll(".quantity-btn").forEach(button => {
    button.addEventListener("click", function () {
        let cartId = this.dataset.id;
        let amount = parseInt(this.dataset.amount);
        let input = this.closest(".quantity-input").querySelector(".quantity");
        let newQuantity = parseInt(input.innerHTML) + amount;

        if (newQuantity < 1) return;

        
        fetch(`/cart/update/${cartId}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ quantity: newQuantity, duration: null })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.innerHTML = newQuantity;
                document.getElementById('price'+cartId).innerHTML = 'Rp ' + data.newPrice;
                document.getElementById('checkbox'+cartId).dataset.price = parseInt(data.newPrice);
                
                updateTotal(); // Recalculate total
            }
        })
        .catch(error => console.error("Error updating cart:", error)); // Debugging
    });
});

document.querySelectorAll(".duration-btn").forEach(button => {
    button.addEventListener("click", function () {
        let cartId = this.dataset.id;
        let amount = parseInt(this.dataset.amount);
        let input = this.closest(".duration-input").querySelector(".duration");
        let newQuantity = parseInt(input.innerHTML) + amount;

        if (newQuantity < 1) return;

        
        fetch(`/cart/update/${cartId}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ duration: newQuantity }) // Send only duration
        })
        .then(response => response.json())
        .then(data => {
            console.log("Server Response:", data); // Debugging
            if (data.success) {
                input.innerHTML = newQuantity;
                document.getElementById('price' + cartId).innerHTML = 'Rp ' + data.newPrice;
                document.getElementById('checkbox' + cartId).dataset.price = parseInt(data.newPrice);
        
                updateTotal(); // Recalculate total
            }
        })
        .catch(error => console.error("Error updating cart:", error)); // Debugging
    });
});