<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=restapp');

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app['debug']=TRUE;

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurants", function() use ($app) {
        return $app['twig']->render('restaurants.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->get("/cuisines", function() use ($app) {
        return $app['twig']->render('cuisines.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/restaurants", function() use ($app) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $description, $address, $cuisine_id, $id = null);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisines.twig', array('cuisines' =>$cuisine,
            'restaurants' =>Restaurant::getAll()));
    });

    $app->post("/cuisines", function () use ($app) {
        $cuisine = new Cuisine($_POST['name']);
        $cuisine->save();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.twig');
    });

    return $app;

?>
