<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index'); //defaultnya
// akses metode request get, root / arahkan ke controller Home yang methodnya index

// $routes->get('/', 'Home::coba');

// $routes->get('/coba', 'Coba::about');
// http://localhost:8080/Coba

// $routes->get('/coba/index', 'Coba::index');
// http://localhost:8080/coba/index
// $routes->get('/coba/about', 'Coba::about');
// http://localhost:8080/coba/about

// $routes->get('/coba/(:any)/(:num)', 'Coba::about/$1/$2');
// placeholder ( ) apapun yang ditulis user, akan diarahkan ke Controller coba method about
// $1 akan menangkap :any
// $2 akan menangkap :num
// http://localhost:8080/coba/UGA/22

// $routes->get('/users', 'Admin\Users::index');

$routes->get('/', 'Pages::index');

$routes->get('/komik/create', 'Komik::create');

$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');

$routes->delete('/komik/(:num)', 'Komik::delete/$1');

$routes->get('/komik/(:any)', 'Komik::detail/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
