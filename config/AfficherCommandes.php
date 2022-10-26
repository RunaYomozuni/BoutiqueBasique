<?php
include("header.php");?>
</header>
<main>
    <?php
    //injection de la barre de recherche -->
    if (isset($recherche)) {
        echo $recherche;
    }
    //injection en PHP du contenu -->
    if (isset($contenu)) {
        echo $contenu;
    }
    ?>
</main>
<footer>
    <small>&copy; 2022 - boutiquebasique</small>
</footer>

</body>
</html>