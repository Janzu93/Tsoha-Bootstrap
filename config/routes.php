<?php

$routes->get('/', function () {
    AuctionatorController::index();
});

$routes->get('/admin', function () {
    AuctionatorController::admin();
});

$routes->get('/listaus', function () {
    AuctionatorController::listaus();
});

$routes->get('/ilmoitus', function () {
    AuctionatorController::ilmoitus();
});

// todo Poista lopuksi
$routes->get('/hiekkalaatikko', function () {
    AuctionatorController::sandbox();
});

$routes->get('/muokkaa/ilmoitus', function () {
    AuctionatorController::tuoteMuokkaus();
});

$routes->get('/muokkaa/kayttaja', function () {
    AuctionatorController::kayttajaMuokkaus();
});

$routes->get('/login', function () {
    AuctionatorController::login();
});

$routes->get('/register', function () {
    AuctionatorController::register();
});

$routes->get('/kayttaja', function () {
    AuctionatorController::kayttaja();
});

$routes->get('/admin/listaus', function () {
    AuctionatorController::adminListaus();
});

$routes->get('/admin/kayttajat', function () {
    AuctionatorController::adminKayttajat();
});