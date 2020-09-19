<?php
if (authentication(false)) { echo '<div id="news"><p>Authentification réussi !</p>'; }
else { throw new Exception("Tentative d'accès sans authentification avortée !"); }

if (connection(false)) { echo '<p>'.$_SESSION["pseudo"].' connecté·e !</p>'; }
else { throw new Exception("Tentative d'accès sans connection avortée !"); }

if (admin(false)) { echo '<p>Administrateur·rice connecté·e !</p></div>'; }
else { throw new Exception("Tentative d'accès sans administration avortée !"); }