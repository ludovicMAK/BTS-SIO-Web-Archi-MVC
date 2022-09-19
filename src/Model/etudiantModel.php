<?php

namespace Quizz\Model;

use Quizz\Core\Service\DatabaseService;
use Quizz\Entity\Etudiant;

class etudiantModel
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = DatabaseService::getConnect();
    }
    public function creerNouveauxEtudiant(string $login,string $mdp,string $nom,string $prenom,string $email){
        $requete = $this->bdd->prepare("INSERT INTO `etudiants` (`idEtudiant`, `login`, `motDePasse`, `nom`, `prenom`, `email`) VALUES (NULL, '$login', '$mdp', '$nom', '$prenom', '$email')");
        $requete->execute();
    }
    public function obtenirLesEtudiant(){
        $requete = $this->bdd->prepare("SELECT * FROM `etudiants`");
        $requete->execute();

        $tabEtudiant = [];
        foreach ($requete->fetchAll() as $value){
            $unEtudiant = new Etudiant();
            $unEtudiant->setNom($value["nom"]);
            $unEtudiant->setPrenom($value["prenom"]);
            $unEtudiant->setEmail($value["email"]);
            $unEtudiant->setLogin($value["login"]);
            $unEtudiant->setIdEtudiant($value["idEtudiant"]);
            $tabEtudiant[] = $unEtudiant;
        }
        return $tabEtudiant;
    }
    public function deleteEtudiant(int $unId){
        $requete = $this->bdd->prepare('DELETE FROM `etudiants` WHERE `etudiants`.`idEtudiant` =' . $unId);
        $requete->execute();
    }
    public function updateEtudiant( string $data,int $unid){
        $requete = $this->bdd->prepare("UPDATE `etudiants` SET ".$data." WHERE `etudiants`.`idEtudiant` = ".$unid);
        $requete->execute();
    }
}