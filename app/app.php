<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";
    session_start();
    if (empty($_SESSION['contact_array'])) {
        $_SESSION['contact_array'] = array();
    }
    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../view'
    ));
    // home page has input for places
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/add", function() use ($app) {
        return $app['twig']->render('add.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/submit", function() use ($app) {
        $new_contact = new Contact(ucfirst(strtolower($_POST['name'])), ucfirst(strtolower($_POST['address'])), $_POST['phone']);
        $new_contact->save();
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });



    return $app;
?>
