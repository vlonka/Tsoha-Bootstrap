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

$routes->get('/opiskelijat', function(){
  Opiskelijat_Controller::index();
});

$routes->get('/uusioppilas', function(){
  Opiskelijat_Controller::create();
});

$routes->post('/uusioppilas', function(){
  Opiskelijat_Controller::store();
});

$routes->get('/opiskelijat/:id', function($id){
  Opiskelijat_Controller::hyypio($id);
});

$routes->get('/opiskelijat/:id/muokkaa', function($id){
  Opiskelijat_Controller::edit($id);
});
$routes->post('/opiskelijat/:id/muokkaa', function($id){
  Opiskelijat_Controller::update($id);
});

$routes->post('/opiskelijat/:id/poista', function($id){
  Opiskelijat_Controller::destroy($id);
});