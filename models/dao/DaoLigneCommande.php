<?php
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/LigneCommande.php');
require_once('DaoCommande.php');
require_once('DaoProduit.php');

class DaoLigneCommande
{

    public function __construct()
    {
    }

    //CETTE FONCTION 1
    function totalCommande($idCommande): float
    {
        $query = "SELECT SUM(PRIX*QUANTITE) as total
                                    FROM LigneCommande 
                                    WHERE COMMANDE_ID = " . $idCommande;

        //ON APPELLE LA FONCTION QUI VA FAIRE LA CONNECTION ET RENVOYER UN RÉSULTAT
        $result = executeQuery($query);

        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }

    function readLigneCommande($where = null): array
    {
        if ($where != null) {
            $query = "SELECT COMMANDE_ID,PRODUIT_ID, QUANTITE, PRIX
                                    FROM LigneCommande 
                                    WHERE " . $where;
        } else {
            $query = "SELECT COMMANDE_ID,PRODUIT_ID, QUANTITE, PRIX
                                    FROM LigneCommande
                                    ORDER BY COMMANDE_ID";
        }
        //ON APPELLE LA FONCTION QUI VA FAIRE LA CONNECTION ET RENVOYER UN RÉSULTAT
        $result = executeQuery($query);
        //ON CREE UN TABLEAU QUI CONTIENDRA LES COMMANDES RECHERCHEES
        $lesLigneCommandes = array();
        //ON INSTANCIE UN OBJET DE TYPE DaoCommande
        $outilCommande = new DaoCommande();
        //ON INSTANCIE UN OBJET DE TYPE DaoProduit
        $outilProduit = new DaoProduit();

        foreach ($result as $row) {
            //ON RECUPERE L'ID DE LA COMMANDE DANS LA LIGNE DE COMMANDE POUR L'ENVOYER
            //A LA METHODE "readCommande"
            $where = "COMMANDE_ID = " . $row['COMMANDE_ID'];
            //ON RECUPERE L'ID DU PRODUIT DANS LA LIGNE DE COMMANDE POUR L'ENVOYER
            //A LA METHODE "readProduit"
            $where2 = "PRODUIT_ID = " . $row['PRODUIT_ID'];
            //LA METHODE "readCommande" nous renvoie un objet de type Commande
            $commande = $outilCommande->readCommande($where)[0];
            //LA METHODE "readProduit" nous renvoie un objet de type Produit
            $produit = $outilProduit->readProduit($where2)[0];
            //ON ENVOIE LE CLIENT DANS LE CONSTRUCTEUR DE LA COMMANDE
            $LigneCommande = new LigneCommande($commande, $produit, $row['QUANTITE'], $row['PRIX']);
            array_push($lesLigneCommandes, $LigneCommande);
        }
        return $lesLigneCommandes;
    }

    function afficherLigneCommandes($where = null): string
    {
        if (!empty($_POST['nomLigneCommande'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé
              */
            $id = $_POST['nomLigneCommande'];
            $where = "COMMANDE_ID=" . $id;
        }
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE LIGNEDECOMMANDE
        $lesLigneCommandes = $this->readLigneCommande($where);
        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherLigneCommandes"
        $nbProduit = 1;
        $contenu =
            "
        <h3>Contenu de la commande</h3></section><br><div>";
        foreach ($lesLigneCommandes as $LigneCommande) {
            $contenu .= "
             <h4> " . $nbProduit . ")    " . $LigneCommande->getProduit()->getProduitNom() . "  **  Prix pièce: " . $LigneCommande->getPrix() . " EUROS  ** Qté : " . $LigneCommande->getQuantite() . "   ** Total : " . $LigneCommande->getTotal() . " EUROS</h4> 
             <br>";
            $nbProduit++;
        }
        $contenu .= "</div>";
        return $contenu;
    }

}
