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
