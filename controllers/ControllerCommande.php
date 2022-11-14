<?php
require ('../models/dao/DaoCommande.php');

class ControllerCommande
{
    private $daoCommande;

    public function __construct()
    {
        //on instancie un objet de type daoClient
        //en utilisant la variable $daoClient
        $this->daoCommande = new DaoCommande();
    }
    public function showAll()
    {
        //On appelle la méthode qui permet d'afficher la barre de recherche
        $recherche = $this->daoCommande->rechercheCommande();
        //On récupère la methode de daoClient qui recherche les clients
        //et qui les retourne sous forme de variable $contenu que l'on passe à la vue concernée.
        $contenu = $this->daoCommande->afficherCommandes();
        require('../views/Layout.php');
    }
}