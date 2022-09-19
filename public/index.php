<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Quizz\Core\Controller\FastRouteCore;

// Gestion des fichiers environnement
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();


// Couche Controller
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', 'Quizz\Controller\HomeController');
    $route->addRoute('GET', '/lister', 'Quizz\Controller\Questionnaire\ListController');
    $route->addRoute('GET', '/detail/{id:\d+}', 'Quizz\Controller\Questionnaire\ViewController');
    $route->addRoute('GET','/HelloWord','Quizz\Controller\HelloWorldController');
    $route->addRoute('GET','/dynamique/{titre:\w+}','Quizz\Controller\Dynamique\DynamiqueController');
    $route->addRoute(['GET', 'POST'],'/etudiant/formulaire','Quizz\Controller\formulaire\formulaireController');
    $route->addRoute(['GET', 'POST'],'/etudiant', 'Quizz\Controller\Etudiant\AffichageEtudiantController');
    $route->addRoute(['GET', 'POST'],'/etudiant/delete/{id:\w+}', 'Quizz\Controller\Etudiant\SupprimerEtudiantController');
    $route->addRoute(['GET', 'POST'],'/etudiant/update/{id:\w+}', 'Quizz\Controller\Etudiant\ModifierEtudiantController');


});
// Dispatcher -> Couche view
echo FastRouteCore::getDispatcher($dispatcher);

