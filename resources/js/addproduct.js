import '../css/addproduct.css';


for (let i = 1; i < 6; i++) {
    document.getElementById('image'+i)
        .addEventListener("click", (event)=>{
            document.getElementById("inputimage"+i).click()
        })


    document
        .getElementById("inputimage"+i)
        .addEventListener("change", (event)=>{
            let file = event.target.files[0];
            let reader = new FileReader();

            reader.onload = function (event) {
                let dataURL = event.target.result;
                document.getElementById('image'+i).src = dataURL;
            };
            reader.readAsDataURL(file);
        })

}

document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.getElementById("desc");

    textarea.addEventListener("input", function () {
        this.style.height = "auto"; // Reset height to auto to recalculate
        this.style.height = this.scrollHeight + "px"; // Set height to content
    });
});