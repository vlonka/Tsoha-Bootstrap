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