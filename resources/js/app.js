import './bootstrap';
import '../css/layouts/navbar.css';
import '../css/layouts/global.css';

document.addEventListener("DOMContentLoaded", () => {
    const logoutButton = document.getElementById("logout-button");
    if (logoutButton) {
        logoutButton.addEventListener("click", (event) => {
            event.preventDefault();
            const logoutForm = document.getElementById("logout-form");
            if (logoutForm) {
                logoutForm.submit();
            }
        });
    }
});