import '../css/returnrequest.css';

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#confirm-btn").forEach(button => {
        button.addEventListener("click", function () {
            let requestId = this.getAttribute("data-id");
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            
            fetch(`/return-request/${requestId}/confirm`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ id: requestId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to confirm request");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById(`list-group-item${requestId}`).remove();
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
