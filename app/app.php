<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";
    
    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
  $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('clients' => Client::getAll(), Stylist::getAll()));
    });

    $app->get("/stylists", function() use ($app) {
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/stylsits", function() use ($app) {
        $stylist_name = $_POST['stylist_name'];
        $new_stylist = new Stylist($stylist_name, $id = null);
        $new_stylist->save();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("clients", function() use ($app) {
      return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $new_client = new Client($client_name, $id = null);
        $new_client->save();
        return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
    });

    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig');
      });

    return $app;

    ?>
