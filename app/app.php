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

    // $app->get("/stylists", function() use ($app) {
    //     return $app['twig']->render('stylist.html.twig', array('stylists' => Stylist::getAll()));
    // });

    $app->post("/stylists", function() use ($app) {
        $stylist_name = $_POST['stylist_name'];
        $new_stylist = new Stylist($stylist_name, $id = null);
        $new_stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    // $app->get("/clients", function() use ($app) {
    //     return $app['twig']->render('stylist.html.twig', array('clients' => Client::getAll()));
    // });

    $app->get('/stylist/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($client_name, $stylist_id, $id = null);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist-> getClients()));
    });
    //
    // $app->get("/clients/{id}", function ($id) use ($app) {
    //     $client = Client::find($id);
    //     return $app['twig']->render("client.html.twig", array('client' => $client, 'stylists' => $client->getClients()));
    // });
    //
    // $app->patch("/clients/{id}", function($id) use ($app) {
    //   $client_name = $_POST['client_name'];
    //   $client = Client::find($id);
    //   $client->updateClientName($client_name);
    //   return $app['twig']->render("client_edit.html.twig", array('stylists' => Stylist::getAll()));
    // });
    //
    $app->get('/stylists/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });
    //
    // $app->delete('/clients/{id}', function($id) use ($app) {
    //     $client = Client::find($id);
    //     $client->delete();
    //     return $app['twig']->render('client_edit.html.twig', array('stylists' => Stylist::getAll()));
    // });
    //
    // $app->post("/delete_stylists", function() use ($app) {
    //     Stylist::deleteAll();
    //     return $app['twig']->render('index.html.twig');
    // });
    //
    // $app->post("/delete_clients", function() use ($app) {
    //     Client::deleteAll();
    //     return $app['twig']->render('index.html.twig');
    //   });

    return $app;
?>
