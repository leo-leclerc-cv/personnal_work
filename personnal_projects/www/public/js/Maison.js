for (var i = 0 ; i < document.getElementsByClassName("modifier").length ; i++) {
    document.getElementsByClassName("modifier")[i].addEventListener("click", function (e) {
        document.getElementById("form").style.display="block";
        document.getElementById("maisonid").value=e.target.id;
        document.getElementById("oldTitle").textContent=e.target.title;
    });
}

resetDisplay=false;
document.getElementById("wrench").addEventListener("click", function (e) {
    if (resetDisplay) {
        document.getElementById("reset").style.display="none";
        for (var i = 0 ; i < document.getElementsByClassName("modifier").length ; i++) {
            document.getElementsByClassName("modifier")[i].style.display="none";
        }
        resetDisplay=false;
    }
    else {
        document.getElementById("reset").style.display="block";
        for (var i = 0 ; i < document.getElementsByClassName("modifier").length ; i++) {
            document.getElementsByClassName("modifier")[i].style.display="block";
        }
        resetDisplay=true;
    }
});

document.getElementById("crossBorder").addEventListener("click", function (e) {
    document.getElementById("form").style.display="none";
});