<?php

$routes->get('/', function () {
    HelloWorldController::index();
});

$routes->get('/listaus', function () {
    HelloWorldController::listaus();
});

$routes->get('/hiekkalaatikko', function () {
    HelloWorldController::sandbox();
});
