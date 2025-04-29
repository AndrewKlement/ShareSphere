import '../css/addproduct.css';


for (let i = 1; i < 6; i++) {
    const image = document.getElementById('imagecont'+i)
    
    image.addEventListener("click", ()=>{ 
        const imgElement = document.getElementById("image"+i);
        const imgSrc = new URL(imgElement.src, window.location.origin).pathname;

        if (imgSrc !== "/images/image.png") {
            document.getElementById('image' + i).src = window.location.origin + "/images/image.png";
            
            let fileInput = document.getElementById("inputimage" + i);
            fileInput.value = ""; 
        } else {
            document.getElementById("inputimage" + i).click();
        }
    })
    
    image.addEventListener("mouseenter", function () {
        const imgElement = document.getElementById("image"+i);
        const imgSrc = new URL(imgElement.src, window.location.origin).pathname;
            
        if(imgSrc != "/images/image.png"){
            document.getElementById("close"+i).style.display = "block"
        }
    });
    
    image.addEventListener("mouseleave", function () {
            document.getElementById("close"+i).style.display = "none"
    });
        

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
        this.style.height = "auto"; 
        this.style.height = this.scrollHeight + "px";
    });
});