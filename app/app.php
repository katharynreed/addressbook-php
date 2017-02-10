<?php

    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";
    session_start();
    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }
    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../view'
    ));
    // home page has input for places
    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/create_contact', function() use ($app) {
        return $app['twig']->render('add.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/submit', function() use ($app) {
        $new_contact = new Contact(ucwords(strtolower($_POST['name'])), ucwords(strtolower($_POST['address'])), $_POST['phone']);
        $new_contact->save();
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/search_contact', function() use ($app) {
        $contact_name = ucwords(strtolower($_POST['contact_name']));
        return $app['twig']->render('list_by_name.html.twig', array('contacts' => Contact::getAll(), 'contact_name'=>$contact_name));
    });

    $app->post('/go_home', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/delete_contacts', function() use ($app){
        return $app['twig']->render('delete_contacts.html.twig');
    });

    $app->post('/delete-one', function() use ($app){
        $_SESSION['list_of_contacts'] = array_values($_SESSION['list_of_contacts']);
        unset($_SESSION['list_of_contacts'][$_POST['name']]);
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/delete_confirmed', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('contacts' => Contact::delete()));
    });

    return $app;
?>
