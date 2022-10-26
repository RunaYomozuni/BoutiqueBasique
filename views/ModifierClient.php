<?php include("header.php");?>
<main>
  <?php
    if (isset($recherche)) {
        echo $recherche;
    }?>
        <H2>
            FORMULAIRE DE MODIFICATION D'UN CLIENT
        </H2>
        <section id='section'>
            <div class='container'>
                <img src="../assets/img/<?php echo $client->getClientSigne() ?>" alt="">
            </div>

            <form action='../controllers/Controller.php' method="post" id="formCreate">
                <input type='hidden' name='todo' value='modifierClient'>

                <input type="hidden" name="clientId" value="<?php echo $client->getClientId() ?>">

                <div>
                    <label for="clientPrenom">Prenom</label>
                    <input type="text" name="clientPrenom" value="<?php echo $client->getClientPrenom() ?>" required id="clientPrenom">
                </div>


                <div>
                    <label for="clientNom">Nom</label>
                    <input type="text" name="clientNom" value="<?php echo $client->getClientNom() ?>" required id="clientNom">
                </div>


                <div>
                    <label for="clientMail">Mail</label>
                    <input type="text" name="clientMail" value="<?php echo $client->getClientMail() ?>" required id="clientMail">
                </div>


                <div>
                    <label for="clientPassword">Password</label>
                    <input type="password" name="clientPassword" value="<?php echo $client->getClientPassword() ?>" required id="clientPassword">
                </div>


                <div>
                    <label for="clientPasswordConfirm">Confirmer le Password</label>
                    <input type="password" name="clientPasswordConfirm"  required id="clientPassword">
                </div>


                <div>
                    <label for="clientNaissance">Changer la date de naissance</label>
                    <input type="date" name="clientNaissance" value="<?php echo $client->getClientNaissance() ?>" id="clientNaissance">
                </div>


                <div>
                    <input type="submit" name="submitModifierClient" value="MODIFIER LE CLIENT" id="submit">
                </div>
            </form>
            <form action='../controllers/Controller.php' method="post" id="formDelete">
                <input type='hidden' name='todo' value='supprimerClient'>
                <input type="hidden" name="clientId" value="<?php echo $client->getClientId() ?>">
                <button type="submit" name="submitSupprimerClient" id="delete"
                        onclick="return confirm('Êtes-vous sur de vouloir supprimer ce client ?')">
                    SUPPRIMER
                </button>
            </form>
    </section>

</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>


</body>
</html>