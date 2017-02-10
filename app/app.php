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
        $new_contact = new Contact(ucfirst(strtolower($_POST['name'])), ucfirst(strtolower($_POST['title'])), $_POST['year']);
        $new_contact->save();
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/search_name", function() use ($app) {
        $name_name = ucfirst(strtolower($_POST['contact_name']));
        return $app['twig']->render('list_by_name.html.twig', array('contacts' => Contact::getAll(), 'contact_name'=>$contact_name));
    });

    $app->post("/go_home", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/delete", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::delete()));
    });

    return $app;
?>
