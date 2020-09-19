<?php
if (authentication(false)) { echo '<div id="news"><p>Authentification réussi !</p></div>'; }
else { throw new Exception("Tentative d'accès sans authentification avortée !"); }