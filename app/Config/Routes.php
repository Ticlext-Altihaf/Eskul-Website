<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//admin
$routes->get('/admin', 'Admin::index', ['filter' => 'authGuard', 'as' => 'admin']);
//$routes->get('/admin/manage', 'Admin::manage', ['filter' => 'authGuard', 'as' => 'admin.manage']);
$routes->get('/admin/manage/auth', 'Admin::auth', ['filter' => 'authGuard', 'as' => 'admin.auth']);
$routes->post('/admin/manage/auth', 'Admin::api', ['filter' => 'authGuard', 'as' => 'admin.api']);
$routes->get("/admin/manage/auth/delete/(:any)", 'Admin::delete/$1', ['filter' => 'authGuard', 'as' => 'admin.delete']);
$routes->post("/admin/manage/auth/add", 'Admin::add', ['filter' => 'authGuard', 'as' => 'admin.add']);
//Club Editor
$routes->get('/admin/manage/club', "Editor::index", ['filter' => 'authGuard']);
$routes->get('/admin/manage/club/add', "Editor::add", ['filter' => 'authGuard', 'as' => 'editor.add']);
$routes->post("/admin/manage/club/add", "Editor::add", ['filter' => 'authGuard', 'as' => 'editor.add']);
$routes->get("/admin/manage/club/delete-all", "Editor::deleteAll", ['filter' => 'authGuard', 'as' => 'editor.delete.all']);
$routes->get('/admin/manage/club/delete/(:any)', "Editor::delete/$1", ['filter' => 'authGuard', 'as' => 'editor.delete']);
$routes->get('/admin/manage/club/edit/(:any)', "Editor::edit/$1", ['filter' => 'authGuard', 'as' => 'editor.edit']);
$routes->post("/admin/manage/club/edit/(:any)", "Editor::edit/$1", ['filter' => 'authGuard', 'as' => 'editor.edit']);

//Auth
$routes->get('/login', 'Auth::login', ['as' => 'login']);
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout', ['filter' => 'authGuard', 'as' => 'logout']);

//User
$routes->get('/', 'Home::index');
$routes->get('/(:any)', 'Club::index/$1', ['as' => 'club']);


/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
