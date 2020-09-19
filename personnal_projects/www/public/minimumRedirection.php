<?php
if (isset($msg)==false) {
	$msg="N/A";
}
if (isset($redirection)==false) {
	$redirection="index.php";
}
?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8" />
        <link rel="icon" href="icon.ico">
		<title><?= $msg ?></title>
		<link rel="stylesheet" href="style.css">
		<style type="text/css">body { text-align: center; }</style>
	</head>
	<body>
		<h1><?= $msg ?></h1>
		<h2>Vous serez redirigez vers <?= $redirection ?> dans <span id="seconds">3</span> secondes...</h2>
        <script type="text/javascript">
        	function decreaseSeconds() {
			    if ( document.getElementById("seconds").textContent<=0 ) {
			        clearInterval(decreaseSecondsInterval);
			        window.location.href = "<?= $redirection ?>";
			    }
			    else {
			        document.getElementById("seconds").textContent=Number(document.getElementById("seconds").textContent)-1;
			    }
			}
			let decreaseSecondsInterval=setInterval(decreaseSeconds, 1000);
        </script>
	</body>
</html>
<?php $content = ob_get_clean(); ?>
<?php echo $content; ?>