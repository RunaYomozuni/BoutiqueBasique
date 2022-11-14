<?php
require_once('FonctionsBdd.php');
require_once('../models/Produit.php');
require_once('../utilitaires/FonctionsUtiles.php');
//*********************************************** PRODUIT PRODUIT PRODUIT
//*********************************************** PRODUIT PRODUIT PRODUIT
//*********************************************** PRODUIT PRODUIT PRODUIT


class DaoProduit
{
    public function __construct()
    {
    }

//CETTE FONCTION PERMET DE CREER UN NOUVEAU PRODUIT
    function createProduit(): string
    {
        $produit = new Produit(0, $_POST['produitNom'], $_POST['produitPrix'], $_POST['produitImage']);
        $query = "INSERT INTO `produit`(`PRODUIT_NOM`,`PRODUIT_PRIX`,`PRODUIT_IMAGE`) values('" . $produit->getProduitNom() . "'" . "," . "'" . $produit->getProduitPrix() . "'" . "," . "'" . $produit->getProduitImage() . "')";
        //ON APPELLE LA FONCTION QUI VA EXECUTER LA REQUETE
        executeQuery($query);
        return $where = "PRODUIT_ID=(SELECT max(PRODUIT_ID) FROM produit)";
    }


//CETTE FONCTION PERMET DE METTRE A JOUR UN PRODUIT
    function updateProduit(): string
    {
        if (empty($_POST['newImage'])) {
            $image = $_POST['produitImage'];
        } else {
            $image = $_POST['newImage'];
        }

        $produit = new Produit($_POST['produitId'], $_POST['produitNom'], $_POST['produitPrix'], $image);

        $query = "UPDATE produit SET PRODUIT_NOM = '" . $produit->getProduitNom() . "', PRODUIT_PRIX ='" . $produit->getProduitPrix() . "' , PRODUIT_IMAGE = '" . $produit->getProduitImage() . "' WHERE  PRODUIT_ID = '" . $produit->getProduitId() . "'";
        //ON APPELLE LA FONCTION QUI VA  EXECUTER LA REQUETE
        executeQuery($query);

        //ON RENVOIE L ID DU PRODUIT AU CONTROLEUR POUR QU il LE TRANSMETTE A LA VUE AFFICHERPRODUITS
        $id = $produit->getProduitId();
        return $where = "PRODUIT_ID=" . $id;

    }

