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
    KayttajaController::login();
});

$routes->get('/kayttaja/new', function () {
    KayttajaController::create();
});

$routes->get('/admin/listaus', function () {
    AdminController::ilmoitusList();
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

$routes->get('/kayttaja/muokkaa/:id', function ($id) {
    KayttajaController::edit($id);
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

$routes->post('/new/huuto/:ilmoitusId', function ($ilmoitusId) {
    HuutoController::store($ilmoitusId);
});

$routes->post('/kayttaja/muokkaa/:id', function ($id) {
    KayttajaController::update($id);
});

$routes->post('/login', function () {
    KayttajaController::handle_login();
});

$routes->post('/delete/ilmoitus/:id', function ($id) {
    IlmoitusController::destroy($id);
});

$routes->post('/delete/kayttaja/:id', function ($id) {
    KayttajaController::destroy($id);
});

$routes->post('/delete/huuto/:id', function ($id) {
    HuutoController::destroy($id);
});