<?php

namespace Quizz\Controller\formulaire;
use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Model\etudiantModel;

class formulaireController implements ControllerInterface
{
    private $nom;
    private $prenom;
    private $mdp;
    private $mdpConfirmation;
    private $login;
    private $email;
    private $exist;

    public function inputRequest(array $tabInput)
    {

            if(isset($tabInput["POST"]["nom"]) ){
                if($tabInput["POST"]["nom"]!=""){
                    $this->nom = $tabInput["POST"]["nom"];
                }
            }
        if(isset($tabInput["POST"]["prenom"]) ){
            if($tabInput["POST"]["prenom"]!=""){
                $this->prenom = $tabInput["POST"]["prenom"];
            }
        }
        if(isset($tabInput["POST"]["mdp"]) ){
            if($tabInput["POST"]["mdp"]!=""){
                $this->mdp = $tabInput["POST"]["mdp"];
            }
        }
        if(isset($tabInput["POST"]["mdpConfirmation"]) ){
            if($tabInput["POST"]["mdpConfirmation"]!=""){
                $this->mdpConfirmation = $tabInput["POST"]["mdpConfirmation"];
            }
        }

        if(isset($tabInput["POST"]["login"]) ){
            if($tabInput["POST"]["login"]!=""){
                $this->login = $tabInput["POST"]["login"];
            }
        }
        if(isset($tabInput["POST"]["email"]) ){
            if($tabInput["POST"]["email"]!=""){
                $this->email = $tabInput["POST"]["email"];
            }
        }

        $this->exist = false;

        if(isset($tabInput["POST"]["valid_inscription"])){
            $this->exist = true;
        }
    }

    public function outputEvent()
    {

            $mesMessagesErreur =[];

            if ($this->exist){

                if ( $this->nom == null){
                    array_push($mesMessagesErreur,"Veuillez saisir un nom SVP");
                }
                if ($this->prenom == null){
                    array_push($mesMessagesErreur,"Veuillez saisir un prenom SVP");
                }
                if ($this->mdp == null){
                    array_push($mesMessagesErreur,"Veuillez saisir un mot de passe SVP");
                }
                if ($this->login == null){
                    array_push($mesMessagesErreur,"Veuillez saisir un login SVP");
                }
                if ($this->email == null){
                    array_push($mesMessagesErreur,"Veuillez saisir un email SVP");
                }
                    $memeMDP = true;
                if ($this->mdp != $this->mdpConfirmation){
                    array_push($mesMessagesErreur,"Le mot de passe n' est pas identique");
                    $memeMDP = false;
                }
                $verifEmail=true;
                $sanitized_email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
                if(!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)){
                    array_push($mesMessagesErreur,"Veuillez saisir un bon format d' email SVP");
                    $verifEmail =false;
                }
                if ($this->email !=null && $this->login !=null && $this->mdp != null && $this->nom !=null && $this->prenom !=null && $memeMDP == true && $verifEmail == true){
                    $etudiant = new etudiantModel();
                    $etudiant->creerNouveauxEtudiant($this->login,sha1($this->mdp),$this->nom,$this->prenom,$this->email);
                    array_push($mesMessagesErreur,"Votre êtes bien inscript");
                }
            }


        return TwigCore::getEnvironment()->render(
            'formulaire/inscription.html.twig',
            [
                'erreur'=>$mesMessagesErreur
            ]);


    }
}