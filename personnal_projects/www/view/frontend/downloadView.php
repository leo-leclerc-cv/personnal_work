<?php $title = "Téléchargement";
    $css = "download"; 
    $icon = "download.png";
?>

<?php
    ob_start(); 
    require("Manager/PasswordManager.php");
?>

        <a id="container" href="public/downloadable/<?= $_GET['download'] ?>">
            <img id="downloadTop" src="public/img/downloadPart1.png" alt="download_top">
            <?php
            if (isset($_GET["download"])) {
                class infos
                {
                    public $extension;
                    public $img;
                    public $description;
                }

                $download = new infos;
                $download->extension = $_GET["download"][strlen($_GET["download"])-3].$_GET["download"][strlen($_GET["download"])-2].$_GET["download"][strlen($_GET["download"])-1];

                switch ($download->extension) {
                    case "exe":
                        $plateform="windows";
                    break;

                    case "rar":
                    case ".7z":
                    case "zip":
                        $plateform="zip";
                    break;

                    case "deb":
                        $plateform="debian";
                    break;

                    case "pdf":
                        $plateform="pdf";
                    break;

                    case "png":
                    case "jpg":
                    case "bmp":
                        $plateform="img";
                    break;

                    case ".py":
                        $plateform="python";
                    break;

                    case "odt":
                    case "ods":
                    case "odp":
                    case "odg":
                        $plateform="libreOffice";
                    break;
                    
                    default:
                        $plateform="unknown";
                    break;
                }
                echo "<img id='plateform' src='public/img/extensions/".$plateform.".png' alt='Plateforme : ".$plateform."' >"; ?>
            
            <img id="downloadBottom" src="public/img/downloadPart2.png" alt="download_bottom">
        </a>
        <p id="description"><?php
                switch ($download->extension) {
                    case 'exe':
                        echo "Ce fichier est un fichier éxécutable pour Windows.<br>Exécuter le pour savoir ce qu'il contient.<br>Si vous n'êtes pas sûr de ce que contient ce fichier passez y un petit coup d'antivirus.";
                    break;

                    case "zip":
                        echo "Ce fichier est un fichier compressé, il est compressé au format ZIP .<br>Pour le décompresser vous pouvez faire clic droit sur le fichier puis cliquer sur extraire tout.<br>Pour une décompression plus efficace je vous conseil d'utiliser le logiciel : <a href='https://www.7-zip.org'><img src='https://www.7-zip.org/7ziplogo.png' alt='7zip'></a><br>L'hébergement de fichier exe étant interdit les éxécutables Windows sont contenus dans des fichiers zip";
                    break;

                    case "rar":
                    case ".7z":
                        echo "Ce fichier est un fichier compressé, il est compressé au format ".$download->extension." .Pour l'ouvrir il vous faudra d'abord installer 7zip disponible ici : <a href='https://www.7-zip.org'><img src='https://www.7-zip.org/7ziplogo.png' alt='7zip'></a>";
                    break;

                    case 'deb':
                        echo "Ce fichier est un fichier éxécutable pour Debian et ses déclinaisons (Ubuntu entre autre).<br>Exécuter le pour savoir ce qu'il contient.<br>(dpkg -i nomDuPackage.deb)";
                    break;

                    case 'pdf':
                        echo "Ce fichier est un document au format PDF.";
                    break;

                    case "png":
                    case "jpg":
                    case "bmp":
                        echo "Ce fichier est une image au format ".$download->extension." .";
                    break;

                    case '.py':
                        echo "Ce fichier est un script Phyton.<br>Pour l'utiliser il vous faudra d'abord installer Python disponible ici : <a href='https://www.python.org/'><img src='https://www.python.org/static/img/python-logo.png' alt='python.org'></a>";
                    break;

                    case "odt":
                    case "ods":
                    case "odp":
                    case "odg":
                        switch ($download->extension) {
                            case 'odt':
                                $libreOffice="Document Writer (l'équivalent de World mais en logiciel libre)";
                            break;

                            case 'ods':
                                $libreOffice="Classeur Calc (l'équivalent d'Excel mais en logiciel libre)";
                            break;

                            case 'odp':
                                $libreOffice="Présentation Impress (l'équivalent de PowerPoint mais en logiciel libre)";
                            break;

                            case 'odg':
                                $libreOffice="Dessin Draw (permet de faire du dessin vectoriel entre autre)";
                            break;
                            
                            default:
                                $libreOffice="(l'extension précise n'est pas reconnu)";
                            break;
                        }
                        echo "Ce fichier est un fichier pour LibreOffice ".$libreOffice.".<br>Pour l'utiliser il vous faudra d'abord installer LibreOffice disponible ici : <a href='https://fr.libreoffice.org/'><img src='https://fr.libreoffice.org/themes/libreofficenew/img/logo.png' alt='libreoffice.org' style='background-color: #00A500; border-radius: 0.25em; padding: 0.5em;'></a>";
                    break;
                    
                    
                    default:
                        echo "Cette extension n'est pas répertoriée.<br>Veuillez utiliser ce fichier avec précaution.";
                    break;
                }
            }
            else {
                    header("Location: index.php?action=menu&menu=none&error=download_was_not_set");
            }
            ?>
        </p>



        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/download.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>