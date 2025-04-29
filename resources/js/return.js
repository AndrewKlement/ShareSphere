import '../css/return.css';

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".accordion-collapse").forEach(accordion => {
        accordion.addEventListener("show.bs.collapse", function () {
            const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
            const priceElements = button.querySelectorAll(".desc-cont, .status");
            const othElements = button.querySelectorAll(".othProd");

            priceElements.forEach(el => el.classList.remove("d-none"));
            othElements.forEach(el => el.classList.add("d-none"));
        });

        accordion.addEventListener("hide.bs.collapse", function () {
            const button = document.querySelector(`[data-bs-target="#${this.id}"]`);
            const priceElements = button.querySelectorAll(".desc-cont, .status");
            const othElements = button.querySelectorAll(".othProd");

            priceElements.forEach(el => el.classList.add("d-none"));
            othElements.forEach(el => el.classList.remove("d-none"));
        });
    });
});