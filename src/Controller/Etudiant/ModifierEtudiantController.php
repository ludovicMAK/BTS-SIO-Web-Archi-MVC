<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Model\etudiantModel;

class ModifierEtudiantController implements ControllerInterface
{
    private $id;
    private $nom;
    private $prenom;
    private $mdp;
    private $mdpConfirmation;
    private $login;
    private $email;
    private $exist;
    public function inputRequest(array $tabInput)
    {

        if (isset($tabInput["VARS"]["id"])) {
            $this->id = $tabInput["VARS"]["id"];
        }
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
        $unEtudiant = new etudiantModel();
        $infoEtudiant = $unEtudiant->recupererUnEtudiantSelonUnID($this->id);
        $lstElementModifier = array();
        $lstEtudiant = $unEtudiant->selectionnerToutLesEtudiantSaufEtudiantChoisi($this->id);
        $mesMessagesErreur =[];
        if ($this->exist){

            if ( $this->nom != null){
                $lstElementModifier['nom'] = $lstUnElement=['nom',$this->nom];
            }
            if ($this->prenom != null){
                $lstElementModifier['prenom'] = $lstUnElement=['prenom',$this->prenom];
            }
            if ($this->mdp != null){
                $lstElementModifier['mdp'] = $lstUnElement=['motDePasse',sha1($this->mdp)];
            }
            if ($this->login != null){
                $lstElementModifier['login'] = $lstUnElement=['login',$this->login];
            }
            if ($this->email != null){
                $lstElementModifier['email'] = $lstUnElement=['email',$this->email];
            }

            $memeEmail= false;
            $memeLogin = false;
            foreach ($lstEtudiant as $value){

                if ($value->getEmail() == $this->email){
                    $memeEmail = true;
                    array_push($mesMessagesErreur,"Ce mail existe déja");

                }
                if ($value->getLogin() == $this->login){
                    $memeLogin = true;
                    array_push($mesMessagesErreur,"Cette login existe déja");

                }
            }
            $verifEmail=true;
            $sanitized_email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)){
                array_push($mesMessagesErreur,"Veuillez saisir un bon format d' email SVP");
                $verifEmail =false;
            }
            $data ="";
            foreach ($lstElementModifier as $value){
                if ($value === end($lstElementModifier)){
                    $data .= $value[0]." = '".$value[1]."' ";
                }
                else{
                    $data .= $value[0]." = '".$value[1]."' , ";
                }
            }
            if ($memeEmail == false && $memeLogin ==false && $verifEmail == true){
                $unEtudiant->updateEtudiant($data,$this->id);

            }

            if (count($mesMessagesErreur) != 0){
                return TwigCore::getEnvironment()->render(
                    'Etudiant/formModifierEtudiant.html.twig',
                    [
                        "login"=>$infoEtudiant->getLogin(),
                        "email"=>$infoEtudiant->getEmail(),
                        "prenom"=>$infoEtudiant->getPrenom(),
                        "nom"=>$infoEtudiant->getNom(),
                        "erreur"=>$mesMessagesErreur
                    ]);
            }
            else{
                return TwigCore::getEnvironment()->render(
                    'Etudiant/tblEtudiant.html.twig',
                    [
                        "tblEtudiant"=>$unEtudiant->obtenirLesEtudiant()
                    ]);
            }

        }


        return TwigCore::getEnvironment()->render(
            'Etudiant/formModifierEtudiant.html.twig',
            [
                "login"=>$infoEtudiant->getLogin(),
                "email"=>$infoEtudiant->getEmail(),
                "prenom"=>$infoEtudiant->getPrenom(),
                "nom"=>$infoEtudiant->getNom(),
            ]);
    }
}