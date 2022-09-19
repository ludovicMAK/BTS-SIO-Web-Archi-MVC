<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Model\etudiantModel;

class AffichageEtudiantController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {
        // TODO: Implement inputRequest() method.
    }

    public function outputEvent()
    {
        $etudiant = new etudiantModel();
        return TwigCore::getEnvironment()->render(
            'Etudiant/tblEtudiant.html.twig',
            [
                "tblEtudiant"=>$etudiant->obtenirLesEtudiant()
            ]);
    }
}