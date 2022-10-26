<?php
require_once('FonctionsBdd.php');
require_once('../utilitaires/FonctionsUtiles.php');
require_once('../models/Client.php');
//***********************************************CLIENT  CLIENT  CLIENT
//***********************************************CLIENT  CLIENT  CLIENT
//***********************************************CLIENT  CLIENT  CLIENT
class DaoClient
{
    public function __construct()
    {
    }

//CETTE FONCTION PERMET DE CREER UN NOUVEAU CLIENT
    function createClient(): string
    {
        if (isset($_POST['submitCreerClient'])){
            if ($_POST['clientPassword'] !== $_POST['clientPasswordConfirm'])
                header('location:../../erreur.html');
        }else{
        $client = new Client(0, $_POST['ClientBirthday'], $_POST['ClientNom'], $_POST['ClientPrenom'], $_POST['ClientMail'], $_POST['ClientPassword']);
        $query = "INSERT INTO client (`CLIENT_PRENOM`,`CLIENT_NOM`,`CLIENT_NAISSANCE`,`CLIENT_MAIL`,`CLIENT_PASSWORD`) values ( " . "'" . $client->getClientPrenom() . "'" . "," . "'" . $client->getClientNom() . "'" . "," . "'" . $client->getClientNaissance() . "'" . "," . "'" . $client->getclientMail() . "'" . "," . "'" . $client->getClientPassword() . "'" . ")";
        //ON APPELLE LA FONCTION QUI VA  EXECUTER LA REQUETE
        executeQuery($query);
        }
        return $where = "CLIENT_ID=(SELECT max(CLIENT_ID) FROM client)";
    }

//CETTE FONCTION PERMET DE METTRE A JOUR UN CLIENT
    function updateClient(): string
    {
        if (isset($_POST['submitModifierClient'])){
            if ($_POST['clientPassword'] !== $_POST['clientPasswordConfirm'])
                echo 'ez';
        }else {
            $client = new Client($_POST['ClientId'], $_POST['ClientBirthday'], $_POST['ClientNom'], $_POST['ClientPrenom'], $_POST['ClientMail'], $_POST['ClientPassword']);

            $query = "UPDATE client SET CLIENT_PRENOM = '" . $client->getClientPrenom() . "',CLIENT_NOM = '" . $client->getClientNom() . "',CLIENT_NAISSANCE = '" . $client->getClientNaissance() . "',CLIENT_MAIL= '" . $client->getClientMail() . "',CLIENT_PASSWORD = '" . $client->getClientPassword() . "'WHERE  CLIENT_ID = " . $client->getClientId() . ";";
            //ON APPELLE LA FONCTION QUI VA  EXECUTER LA REQUETE
            executeQuery($query);

            //ON RENVOIE L ID DU CLIENT AU CONTROLEUR POUR QU il LE TRANSMETTE A LA VUE AFFICHERCLIENTS
            $id = $client->getClientId();
        }
        return $where = "CLIENT_ID=" . $id;
    }

//CETTE FONCTION PERMET DE SUPPRIMER UN CLIENT
    function deleteClient(): void
    {
        $id = $_POST['clientId'];
        $query = "DELETE FROM client WHERE CLIENT_ID = " . $id;
        executeQuery($query);
    }

    //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENT
    function readClient($where = null): array
    {
        if ($where != null) {
            $query = "SELECT CLIENT_PRENOM, CLIENT_NOM, CLIENT_NAISSANCE,CLIENT_MAIL,CLIENT_PASSWORD,CLIENT_ID
                                    FROM client 
                                    WHERE " . $where;
        } else {
            $query = "SELECT CLIENT_PRENOM, CLIENT_NOM, CLIENT_NAISSANCE,CLIENT_MAIL,CLIENT_PASSWORD,CLIENT_ID
                                    FROM client 
                                    ORDER BY CLIENT_NOM";
        }

        //ON APPELLE LA FONCTION QUI VA FAIRE LA CONNECTION ET RENVOYER UN RÉSULTAT
        $result = executeQuery($query);
        $lesClients = array();
        foreach ($result as $row) {
            $client = new client($row['CLIENT_ID'], $row['CLIENT_MAIL'], $row['CLIENT_NAISSANCE'], $row['CLIENT_NOM'], $row['CLIENT_PASSWORD'], $row['CLIENT_PRENOM']);
            array_push($lesClients, $client);
        }
        return $lesClients;
    }

