<?php
if (connection(false)[0]) { echo '<div id="news"><p>Recovery en ligne.</p></div>'; }
else { throw new Exception("Tentative d'accès au recovery avortée !"); }