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

$routes->post('/opiskelijat', function(){
  Opiskelijat_Controller::store();
});

$routes->get('/opiskelijat/uusioppilas', function(){
  Opiskelijat_Controller::save();
});

$routes->get('/opiskelijat/:id', function($id){
  Opiskelijat_Controller::hyypio($id);
});