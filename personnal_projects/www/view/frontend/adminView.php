<?php $title = "Administration";
    $css = "admin";
    $icon = "Admin.png"; ?>

<?php ob_start(); ?>
    <?php require("Manager/AdminManager.php"); ?>
		<header id="Boot">
			<h1>Administration V0.1.0</h1>
			<img src="public/img/Logo.png" id="Haut" alt="Logo">
			<img src="public/img/Admin.png" id="Bas" alt="Admin">
		</header>
        <div id="bloc_page">
            <div class="relative">
              <img src="public/img/users/<?= mb_strtoupper($_SESSION['pseudo'], 'UTF-8') ?>.png" alt="Avatar">
              <img src="public/img/Admin.png" alt="Admin" class="absolute">
            </div>
            <div class="flex">
              <a href="index.php?action=confirm&amp;confirm=resetAvatar&amp;admin=true"><span class="button">Réinitialiser les avatars</span></a>
              <a href="index.php?action=confirm&amp;confirm=resetMaison&amp;admin=true"><span class="button">Réinitialiser les Menu Maison</span></a>

              <form action="index.php?action=confirm&amp;confirm=closeSite&amp;admin=true" method="post">
                <input type="text" name="reason" placeholder="Raison de fermeture : " size="25" />
                <input type="text" name="date" placeholder="Date de réouverture : " size="25" />
                <input type="text" name="hour" placeholder="Heure de réouverture : " size="25" />
                <input type="submit" value="Fermer le site" />
              </form>
              <table>
                <thead>
                  <tr>
                    <th>Pseudo</th>
                    <th>Erreur</th>
                    <th>URL</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th colspan="3" style="height: 40px;">
                      <a href="index.php?action=confirm&amp;confirm=resetErrors&amp;admin=true" class="button_margin"><span class="button">Réinitialiser les erreurs</span></a>
                    </th>
                  </tr>
                </tfoot>
                  <?php while ($donnees = $errors->fetch()) { ?>
                    <tbody>
                      <tr>
                        <td><?= $donnees['pseudo'] ?></td>
                        <td><?= $donnees['error'] ?></td>
                        <td><?= $donnees['url'] ?></td>
                      </tr>
                    </tbody>
                  <?php } $errors->closeCursor();?>
              </table>

              <table>
                <thead>
                  <tr>
                    <th>Pseudo</th>
                    <th>Alerte</th>
                    <th>URL</th>
                    <th>Navigateur</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th colspan="4" style="height: 40px;">
                      <a href="index.php?action=confirm&amp;confirm=resetWarnings&amp;admin=true" class="button_margin"><span class="button">Réinitialiser les alertes</span></a>
                    </th>
                  </tr>
                </tfoot>
                  <?php while ($donnees2 = $warnings->fetch()) { ?>
                    <tbody>
                      <tr>
                        <td><?= $donnees2['pseudo'] ?></td>
                        <td><?= $donnees2['warning'] ?></td>
                        <td><?= $donnees2['url'] ?></td>
                        <td><?= $donnees2['navigator'] ?></td>
                      </tr>
                    </tbody>
                  <?php } $warnings->closeCursor();?>
              </table>
            </div>
        </div>
        <script type="text/javascript" src="public/js/Translation.js"></script>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>