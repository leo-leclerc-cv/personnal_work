<?php ob_start(); ?>
        <?php require("Manager/RecoveryManager.php"); ?>
        <style type="text/css">
          div.flex {
            display: flex;
            justify-content: space-around;
            flex-direction: column;
          }

          div.flex *:not(form) {
            margin: auto;
            margin-top: 50px;
            margin-bottom: 50px;
          }

          .tableWbuttons {
            height: 40px;
          }

        </style>
            <div class="flex">
            <img src="public/img/users/<?= mb_strtoupper($_SESSION['pseudo'], 'UTF-8') ?>.png" alt="Avatar">

              <table>
                <thead>
                  <tr>
                    <th colspan="2" class="tableWbuttons">Maintenance</th>
                  </tr>
                </thead>
                    <tbody>
                      <tr>
                        <td class="tableWbuttons"><a href="recovery.php?action=confirm&amp;confirm=resetAvatar"><span class="button">Réinitialiser les avatars</span></a></td>
                        <td class="tableWbuttons"><a href="recovery.php?action=confirm&amp;confirm=resetMaison"><span class="button">Réinitialiser les Menu Maison</span></a></td>
                      </tr>
                    </tbody>
              </table>


              <table>
                <thead>
                  <tr>
                    <th colspan="1" class="tableWbuttons">Mise à niveau</th>
                  </tr>
                </thead>
                    <tbody>
                      <tr>
                        <td class="tableWbuttons"><a href="recovery.php?action=confirm&amp;confirm=createMaison"><span class="button">Créer les Menu Maison</span></a></td>
                      </tr>
                    </tbody>
              </table>

              <form action="recovery.php?action=confirm&amp;confirm=closeSite" method="post">
                <input type="text" name="reason" placeholder="Raison de fermeture : " size="25" />
                <input type="text" name="date" placeholder="Date de réouverture : " size="25" />
                <input type="text" name="hour" placeholder="Heure de réouverture : " size="25" />
                <input type="submit" value="Mettre à jour la fermeture du site" />
              </form>

              <a href="recovery.php?action=confirm&amp;confirm=reopen"><span class="button">Ré-ouvrir le site</span></a>

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
                      <a href="recovery.php?action=confirm&amp;confirm=resetErrors"><span class="button">Réinitialiser les erreurs</span></a>
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
                      <a href="recovery.php?action=confirm&amp;confirm=resetWarnings"><span class="button">Réinitialiser les alertes</span></a>
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
<?php $content = ob_get_clean(); ?>

<?php require('templateRecovery.php'); ?>