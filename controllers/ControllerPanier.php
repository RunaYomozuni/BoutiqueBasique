<?php
//require('../models/dao/DaoClient.php');

class ControllerPanier
{
    //on déclare un attribut de type daoClient
    private $daoClient;

    public function __construct()
    {
        //on instancie un objet de type DaoClient
        //en utilisant la variable (attribut) $daoClient
        $this->daoClient = new DaoClient();
    }
    /** mise en session du client **/
    /** affichage des produits avec bouton "ajouter au panier" **/
    public function commencerPanier()
    {
        //ON MET LE CLIENT EN SESSION
        $id = $_GET['id'];
        $where = "CLIENT_ID=" . $id;
        $client = $this->daoClient->readClient($where)[0];
        @session_start();
        $_SESSION["client"] = [
            "id" => $client->getClientId(),
            "prenom" => $client->getClientPrenom(),
            "nom" => $client->getClientNom()
        ];

        //ON AFFICHE TOUS LES PRODUITS
        //POUR QUE LE CLIENT PUISSE CHOISIR CE QU'IL VA METTRE DANS LE PANIER
        $cp = new ControllerProduit();
        $cp->showAll();
    }
}