<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('spk', 'Spk::index');

$routes->group('auth', static function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('register', 'Auth::register');
    $routes->post('login', 'Auth::login');
    $routes->get('read/(:any)', 'Auth::read/$1');
    $routes->post('setrole', 'Auth::setrole');
    $routes->get('out', 'Auth::logout');
    $routes->get('getdataregis', 'Auth::getdataregis');
    $routes->post('daftar', 'Auth::daftar');
});

$routes->group('laboran', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Laboran::index');
    $routes->get('store', 'Admin\Laboran::store');
    $routes->get('read/(:any)', 'Admin\Laboran::read/$1');
    $routes->post('post', 'Admin\Laboran::post');
    $routes->put('put', 'Admin\Laboran::put');
    $routes->delete('delete/(:any)', 'Admin\Laboran::delete/$1');
});

$routes->group('jurusan', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Jurusan::index');
    $routes->get('store', 'Admin\Jurusan::store');
    $routes->get('read/(:any)', 'Admin\Jurusan::read/$1');
    $routes->post('post', 'Admin\Jurusan::post');
    $routes->put('put', 'Admin\Jurusan::put');
    $routes->delete('delete/(:any)', 'Admin\Jurusan::delete/$1');
});

$routes->group('kelas', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Kelas::index');
    $routes->get('store', 'Admin\Kelas::store');
    $routes->get('read/(:any)', 'Admin\Kelas::read/$1');
    $routes->post('post', 'Admin\Kelas::post');
    $routes->put('put', 'Admin\Kelas::put');
    $routes->delete('delete/(:any)', 'Admin\Kelas::delete/$1');
});

$routes->group('matakuliah', static function ($routes) {
    $routes->get('/', 'Admin\Matakuliah::index');
    $routes->get('store', 'Admin\Matakuliah::store');
    $routes->get('read/(:any)', 'Admin\Matakuliah::read/$1');
    $routes->post('post', 'Admin\Matakuliah::post');
    $routes->put('put', 'Admin\Matakuliah::put');
    $routes->delete('delete/(:any)', 'Admin\Matakuliah::delete/$1');
});

$routes->group('modul', static function ($routes) {
    $routes->get('/', 'Admin\Modul::index');
    $routes->get('store', 'Admin\Modul::store');
    $routes->get('read/(:any)', 'Admin\Modul::read/$1');
    $routes->post('post', 'Admin\Modul::post');
    $routes->put('put', 'Admin\Modul::put');
    $routes->delete('delete/(:any)', 'Admin\Modul::delete/$1');
});

$routes->group('ta', static function ($routes) {
    $routes->get('/', 'Admin\Ta::index');
    $routes->get('store', 'Admin\Ta::store');
    $routes->get('read/(:any)', 'Admin\Ta::read/$1');
    $routes->post('post', 'Admin\Ta::post');
    $routes->put('put', 'Admin\Ta::put');
    $routes->delete('delete/(:any)', 'Admin\Ta::delete/$1');
});

$routes->group('jadwal', static function ($routes) {
    $routes->get('/', 'Admin\Jadwal::index');
    $routes->get('store', 'Admin\Jadwal::store');
    $routes->get('read/(:any)', 'Admin\Jadwal::read/$1');
    $routes->post('post', 'Admin\Jadwal::post');
    $routes->put('put', 'Admin\Jadwal::put');
    $routes->delete('delete/(:any)', 'Admin\Jadwal::delete/$1');
});


$routes->group('kontrak', static function ($routes) {
    $routes->get('/', 'Mahasiswa\Kontrak::index');
    $routes->get('store', 'Mahasiswa\Jadwal::store');
    $routes->get('read/(:any)', 'Mahasiswa\Jadwal::read/$1');
    $routes->post('post', 'Mahasiswa\Jadwal::post');
    $routes->put('put', 'Mahasiswa\Jadwal::put');
    $routes->delete('delete/(:any)', 'Mahasiswa\Jadwal::delete/$1');
});



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
