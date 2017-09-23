<?php

$routes->get('/', function () {
    AuctionatorController::index();
});

$routes->get('/kayttaja/:id', function ($id) {
    KayttajaController::page($id);
});

$routes->get('/admin', function () {
    AuctionatorController::admin();
});

$routes->get('/listaus', function () {
    IlmoitusController::index();
});

$routes->get('/ilmoitus', function () {
    AuctionatorController::ilmoitus();
});

// todo Poista lopuksi
$routes->get('/hiekkalaatikko', function () {
    AuctionatorController::sandbox();
});

$routes->get('/muokkaa/kayttaja', function () {
    AuctionatorController::kayttajaMuokkaus();
});

$routes->get('/ilmoitus/muokkaa/:id', function ($id) {
    IlmoitusController::edit($id);
});

$routes->get('/login', function () {
    AuctionatorController::login();
});

$routes->get('/register', function () {
    AuctionatorController::register();
});

$routes->get('/admin/listaus', function () {
    adminController::ilmoitusList();
});

$routes->get('/admin/kayttajat', function () {
    KayttajaController::index();
});

$routes->get('/ilmoitus/new', function () {
    IlmoitusController::create();
});

$routes->post('/ilmoitus/uusi', function () {
    IlmoitusController::store();
});

$routes->post('/ilmoitus/muokkaa/:id', function ($id) {
    IlmoitusController::update($id);
});

$routes->post('/ilmoitus/new', function () {
    IlmoitusController::store();
});