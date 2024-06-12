<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/table', 'Table::index');
$routes->get('/datatable', 'Table::test');
$routes->get('/testtable', 'Table::test1');
$routes->get('/listtable', 'Table::listdata');
$routes->post('/create', 'Table::createDataByAjax');
$routes->put('/update/(:num)','Table::updateDataByAjax/$1');
$routes->delete('/delete/(:num)', 'Table::deleteDataByAjax/$1');

// $routes->get('/', 'Home::index');
$routes->get('/livetable', 'TableController::index');
$routes->get('/livedatatable', 'TableController::liveData');
$routes->post('/table/deleteDataByAjax', 'TableController::deleteDataByAjax');
$routes->post('/table/updateDataByAjax', 'TableController::updateDataByAjax');

// $routes->get('/testtable', 'Table::test');
// $routes->post('/listtable', 'Table::listData');
// $routes->post('/create', 'Table::createDataByAjax');
// $routes->post('/update', 'Table::updateDataByAjax');
// $routes->post('/delete', 'Table::deleteDataByAjax');