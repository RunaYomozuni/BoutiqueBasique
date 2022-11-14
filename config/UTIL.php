<?php

class UTIL
{

    /** Enregistrement de l'article **/
    public function store()
    {
        $stmt = $this->bdd->prepare("INSERT INTO article(Titre, Date, Photo, Texte, id_user  ) VALUES (?, NOW(), ?, ?, ?)");
        $retour = $stmt->execute(array(
            $_POST["name"],
            $_FILES["photo"]["name"],
            $_POST["texte"],
            $_SESSION["user"]["id"]
        ));


        $_SESSION["user"] = [
            "id" => $this->manager->getBdd()->lastInsertId(),
            "username" => $_POST["username"],
            "role" => $_POST["role"]
        ];
        return $retour;


    }

}

?>