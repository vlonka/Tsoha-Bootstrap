<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/listaussivu', function() {
    HelloWorldController::listaussivu();
});

$routes->get('/muokkausesittely', function() {
    HelloWorldController::muokkausesittely();
});

$routes->get('/opiskelijat', function() {
    Opiskelijat_Controller::index();
});

$routes->get('/uusioppilas', function() {
    Opiskelijat_Controller::create();
});

$routes->post('/uusioppilas', function() {
    Opiskelijat_Controller::store();
});

$routes->get('/opiskelijat/:id', function($id) {
    Opiskelijat_Controller::hyypio($id);
});

$routes->get('/opiskelijat/:id/muokkaa', function($id) {
    Opiskelijat_Controller::edit($id);
});

$routes->post('/opiskelijat/:id', function($id) {
    Opiskelijat_Controller::update($id);
});

$routes->post('/opiskelijat/:id/poista', function($id) {
    Opiskelijat_Controller::destroy($id);
});

$routes->get('/login', function() {
    Opiskelijat_Controller::login();
});
$routes->post('/login', function() {
    Opiskelijat_Controller::handle_login();
});

$routes->post('/logout', function() {
    Opiskelijat_Controller::logout();
});

$routes->get('/kurssit', function() {
    Kurssi_Controller::index();
});

$routes->get('/uusikurssi', function() {
    Kurssi_Controller::create();
});

$routes->post('/uusikurssi', function() {
    Kurssi_Controller::store();
});

$routes->get('/kurssit/:id', function($id) {
    Kurssi_Controller::opetus($id);
});

$routes->get('/kurssit/:id/muokkaa', function($id) {
    Kurssi_Controller::edit($id);
});

$routes->post('/kurssit/:id', function($id) {
    Kurssi_Controller::update($id);
});

$routes->post('/kurssit/:id/poista', function($id) {
    Kurssi_Controller::destroy($id);
});

$routes->get('/opettajat', function() {
    Opettajat_Controller::index();
});

$routes->get('/uusiopettaja', function() {
    Opettajat_Controller::create();
});

$routes->post('/uusiopettaja', function() {
    Opettajat_Controller::store();
});

$routes->get('/opettajat/:id', function($id) {
    Opettajat_Controller::ope($id);
});

$routes->get('/opettajat/:id/muokkaa', function($id) {
    Opettajat_Controller::edit($id);
});

$routes->post('/opettajat/:id', function($id) {
    Opettajat_Controller::update($id);
});

$routes->post('/opettajat/:id/poista', function($id) {
    Opettajat_Controller::destroy($id);
});

$routes->get('/login', function() {
    Opettajat_Controller::login();
});
$routes->post('/login', function() {
    Opettajat_Controller::handle_login();
});

$routes->post('/logout', function() {
    Opettajat_Controller::logout();
});