    //CETTE FONCTION PERMET DE SUPPRIMER UN PRODUIT
    function deleteProduit(): void
    {
        $id = $_POST['produitId'];
        $query = "DELETE FROM produit WHERE PRODUIT_ID = " . $id;
        executeQuery($query);

    }

//CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
    function readProduit($where = null): array
    {
        //ON MET NOTRE REQUETE SQL DANS UNE VARIABLE
        if ($where != null) {
            $query = "SELECT PRODUIT_ID, PRODUIT_NOM,PRODUIT_PRIX ,PRODUIT_IMAGE
                                    FROM produit 
                                    WHERE  " . $where;
        } else {
            $query = "SELECT PRODUIT_ID, PRODUIT_NOM,PRODUIT_PRIX ,PRODUIT_IMAGE
                                    FROM produit 
                                    ORDER BY PRODUIT_PRIX";
        }

        //ON APPELLE LA FONCTION QUI VA FAIRE LA CONNECTION ET RENVOYER UN RÉSULTAT
        $result = executeQuery($query);
        //ON RECUPERE LE RÉSULTAT DE LA REQUETE DANS UN TABLEAU
        //QUI CONTIENDRA 1 OU PLUSIEURS OBJETS DE TYPE PRODUIT
        $listProduits = array();
        foreach ($result as $row) {
            $produit = new Produit($row['PRODUIT_ID'], $row['PRODUIT_NOM'], $row['PRODUIT_PRIX'], $row['PRODUIT_IMAGE']);
            array_push($listProduits, $produit);
        }
        return $listProduits;
    }

//CETTE FONCTION PERMET D'AFFICHER TOUT LE CATALOGUE PRODUIT SI L'ID RECUE EN PARAMETRE EST NULL
//SI L'ID EST RENSEIGNE ELLE AFFICHERA UN SEUL PRODUIT
    function afficherProduits($where = null): string
    {

        if (!empty($_POST['prixProduit'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé
              */
            $prixProduit = $_POST['prixProduit'];
            $where = "PRODUIT_PRIX<" . $prixProduit;
        }

        if (!empty($_POST['nomProduit'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé
              */
            $id = $_POST['nomProduit'];
            $where = "PRODUIT_ID=" . $id;
        }

        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
        $lesProduits = $this->readProduit($where);
        //ON CONSTRUIT LE HTML POUR LE FICHIER "AfficherProduits"
        $contenu =
            "<section id='slogan'>
        <h2>Catalogue Produits</h2></div></section><div id='menu'>";
        foreach ($lesProduits as $produit) {
            $id = $produit->getProduitId();
            $contenu .= "<article class='article'>
            <div class='container' ><img class='image' src = '../assets/img/" . $produit->getProduitImage() . " ' alt=''></div >
             <h2 > " . $produit->getProduitNom() . "</h2 >
             <p > " . $produit->getProduitPrix() . " EUROS </p >
            <br>
            <button id='submit'>
                <a href = '../controllers/Controller.php?todo=modifierProduit&id=$id' > MODIFIER LE PRODUIT </a>
            </button>";
            if (isset($_SESSION["client"])) {

                $contenu .= " <a href = '../controllers/Controller.php?todo=ajouterAuPanier&produitId=$id'>AJOUTER AU PANIER</a> ";
            }


            $contenu .= "</article > ";
        }
        var_dump($lesProduits);

        //ON RENVOIE LE HTML AU CONTROLEUR QUI VA LE TRANSMETTRE A LA VUE
        return $contenu;
    }


//CETTE FONCTION PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE PRODUITS
    function rechercheProduit(): string
    {    //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE TOUS LES PRODUITS SOUS FORME DE TABLEAU D'OBJETS
        //POUR AFFICHER LES NOMS DES PRODUITS DANS LE SELECT
        $lesProduits = $this->readProduit(null);

        //ON CONSTRUIT LE HTML POUR LE FICHIER "ModifierProduit"
        $recherche = "
<form name='searchProduct' action='../controllers/Controller.php' method='post' class='search-form'>
            <input type='hidden' name='todo' value='afficherProduits'>

    <label for='nomProduit' hidden></label>
    <select name='nomProduit' id='nomProduit' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir un produit</option>";

        foreach ($lesProduits as $produit) {
            $recherche .= "<option value=" . $produit->getProduitId() . ">" . $produit->getProduitNom() . "</option>";
        }

        $recherche .= "</select>
   <label for='prixProduit' hidden></label>
 <select name='prixProduit' id='prixProduit' class='header-select' onchange='this.form.submit()'>
                            <option value='' >choisir un prix</option>
                            <option value='50'  >Moins de 50 euros</option>
                            <option value='100' >Moins de 100 euros</option>
                            <option value='200' >Moins de 200 euros</option>
                            <option value='300' >Moins de 300 euros</option>
                            <option value='500' >Moins de 500 euros</option>
                            <option value='800' >Moins de 800 euros</option>
                            <option value='1000' >Moins de 1000 euros</option>
                            <option value='2000' >Moins de 2000 euros</option>
                           <option value='5000' >Moins de 5000 euros</option>  
                         </select>
</form>";
        return $recherche;
    }

//CETTE FONCTION PREND EN GET DANS L URL UN ID PRODUIT
//ET RENVOIE PRODUIT
    function afficherFormModif(): Produit
    {
        $id = $_GET['id'];
        $where = "PRODUIT_ID=" . $id;
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT LE PRODUIT A MODIFIER
        //ON RETOURNE CET OBJET PRODUIT AU CONTROLEUR QUI A APPELLE LA FONCTION
        //LE CONTROLEUR RETOURNERA L'OBJET A LA VUE "ModifierProduit";
        return $this->readProduit($where)[0];
    }


//CETTE FONCTION PERMET D AJOUTER UN PRODUIT AU PANIER EN SESSION
    function ajouterAuPanier(): void
    {
        /* On vérifie l'existence du panier, sinon, on le crée */
        if (!isset($_SESSION['panier'])) {
            /* Initialisation du panier */
            $_SESSION['panier'] = array();
            /* Subdivision du panier */
            $_SESSION['panier']['produitId'] = array();
            $_SESSION['panier']['qte'] = array();
        }
//ON vérifie si l'article existe déjà on rajoute 1 à quantité
        $rajoute = false;
        /* On parcourt le panier en session pour modifier l'article précis. */
        for ($i = 0; $i < count($_SESSION['panier']['produitId']); $i++) {
            if (isset($_GET['produitId'])){
                if ($_GET['produitId'] == $_SESSION['panier']['produitId'][$i]) {
                    $_SESSION['panier']['qte'][$i] = $_SESSION['panier']['qte'][$i] + 1;
                    $rajoute = true;
                }}

            if (isset($_POST['produitId'])){
                if ($_POST['produitId'] == $_SESSION['panier']['produitId'][$i]) {
                    $_SESSION['panier']['qte'][$i] = $_POST['quantite'];
                    $rajoute = true;
                }}
        }
        //Si le produit n'existe pas encore dans le panier, on le rajoute
        if (!$rajoute) {

//Rajout d'un produit dans le panier
            array_push($_SESSION['panier']['produitId'], $_GET['produitId']);
            array_push($_SESSION['panier']['qte'], 1);
        }
        if (isset($_POST['submitSupprimerProduit'])){
            $this->supprime_article($_POST['produitId']);
        }
    }


    function supprime_article($ref_article)
    {
        $suppression = false;
        /* création d'un tableau temporaire de stockage des articles */
        $panier_tmp = array("produitId"=>array(),"qte"=>array(), "prix"=>array());
        /* Comptage des articles du panier */
        $nb_articles = count($_SESSION['panier']['produitId']);
        /* Transfert du panier dans le panier temporaire */
        for($i = 0; $i < $nb_articles; $i++)
        {
            /* On transfère tout sauf l'article à supprimer */
            if($_SESSION['panier']['produitId'][$i] != $ref_article)
            {
                array_push($panier_tmp['produitId'],$_SESSION['panier']['produitId'][$i]);
                array_push($panier_tmp['qte'],$_SESSION['panier']['qte'][$i]);
                array_push($panier_tmp['prix'],$_SESSION['panier']['prix'][$i]);
            }
        }
        /* Le transfert est terminé, on ré-initialise le panier */
        $_SESSION['panier'] = $panier_tmp;
        /* Option : on peut maintenant supprimer notre panier temporaire: */
        unset($panier_tmp);
        $suppression = true;

    }

//AFFICHER LE CONTENU D'UN PANIER
    function afficherPanier(): string
    {
        $nbProduit = 1;
        $contenu = "";

        /* On vérifie l'existence du panier, sinon, on le crée */
        if (isset($_SESSION['panier'])) {
            /* On parcourt le panier en session pour afficher chaque produit ajouté. */
            for ($i = 0; $i < count($_SESSION['panier']['produitId']); $i++) {

                $where = "PRODUIT_ID=" . $_SESSION['panier']['produitId'][$i];
                $qte = $_SESSION['panier']['qte'][$i];
                //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
                //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE PRODUIT
                $lesProduits = $this->readProduit($where);
                //ON CONSTRUIT LE HTML POUR LE FICHIER "AfficherProduits"

                foreach ($lesProduits as $produit) {
                    $contenu .= "
<form action='../controllers/Controller.php' method='post' id='form'>
<article class= 'commande'>
<div class='wrapper'>
  <div class='pdt-list'>
    <div class='pdt-content'>
      <div class='pdt'>
        <table>
          <tr>
            <th class='pdt-info'>
              <span class='pdt-title'>" . $produit->getProduitNom() . "</span>
              <span class='pdt-sub' id='select'>
              <select name='quantite' onchange='this.form.submit()'>
                <option value=" . $qte . ">" . $qte . "</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                <option value=4>4</option>
                <option value=5>5</option>
                <option value=6>6</option>
                <option value=7>7</option>
                <option value=8>8</option>
                <option value=9>9</option>
                <option value=10>10</option>
              </select>
              </span>
            </th>
          </tr>
          <tr>
            <td class='price-box'>
              <span class='pdt-price'>" . $produit->getProduitPrix() * $qte . " €</span>
            </td>
          </tr>
        </table>
        <input type='hidden' name='todo' value='changerQuantite'>
        <form action='../controllers/Controller.php' method='post' id='formDelete'>
            <input type='hidden' name='produitId' value=". $produit->getProduitId().">
            <input type='submit' name='submitSupprimerProduit' id='delete' class='panierSupp' value='Supprimer'>
        </form>
</form>   
 ";
                    $contenu .= "</article> ";
                    $nbProduit++;
                }
            }
            $contenu .= "</div>";
        } else {
            $contenu = "VOTRE PANIER EST VIDE";
        }

        return $contenu;
    }


}