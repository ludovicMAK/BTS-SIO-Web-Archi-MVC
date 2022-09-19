<?php

namespace Quizz\Controller\Dynamique;
use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Service\TwigService;

class DynamiqueController implements ControllerInterface

{
    private $titre;

    public function inputRequest(array $tabInput)
    {
        if (isset($tabInput["VARS"]["titre"])) {
            $this->titre = $tabInput["VARS"]["titre"];
        }
    }

    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();
        // Obj connect Mysql -> Obj Questionnaire
        if (isset($this->titre)) {
            return TwigCore::getEnvironment()->render(
                'Dynamique/dynamique.html.twig',
                [
                    'titre' => $this->titre
                ]);
        } else {
            return null;
        }
    }

}