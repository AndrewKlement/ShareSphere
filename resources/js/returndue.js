import '../css/returndue.css';


const checkboxes = document.querySelectorAll(".return-checkbox");
const totalPriceElement = document.getElementById("total-quantity");
const purchaseBtn = document.getElementById("return-btn");
const selectedItemsInput = document.getElementById("selected-items");

function updateTotal() {
    let total = 0;
    let selectedItems = [];
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            total += parseInt(checkbox.dataset.amount);
            selectedItems.push(checkbox.value);
        }
    });
    totalPriceElement.textContent = total;
    selectedItemsInput.value = selectedItems.join(",");
    purchaseBtn.disabled = selectedItems.length === 0;
}

checkboxes.forEach((checkbox) => checkbox.addEventListener("change", updateTotal));
