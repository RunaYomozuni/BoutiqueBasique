<?PHP
//CETTE FONCTION ETABLI UNE CONNEXTION A UNE BASE DE DONNEE,  LA VERIFIE ET LA RENVOIE
function getConnection()
{
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = "boutiquebasique";

    $connection = new mysqli($servername, $username, $password, $database);
    if ($connection->connect_error) {
        echo 'échec de la connection <br>';
        die('Erreur : ' . $connection->connect_error);
    }
    //ON RENVOIE LA CONNECTION
    return $connection;
}

//CETTE FONCTION PREND UNE REQUETTE SQL "SELECT" (READ) EN PARAMETRE ET RENVOIE LE RESULTAT DE LA REQUETE
function executeQuery($request)
{
    $connection = getConnection();
    $result = $connection->query($request);
    $connection->close();
    //ON RENVOIE LE RESULTAT DE LA REQUETE SELECT (READ DU CRUD)
    return $result;
}

