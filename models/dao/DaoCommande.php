<?php
require_once('FonctionsBdd.php');
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/Commande.php');
require_once('DaoClient.php');
require_once('DaoLigneCommande.php');

class DaoCommande
{

    public function __construct()
    {
    }

    function readCommande($where = null): array
    {
        if ($where != null) {
            $query = "SELECT COMMANDE_ID,CLIENT_ID, COMMANDE_DATE
                                    FROM commande 
                                    WHERE " . $where;
        } else {
            $query = "SELECT COMMANDE_ID,CLIENT_ID, COMMANDE_DATE
                                    FROM commande
                                    ORDER BY COMMANDE_ID";
        }
        //ON APPELLE LA FONCTION QUI VA FAIRE LA CONNECTION ET RENVOYER UN RÉSULTAT
        $result = executeQuery($query);
        //ON CREE UN TABLEAU QUI CONTIENDRA LES COMMANDES RECHERCHEES
        $lesCommandes = array();
        //ON INSTANCIE UN OBJET DE TYPE DaoClient
        $outilClient = new DaoClient();

        foreach ($result as $row) {
            //ON RECUPERE L'ID DU CLIENT DANS LA COMMANDE POUR L'ENVOYER
            //A LA METHODE "readClient"
            $where = "CLIENT_ID = " . $row['CLIENT_ID'];
            //LA METHODE "readClient" nous renvoie un objet de type client
            $client = $outilClient->readClient($where)[0];


            //ON ENVOIE LE CLIENT DANS LE CONSTRUCTEUR DE LA COMMANDE
            $commande = new Commande($row['COMMANDE_ID'], $client, $row['COMMANDE_DATE']);
            array_push($lesCommandes, $commande);
        }
        return $lesCommandes;
    }

    function afficherCommandes($where = null): string
    {
        //ON INSTANCIE UN OBJET DE TYPE LigneCommande afin de pouvoir afficher les produits commandés
        $outilLigneCommande = new DaoLigneCommande();

        //On vérifie si il y a eu une recherche commande de postée via le MENU SELECT
        if (!empty($_POST['nomCommande'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé
              */
            $id = $_POST['nomCommande'];
            $where = "COMMANDE_ID=" . $id;
        }
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE COMMANDES
        $lesCommandes = $this->readCommande($where);
        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherCommandes"
        $contenu =
            "<section id='slogan'>
        <h2>Liste des Commandes</h2></div></section>";
        foreach ($lesCommandes as $commande) {
            $contenu .= "<article class='article'>
                <h3> Commande n° " . $commande->getCommandeId() . "  du : " . dateEnClair($commande->getCommandeDate()) . " (Client  : " . $commande->getClient()->getClientPrenom() . " " . $commande->getClient()->getClientNom() . " )</h3>
          <br><h3> Total de la commande :   " . $commande->getTotal() . " EUROS </h3>
             <br>";
            //ON APPELLE LA FONCTION afficherLigneCommandes() DU DaoLigneCommande POUR AFFICHER LES PRODUITS COMMANDES
            $where = "COMMANDE_ID =" . $commande->getCommandeId();
            $detailCommande = $outilLigneCommande->afficherLigneCommandes($where);
            $contenu .= $detailCommande;
            $contenu .= "</article>";
        }
        return $contenu;
    }

//CETTE FONCTION PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE COMMANDES
    function rechercheCommande(): string
    {   //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE TOUS LES COMMANDES SOUS FORME DE TABLEAU D'OBJETS
        $lesCommandes = $this->readCommande(null);
        $recherche = "
<form name='searchProduct' action='../controllers/Controller.php' method='post' class='search-form'>
            <input type='hidden' name='todo' value='afficherCommandes'>
    <label for='nomCommande' hidden></label>
    <select name='nomCommande' id='nomCommande' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir une commande </option>";
        foreach ($lesCommandes as $commande) {
            $recherche .= "<option value=" . $commande->getCommandeId() . ">" . $commande->getCommandeId() . ' ' . "</option>";
        }
        $recherche .= "</select>
</form>";
        return $recherche;
    }
}