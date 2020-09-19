//Cube hover interaction
document.getElementById("cube").addEventListener("mouseenter", function( event ) {
    for (var i = document.getElementsByTagName("i").length - 1; i >= 0; i--) {
        document.getElementsByTagName("i")[i].style.backgroundColor="red";
    }
}, false);

document.getElementById("cube").addEventListener("mouseleave", function( event ) {
    for (var i = document.getElementsByTagName("i").length - 1; i >= 0; i--) {
        document.getElementsByTagName("i")[i].style.backgroundColor="rgba(222, 222, 222, 0.5)";
    }
}, false);


//news color change
function coloring() {
    let scale=5;

    if (rgb+scale<rgbNext) {rgb+=scale;}
    else if (rgb-scale>rgbNext) {rgb-=scale;}
    else {rgb=rgbNext;}


    document.querySelector("div#news p").style.backgroundColor="rgb(0, "+rgb+", 0)";
    document.querySelector("div#news p").style.borderColor="rgb(0, "+(255-rgb)+", 0)";
    document.querySelector("div#news p").style.color="rgb(0, "+(255-rgb)+", 0)";

    if (rgb==rgbNext&&rgb==255) {
    	rgb=255;
    	rgbNext=0;
    }
    else if (rgb==rgbNext&&rgb==0) {
    	rgb=0;
    	rgbNext=255;
    }
}
let rgbNext=255, rgb=0;
let coloringInterval=setInterval(coloring, 60);
