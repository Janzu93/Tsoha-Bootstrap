<?php

$routes->get('/', function () {
    AuctionatorController::index();
});

$routes->get('/listaus', function () {
    AuctionatorController::listaus();
});

$routes->get('/ilmoitus', function () {
    AuctionatorController::ilmoitus();
});

//Tää lähtee pois kunhan kaikki toimii
$routes->get('/hiekkalaatikko', function () {
    AuctionatorController::sandbox();
});

$routes->get('/muokkaa', function () {
    AuctionatorController::muokkaus();
});

$routes->get('/login', function () {
    AuctionatorController::login();
});

$routes->get('/register', function () {
    AuctionatorController::register();
});