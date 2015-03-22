<?php
require 'vendor/autoload.php';
require_once 'EventRepository.php';
require_once 'Event.php';

$app = new \Slim\Slim();

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());


$app->get('/event/{EventId}(/)', function($EventId) use ($app) {
    $valid = filter_var($_POST['Name'], FILTER_VALIDATE_INT);
    if ( !$valid ) {
        throw new Exception("Invalid EventId");
    }

    $EventRepository = new EventRepository();

    if ( isset ($EventId) ) {
        $event = $EventRepository->getEvent($EventId);
        if ( empty($event) ) {
            $app->render(404,array(
                "error" => true,
                "msg" => "Not found"
            ));
        } else {
            $app->render(200,array(
                "event" => $event
            ));
        }
    } else {
        $app->render(400,array(
            "error" => true,
            "msg" => "Missing EventId, /event/{EventId}/"
        ));
    }

});

$app->post('/event(/)', function() use ($app) {
    $EventRepository = new EventRepository();
    $event = new Event();

    $event->Name = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
    $event->Description = filter_var($_POST['Description'], FILTER_SANITIZE_STRING);
    $event->LocationName = filter_var($_POST['LocationName'], FILTER_SANITIZE_STRING);

    $StartDatetime = filter_var($_POST['StartDatetime'], FILTER_SANITIZE_STRING);
    $EndDatetime = filter_var($_POST['EndDatetime'], FILTER_SANITIZE_STRING);
    $event->setDateTimes($StartDatetime, $EndDatetime);

    $addResult = $EventRepository->addEvent($event);
    if ( $addResult ) {
        $app->render(201, array(
            'msg' => 'successfully created',
            'url' => BASE_URL . 'event/' .  $addResult
        ));
    } else {
        $app->render(500, array(
            'msg' => 'creation failed'
        ));
    }
});

$app->get('/events(/)', function() use ($app) {
    $EventRepository = new EventRepository();
    $events = $EventRepository->getLatestEvents();

    if ( !empty($events) ) {
        $app->render(200, array("events" => $events));
    } else {
        $app->render(404, array(
            'msg' => 'No Events Found'
        ));
    }
});

$app->run();