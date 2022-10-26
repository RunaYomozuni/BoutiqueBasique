<?php

class Client
{
    // DECLARATION DES ATTRIBUT DE LA CLASSE
    private int $clientId;
    private string $clientNom;
    private string $clientPrenom;
    private string $clientNaissance;
    private string $clientMail;
    private string $clientPassword;

    //METHODES ACCSSEURS (GETTER ANS SETTERS)

    //setter pour l'attribut produitId permet d'accéder en écriture à l'attribut
    //Cette méthode est une procedure(elle ne revoie rien)




    //----------------------------------------------------------------

    public function __construct(int $clientId,string $clientMail,string $clientNaissance,string $clientNom,string $clientPassword,string $clientPrenom){
        $this->setClientId($clientId);
        $this->setClientMail($clientMail);
        $this->setClientNaissance($clientNaissance);
        $this->setClientNom($clientNom);
        $this->setClientPassword($clientPassword);
        $this->setClientPrenom($clientPrenom);

    }

    /**
     * @return string
     */
    public function getClientMail(): string
    {
        return $this->clientMail;
    }

    /**
     * @param string $clientMail
     */
    public function setClientMail(string $clientMail): void
    {
        $this->clientMail = $clientMail;
    }

    /**
     * @return string
     */
    public function getClientPassword(): string
    {
        return $this->clientPassword;
    }

    /**
     * @param string $clientPassword
     */
    public function setClientPassword(string $clientPassword): void
    {
        $this->clientPassword = $clientPassword;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    //getter pour l'attribut clientId permet d'accéder en lecture à l'attribut
    //cette méthode est une fonction (elle renvoie un résultat typé)
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientPrenom(): string
    {
        return $this->clientPrenom;
    }

    /**
     * @param string $clientPrenom
     */
    public function setClientPrenom(string $clientPrenom): void
    {
        $this->clientPrenom = $clientPrenom;
    }

    /**
     * @return string
     */
    public function getClientNom(): string
    {
        return $this->clientNom;
    }

    /**
     * @param string $clientNom
     */
    public function setClientNom(string $clientNom): void
    {
        $this-> clientNom = $clientNom;
    }

    /**
     * @return string
     */
    public function getClientNaissance(): string
    {
        return $this->clientNaissance;
    }

    /**
     * @param string $clientNaissance
     */
    public function setClientNaissance(string $clientNaissance): void
    {
        $this->clientNaissance = $clientNaissance;
    }
    public function getClientAge(): int
    {
        return calculerAge($this->getClientNaissance());
    }

    public function getClientSigne(): string
    {
        $naissance = strftime('%d/%m/%Y', strtotime($this->getClientNaissance()));
        return $signe = trouverSigneZodiaque($naissance);
    }
}