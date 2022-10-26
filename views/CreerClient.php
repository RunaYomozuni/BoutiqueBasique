<?php include("header.php"); ?>
<main>
    <?php if (isset($recherche)) {
        echo $recherche;
    }?>
    <article id="slogan">
        <h2> FORMULAIRE DE CRÉATION D'UN CLIENT </h2>
    </article>
        <section id='section'>
            <form action="../controllers/Controller.php" method="post" id="formCreate">
                <input type='hidden' name='todo' value='creerClient'>
                <div>
                    <label for="clientPrenom">Prenom</label>
                    <input type="text" name="clientPrenom" required id="clientPrenom">
                </div>


                <div>
                    <label for="clientNom">Nom</label>
                    <input type="text" name="clientNom"  required id="clientNom">
                </div>


                <div>
                    <label for="clientMail">Mail</label>
                    <input type="email" name="clientMail"  required id="clientMail">
                </div>


                <div>
                    <label for="clientPassword">Password</label>
                    <input type="password" name="clientPassword"  required id="clientPassword">
                </div>


                <div>
                    <label for="clientPasswordConfirm">Confirmer le Password</label>
                    <input type="password" name="clientPasswordConfirm"  required id="clientPasswordConfirm">
                </div>


                <div>
                    <label for="clientNaissance"> date de naissance</label>
                    <input type="date" name="clientNaissance" id="clientNaissance">
                </div>

                <div>
                    <input type="submit" name="submitCreerClient" id="submit">
                </div>
            </form>
        </section>
</main>

</body>
</html>