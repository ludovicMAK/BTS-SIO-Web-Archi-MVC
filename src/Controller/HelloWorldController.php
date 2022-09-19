<?php

namespace Quizz\Controller;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Model\QuestionnaireModel;
use Quizz\Service\TwigService;

class HelloWorldController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {
        // TODO: Implement inputRequest() method.
    }

    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();
        // Obj connect Mysql -> Obj Questionnaire
        $questionnaireModel = new questionnaireModel();

        echo $twig->render('home/helloworld.html.twig', [
            'result' => $questionnaireModel->getFechAll(),
            'visu' => false
        ]);
    }
}