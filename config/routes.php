<?php

function check_logged_in()
{
    BaseController::check_logged_in();
}
$routes->get('/', function () {
    AuctionatorController::index();
});

$routes->get('/kayttaja/:id', 'check_logged_in', function ($id) {
    KayttajaController::page($id);
});

$routes->get('/admin', 'check_logged_in', function () {
    AuctionatorController::admin();
});

$routes->get('/listaus', function () {
    IlmoitusController::index();
});

$routes->get('/ilmoitus/:id', 'check_logged_in', function ($id) {
    IlmoitusController::ilmoitus($id);
});

// todo Poista lopuksi
$routes->get('/hiekkalaatikko', function () {
    AuctionatorController::sandbox();
});

$routes->get('/muokkaa/kayttaja', 'check_logged_in', function () {
    AuctionatorController::kayttajaMuokkaus();
});

$routes->get('/ilmoitus/muokkaa/:id', 'check_logged_in', function ($id) {
    IlmoitusController::edit($id);
});

$routes->get('/login', function () {
    KayttajaController::login();
});

$routes->get('/kayttaja/new', function () {
    KayttajaController::create();
});

$routes->get('/admin/listaus', 'check_logged_in', function () {
    AdminController::ilmoitusList();
});

$routes->get('/admin/kayttajat', 'check_logged_in', function () {
    AdminController::kayttajaList();
});

$routes->get('/new/ilmoitus/', 'check_logged_in', function () {
    IlmoitusController::create();
});

$routes->get('/new/kayttaja/', function () {
    KayttajaController::create();
});

$routes->get('/kayttaja/muokkaa/:id', 'check_logged_in', function ($id) {
    KayttajaController::edit($id);
});

$routes->post('/new/ilmoitus/', 'check_logged_in', function () {
    IlmoitusController::store();
});

$routes->post('/ilmoitus/muokkaa/:id', 'check_logged_in', function ($id) {
    IlmoitusController::update($id);
});

$routes->post('/new/ilmoitus/', 'check_logged_in', function () {
    IlmoitusController::store();
});

$routes->post('/new/kayttaja/', function () {
    KayttajaController::store();
});

$routes->post('/new/huuto/:ilmoitusId', 'check_logged_in', function ($ilmoitusId) {
    HuutoController::store($ilmoitusId);
});

$routes->post('/kayttaja/muokkaa/:id', 'check_logged_in', function ($id) {
    KayttajaController::update($id);
});

$routes->post('/login', function () {
    KayttajaController::handle_login();
});

$routes->post('/logout', 'check_logged_in', function () {
    KayttajaController::logout();
});

$routes->post('/delete/ilmoitus/:id', 'check_logged_in', function ($id) {
    IlmoitusController::destroy($id);
});

$routes->post('/delete/kayttaja/:id', 'check_logged_in', function ($id) {
    KayttajaController::destroy($id);
});

$routes->post('/delete/huuto/:id', 'check_logged_in', function ($id) {
    HuutoController::destroy($id);
});