window.addEventListener("DOMContentLoaded", () => {
    let btn = document.querySelectorAll("button[id='settings']");
    let j = 0;
    btn.forEach((el) => {
        el.addEventListener('click', () => {
            if(j==0) {
                j = 1;
                document.getElementById("white").style.display = "block";
                document.getElementById("blue").style.display = "block";
                document.getElementById("black").style.display = "block";
            } else {
                j = 0;
                document.getElementById("white").style.display = "none";
                document.getElementById("blue").style.display = "none";
                document.getElementById("black").style.display = "none";
            }
        })
    });
});