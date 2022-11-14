<?php include("header.php"); ?>
<main>

    <article id="slogan">
        <h2> CONTENU DE VOTRE PANIER
        <?php
        if (isset($contenu)) {
            echo "<div class='panier'>$contenu</div>";
        }
        ?></h2>

        <form action='../controllers/Controller.php' method='post' id='submitCommande'>
            <input type='submit' name='submitCommande' id='submit' value='commander votre panier'>
        </form>
    </article>
  </main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>
