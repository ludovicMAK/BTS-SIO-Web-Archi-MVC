<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Model\etudiantModel;

class SupprimerEtudiantController implements ControllerInterface
{
    private $id;
    public function inputRequest(array $tabInput)
    {
        if (isset($tabInput["VARS"]["id"])) {
            $this->id = $tabInput["VARS"]["id"];
        }
    }

    public function outputEvent()
    {
        $etudiant = new etudiantModel();
        $etudiant->deleteEtudiant($this->id);
        return TwigCore::getEnvironment()->render(
            'Etudiant/tblEtudiant.html.twig',
            [
                "tblEtudiant"=>$etudiant->obtenirLesEtudiant()
            ]);
    }
}