<?php
require('ControllerProduit.php');
require('ControllerClient.php');
require ('ControllerCommande.php');
require ('ControllerPanier.php');

//ON INSTANCIE UN OBJET DE TYPE ControllerProduit
$cp = new ControllerProduit();
$cc = new ControllerClient();
$ccm = new ControllerCommande();
$cpanier = new ControllerPanier();

// ************************************************************************
// *****************   REQUETES EN GET VIA URL  ***************************
//RECUPERATION DE L ACTION A ACCOMPLIR VIA L'URL
if (isset($_GET['todo'])) {
    switch ($_GET['todo']) {

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "créer un nouveau produit" dans le menu
        case
        "creerProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showCreate();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "voir le catalogue des produits" dans le menu
        case "afficherProduits":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showAll();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "modifier le produit" dans un article du catalogue
        case
        "modifierProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showModify();
            break;
        }
        case
        "creerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showCreate();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "voir le catalogue des clients" dans le menu
        case "afficherClients":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showAll();
            break;
        }
        case "afficherCommandes":
        {
            //On appelle la méthode concernée dans la classe ControllerCommande
            $ccm->showAll();
            break;
        }

        // L'UTILISATEUR A CLIQUE SUR LE LIEN "modifier le client" dans un article du catalogue
        case "modifierClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showModify();
            break;
        }
        // L'UTILISATEUR A CLIQUE SUR LE LIEN "passer commande" sur l'affichage d'un client
        case "passerCommande":
        {
            //On appelle la méthode concernée dans la classe ControllerPanier
            $cpanier->commencerPanier();
            break;
        }

        // L'UTILISATEUR A CLIQUE "se déconnecteer"
        case "deconnexion":
        {
            session_start();
            //On appelle la méthode concernée dans la classe ControllerPanier
            session_destroy();
            $cp->showAll();
            break;
        }

        //GESTION DES CAS D'ERREURS
        default :
        {
            echo "erreur de redirection!!!";
            break;
        }

    }//**********************  FIN  DU  SWITCH
}// FIN DES REQUETES EN GET VIA URL
//*************************************************
//*************************************************
//*************************************************


//*************************************************
//*************************************************
//*************************************************
//*************************************************
// REQUETES EN POST VIA FORMULAIRES
if (isset($_POST['todo'])) {

    switch ($_POST['todo']) {

        // L UTILISATEUR A POSTE LE FORMULAIRE DE CREATION D UN PRODUIT
        case  "creerProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->store();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE RECHERCHE DE PRODUITS (SELECT ETC...)
        case "afficherProduits":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->showAll();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE MODIFICATION D UN PRODUIT
        case
        "modifierProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->update();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE SUPPRESSION D UN PRODUIT
        case
        "supprimerProduit":
        {
            //On appelle la méthode concernée dans la classe ControllerProduit
            $cp->delete();
            break;
        }
        case  "creerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->store();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE RECHERCHE DE CLIENTS (SELECT ETC...)
        case "afficherClients":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->showAll();
            break;
        }
        case "afficherCommandes":
        {
            //On appelle la méthode concernée dans la classe ControllerCommande
            $ccm->showAll();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE MODIFICATION D UN CLIENT
        case
        "modifierClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->update();
            break;
        }

        // L UTILISATEUR A POSTE LE FORMULAIRE DE SUPPRESSION D UN CLIENT
        case
        "supprimerClient":
        {
            //On appelle la méthode concernée dans la classe ControllerClient
            $cc->delete();
            break;
        }
        // L'UTILISATEUR A CLIQUE "se déconnecteer"
        case "LoginClient":
        {
            $cc->login();
            break;
        }

        //GESTION DES CAS D'ERREURS
        default :
        {
            echo "erreur de redirection!!!";
            break;
        }

    }//**********************  FIN  DU  SWITCH
}// FIN DES REQUETES EN POST VIA LES FORMULAIRES
//*************************************************
//*************************************************
//*************************************************
