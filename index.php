<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!--Meta-->
    <meta name="description" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title></title> <!--title of page-->
</head>
<body>
<header>
    <a href="index.php"><img src="assets/img/house-solid.svg" alt="house" id="house"></a>
    <a href="views/Login.php"><img src="/assets/img/LoginIcon.webp" alt="IconPlayer" id="login"></a>

    <h1>BoutiqueBasique en MVC1 !</h1>
    <nav>
        <ul>
            <li>
                <a href='controllers/Controller.php?todo=creerClient'>Créer un nouveau client</a>
            </li>

            <li>
                <a href='controllers/Controller.php?todo=creerProduit'>Créer un nouveau produit</a>
            </li>

            <li>
                <a href='controllers/Controller.php?todo=afficherClients'>Voir les clients</a>
            </li>

            <li>
                <a href='controllers/Controller.php?todo=afficherCommandes'>Voir les commandes</a>
            </li>

            <li>
                <a href='controllers/Controller.php?todo=afficherProduits'>Voir les produits</a>
            </li>

        </ul>
    </nav>
</header>
</body>
</html>