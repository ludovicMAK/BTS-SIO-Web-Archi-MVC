<?php

namespace Quizz\Controller\Questionnaire;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\View\TwigCore;
use Quizz\Model\QuestionnaireModel;

class ListController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {
        // Nulle :)
    }

    public function outputEvent()
    {
        // Obj connect Mysql -> Obj Questionnaire
        $questionnaireModel = new QuestionnaireModel();
        var_dump($questionnaireModel->getFechAll());
        // Si y a pas de GET alors j'affiche tout
        return TwigCore::getEnvironment()->render(
            'questionnaire/list.html.twig',
            [
                'questionnaires' => $questionnaireModel->getFechAll()
            ]);
    }
}