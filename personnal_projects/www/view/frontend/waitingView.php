<?php $noMasterMenu=true; ?>

<?php ob_start(); ?>
    <script type="text/javascript">
        function cancelRedirection() {
            clearInterval(decreaseSecondsInterval);
            document.getElementById("seconds").textContent="∞";
            clearInterval(redirectionTimeout);
            document.getElementById("redirectionButtton").style.display="none";
            document.getElementById("ahref").style.display="";
        }
    </script>

    <h2>Redirection vers la page <?= $verslaPage ?> dans <span id="seconds">5</span> secondes.</h2>
    <div id="exterior">
    	<div id="interior">
            <span id="textInteriorExterior">Allons-y ! Alonso !</span>
        </div>
    </div>

    <button id="redirectionButtton" onclick="cancelRedirection()">Annuler la redirection</button>
    <a href="<?= $urlRedirection ?>"><h1 id="ahref">Retourner vers la page <?= $verslaPage ?></h1></a>

    <script type="text/javascript">
        // transformer une chaine de charactère avec "px" en chaine de chiffres
        function px (pxX) {
            let reponse="";
            for (let i = 0; i < pxX.length; i++) {
                if (pxX[i]==="p") {
                    for (let ii = 0; ii < pxX.length; ii++) {
                        if (pxX[ii]!=="p" && pxX[ii]!=="x") {
                            reponse = reponse + String(pxX[ii]);
                        }
                    }
                }
            }
            reponse = Number(reponse)
            return (reponse);
        }

        function increaseSize() {
            let scale=px(document.getElementById("exterior").style.width)/83; // 5000/60
            if ( px(document.getElementById("interior").style.width)+scale>=px(document.getElementById("exterior").style.width) ) {
                clearInterval(increaseSizeInterval);
                document.getElementById("interior").style.width=document.getElementById("exterior").style.width;
                increase=false;
                //console.log(window.innerWidth);
            }
            else {
                document.getElementById("interior").style.width=px(document.getElementById("interior").style.width)+scale+"px"; 
                //console.log(document.getElementById("interior").style.width);
            }

        }

        function decreaseSeconds() {
            if ( document.getElementById("seconds").textContent<=0 ) {
                clearInterval(decreaseSecondsInterval);
            }
            else {
                document.getElementById("seconds").textContent=Number(document.getElementById("seconds").textContent)-1;
            }
        }

        function coloring() {
            let scale=5;

            if (rgb1+scale<rgb1Next) {rgb1+=scale;}
            else if (rgb1-scale>rgb1Next) {rgb1-=scale;}
            else {rgb1=rgb1Next;}
            
            if (rgb2+scale<rgb2Next) {rgb2+=scale;}
            else if (rgb2-scale>rgb2Next) {rgb2-=scale;}
            else {rgb2=rgb2Next;}

            if (rgb3+scale<rgb3Next) {rgb3+=scale;}
            else if (rgb3-scale>rgb3Next) {rgb3-=scale;}
            else {rgb3=rgb3Next;}

            document.getElementById("interior").style.backgroundColor="rgb("+rgb1+","+rgb2+","+rgb3+")";
            if (increase) {document.getElementById("exterior").style.backgroundColor="rgb("+(255-rgb1)+","+(255-rgb2)+","+(255-rgb3)+")";}
            document.getElementById("textInteriorExterior").style.color="rgb("+(255-rgb1)+","+(255-rgb2)+","+(255-rgb3)+")";

            if (rgb1==rgb1Next&&rgb2==rgb2Next&&rgb3==rgb3Next) {
                rgb1Next=Math.floor(Math.random() * (max - min) + min);
                rgb2Next=Math.floor(Math.random() * (max - min) + min);
                rgb3Next=Math.floor(Math.random() * (max - min) + min);
            }
        }

        document.getElementById("ahref").style.display="none";

        document.getElementById("exterior").style.width=window.innerWidth-(window.innerWidth/8)+"px";
        document.getElementById("interior").style.width=0+"px";
        document.getElementById("exterior").style.height=window.innerHeight-((window.innerHeight/15)*14)+"px";

        let rgb1=245, rgb2=196, rgb3=184;
        let max=255, min=0;
        let rgb1Next=Math.floor(Math.random() * (max - min) + min);
        let rgb2Next=Math.floor(Math.random() * (max - min) + min);
        let rgb3Next=Math.floor(Math.random() * (max - min) + min);

        let coloringInterval=setInterval(coloring, 60);
    	let increaseSizeInterval=setInterval(increaseSize, 60);
        let increase=true;
        let decreaseSecondsInterval=setInterval(decreaseSeconds, 1000);
        let redirectionTimeout=setTimeout(function(){ window.location.href = "<?= $urlRedirection ?>"; }, 1000*5);
    </script>
    <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $Waitingcontent = ob_get_clean(); ?>