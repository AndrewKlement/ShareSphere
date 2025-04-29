import '../css/editproduct.css';

document.addEventListener("DOMContentLoaded", function () {
    for (let i = 1; i < 6; i++) {
        document.getElementById("inputimage"+i)
        .addEventListener("change", ()=>{
            let imageCont = document.getElementById("imagecont" + i);
            let imageIdInput = document.getElementById("imageId" + i);
            
            console.log(imageCont.dataset.id)
            if (imageCont.dataset.id) {
                imageIdInput.value = imageCont.dataset.id;
            }
        })

        document.getElementById("close"+i)
        .addEventListener("click", ()=>{
            let imageCont = document.getElementById("imagecont" + i);
            let imageIdInput = document.getElementById("imageId" + i);
            
            console.log(imageCont.dataset.id)
            if (imageCont.dataset.id) {
                imageIdInput.value = imageCont.dataset.id;
            }
        })
    }
});

