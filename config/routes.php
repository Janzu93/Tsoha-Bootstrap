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

$routes->get('/ilmoitus/:id', function ($id) {
    IlmoitusController::ilmoitus($id);
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

$routes->get('/kayttaja/new', function () {
    KayttajaController::create();
});

$routes->get('/admin/listaus', function () {
    adminController::ilmoitusList();
});

$routes->get('/admin/kayttajat', function () {
    KayttajaController::index();
});

$routes->get('/new/ilmoitus/', function () {
    IlmoitusController::create();
});

$routes->get('/new/kayttaja/', function () {
    KayttajaController::create();
});

$routes->post('/new/ilmoitus/', function () {
    IlmoitusController::store();
});

$routes->post('/ilmoitus/muokkaa/:id', function ($id) {
    IlmoitusController::update($id);
});

$routes->post('/new/ilmoitus/', function () {
    IlmoitusController::store();
});

$routes->post('/new/kayttaja/', function () {
    KayttajaController::store();
});