    //CETTE FONCTION PERMETS D'AFFICHER LES INFORMATIONS DU CLIENT
    function afficherClients($where = null): string
    {

        if (!empty($_POST['nomClient'])) {
            /* récupérer les données du formulaire en utilisant
               la valeur des attributs name comme clé
              */
            $id = $_POST['nomClient'];
            $where = "CLIENT_ID=" . $id;
        }

        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT UN OU PLUSIEURS OBJETS DE TYPE CLIENTS
        $lesClients = $this->readClient($where);
        //ON AFFICHE LE HTML POUR LE FICHIER "AfficherClients"
        $contenu =
            "<section id='slogan'>
        <h2>Catalogue Clients</h2></div ></section><div id='menu'>";
        foreach ($lesClients as $client) {
            $id = $client->getClientId();
            $naissance = strftime('%d/%m/%Y', strtotime($client->getClientNaissance()));
            $signe = $client->getClientSigne();
            $contenu .= "<article class='article' >
            <div class='container' ><img class='image' src = '../assets/img/" . $signe . " ' alt=''></div >
             <h2 > " . $client->getClientPrenom() . ' ' . $client->getClientNom() . "</h2 >
             <p style='text-align: center;'> date de naissance " . $naissance . " 
             <br>" . $client->getClientAge() . " ANS</p><br>
            <button id='submit'>
                <a href = '../controllers/Controller.php?todo=modifierClient&id=$id'>MODIFIER OU SUPPRIMER LE CLIENT</a>
            </button><br>
          
                <a href = '../controllers/Controller.php?todo=passerCommande&id=$id'>PASSER UNE COMMANDE</a>
         
 </article > ";
        }
        return $contenu;
    }

//CETTE FONCTION PERMET D'AFFICHER UN FORMULAIRE DE RECHERCHE DE CLIENTS
    function rechercheClient(): string
    {    //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE TOUS LES Client SOUS FORME DE TABLEAU D'OBJETS
        $lesClients = $this->readClient(null);

        //ON AFFICHE LE HTML POUR LE FICHIER "ModifierClients"
        $recherche = "
<form name='searchProduct' action='../controllers/Controller.php' method='post' class='search-form'>
            <input type='hidden' name='todo' value='afficherClients'>
    <label for='nomClient' hidden></label>
    <select name='nomClient' id='nomClient' class='header-select' onchange='this.form.submit()'>
        <option value=''>Choisir un client</option>";
        foreach ($lesClients as $client) {
            $recherche .= "<option value=" . $client->getClientId() . ">" . $client->getClientPrenom() . ' ' . $client->getClientNom() . "</option>";
        }

        $recherche .= "</select>
</form>";

        return $recherche;
    }
//CETTE FONCTION PREND EN GET DANS L URL UN ID Client
//ET RENVOIE Client
    function afficherFormModif(): Client
    {
        $id = $_GET['id'];
        $where = "CLIENT_ID=" . $id;
        //ON APPELLE LA FONCTION QUI VA FAIRE LA REQUETE AUPRES DE LA BASE DE DONNEES
        //CETTE FONCTION RENVOIE UN TABLEAU CONTENANT LE Client A MODIFIER
        //ON RETOURNE CET OBJET Client AU CONTROLEUR QUI A APPELLE LA FONCTION
        //LE CONTROLEUR RETOURNERA L'OBJET A LA VUE "ModifierClient";
        return $this->readClient($where)[0];
    }


    function login(): string
    {
        $email = $_POST['clientMail'];
        $password = $_POST['clientPassword'];

        $email=stripcslashes($email);
        $password=stripcslashes($password);
        $where = "(CLIENT_MAIL = '" .  $_POST['clientMail'] ."' )and( CLIENT_PASSWORD =  '" .  $_POST['clientPassword'] . "')";
        $client = $this->readClient($where);
        $result=executeQuery($client);
        if($result !== false){
            foreach ($result as $row) {
                $client = new client($row['CLIENT_ID'], $row['CLIENT_MAIL'], $row['CLIENT_NAISSANCE'], $row['CLIENT_NOM'], $row['CLIENT_PASSWORD'], $row['CLIENT_PRENOM']);
                array_push($lesClients, $client);
            }
            echo "<h1>Login successful</h1>";
            header("location: ../controllers/Controller.php?todo=afficherClients");
            if (!isset($_SESSION))
            {
                session_start();
            }

            $_SESSION["client"] = [
                "id" => $client->getClientId(),
                "prenom" => $client->getClientPrenom(),
                "nom" => $client->getClientNom()
            ];

        } else{
            echo"<h1>Login failed. Invalid username or password.</h1>";
        }
        return $this->afficherClients($where);
    }















}