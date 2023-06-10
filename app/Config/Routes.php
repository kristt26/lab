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
$routes->get('getmac', 'Pc::index');

$routes->group('getmac', static function ($routes) {
    $routes->get('/', 'Pc::index');
    $routes->post('post', 'Pc::post');
});
$routes->group('auth', static function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('register', 'Auth::register');
    $routes->post('login', 'Auth::login');
    $routes->post('auth', 'Auth::auth');
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

$routes->group('matakuliah', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Matakuliah::index');
    $routes->get('store', 'Admin\Matakuliah::store');
    $routes->get('read/(:any)', 'Admin\Matakuliah::read/$1');
    $routes->get('by_jurusan/(:any)', 'Admin\Matakuliah::by_jurusan/$1');
    $routes->post('post', 'Admin\Matakuliah::post');
    $routes->put('put', 'Admin\Matakuliah::put');
    $routes->delete('delete/(:any)', 'Admin\Matakuliah::delete/$1');
});

$routes->group('modul', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Modul::index');
    $routes->get('store', 'Admin\Modul::store');
    $routes->get('read/(:any)', 'Admin\Modul::read/$1');
    $routes->get('by_matakuliah/(:any)', 'Admin\Modul::by_matakuliah/$1');
    $routes->post('post', 'Admin\Modul::post');
    $routes->put('put', 'Admin\Modul::put');
    $routes->delete('delete/(:any)', 'Admin\Modul::delete/$1');
});

$routes->group('ta', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Ta::index');
    $routes->get('store', 'Admin\Ta::store');
    $routes->get('read/(:any)', 'Admin\Ta::read/$1');
    $routes->post('post', 'Admin\Ta::post');
    $routes->put('put', 'Admin\Ta::put');
    $routes->delete('delete/(:any)', 'Admin\Ta::delete/$1');
});

$routes->group('jadwal', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Jadwal::index');
    $routes->get('store', 'Admin\Jadwal::store');
    $routes->get('read/(:any)', 'Admin\Jadwal::read/$1');
    $routes->post('post', 'Admin\Jadwal::post');
    $routes->put('put', 'Admin\Jadwal::put');
    $routes->delete('delete/(:any)', 'Admin\Jadwal::delete/$1');
});

$routes->group('mahasiswa', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Mahasiswa::index');
    $routes->get('store', 'Admin\Mahasiswa::store');
    $routes->get('read/(:any)', 'Admin\Mahasiswa::read/$1');
    $routes->post('post', 'Admin\Mahasiswa::post');
    $routes->put('put', 'Admin\Mahasiswa::put');
    $routes->delete('delete/(:any)', 'Admin\Mahasiswa::delete/$1');
});

$routes->group('komponen_nilai', ['filter' => 'admin_auth'], static function ($routes) {
    $routes->get('/', 'Admin\Komponen::index');
    $routes->get('store', 'Admin\Komponen::store');
    $routes->get('read/(:any)', 'Admin\Komponen::read/$1');
    $routes->post('post', 'Admin\Komponen::post');
    $routes->put('put', 'Admin\Komponen::put');
    $routes->delete('delete/(:any)', 'Admin\Komponen::delete/$1');
});



// Mahasiswa


$routes->group('registration', ['filter'=> 'mahasiswa_auth'], static function ($routes) {
    $routes->get('/', 'Mahasiswa\Kontrak::index');
    $routes->get('store', 'Mahasiswa\Kontrak::store');
    $routes->get('read/(:any)', 'Mahasiswa\Kontrak::read/$1');
    $routes->post('post', 'Mahasiswa\Kontrak::post');
    $routes->put('put', 'Mahasiswa\Kontrak::put');
    $routes->delete('delete/(:any)', 'Mahasiswa\Kontrak::delete/$1');
});

$routes->group('daftar_laboran', static function ($routes) {
    $routes->get('/', 'Mahasiswa\DaftarLaboran::index');
    $routes->get('store', 'Mahasiswa\DaftarLaboran::store');
    $routes->get('read/(:any)', 'Mahasiswa\DaftarLaboran::read/$1');
    $routes->post('post', 'Mahasiswa\DaftarLaboran::post');
    $routes->put('put', 'Mahasiswa\DaftarLaboran::put');
    $routes->delete('delete/(:any)', 'Mahasiswa\DaftarLaboran::delete/$1');
});
$routes->group('praktikum', static function ($routes) {
    $routes->get('/', 'Mahasiswa\Praktikum::index');
    $routes->get('store', 'Mahasiswa\Praktikum::store');
    $routes->get('read/(:any)', 'Mahasiswa\Praktikum::read/$1');
    $routes->get('absenbyid/(:any)', 'Mahasiswa\Praktikum::absenbyid/$1');
    $routes->post('post', 'Mahasiswa\Praktikum::post');
    $routes->put('put', 'Mahasiswa\Praktikum::put');
    $routes->delete('delete/(:any)', 'Mahasiswa\Praktikum::delete/$1');
});

// Laboran

$routes->group('mengawas', static function ($routes) {
    $routes->get('/', 'Laboran\Mengawas::index');
    $routes->get('store', 'Laboran\Mengawas::store');
    $routes->get('read/(:any)', 'Laboran\Mengawas::read/$1');
    $routes->post('pertemuan', 'Laboran\Mengawas::pertemuan');
    $routes->post('post', 'Laboran\Mengawas::post');
    $routes->put('put', 'Laboran\Mengawas::put');
    $routes->delete('delete/(:any)', 'Laboran\Mengawas::delete/$1');
});
$routes->group('jadwal_mengawas', static function ($routes) {
    $routes->get('/', 'Laboran\Jadwal::index');
    $routes->get('store', 'Laboran\Jadwal::store');
    $routes->get('read/(:any)', 'Laboran\Jadwal::read/$1');
    $routes->post('post', 'Laboran\Jadwal::post');
    $routes->put('put', 'Laboran\Jadwal::put');
    $routes->delete('delete/(:any)', 'Laboran\Jadwal::delete/$1');
});

$routes->group('absen', static function ($routes) {
    $routes->get('insert/(:num)/(:num)', 'Absen::insert/$1/$2');
});

$routes->group('absen_rooms', static function ($routes) {
    $routes->get('(:num)', 'Laboran\Rooms::index/$1');
    $routes->get('store/(:num)', 'Laboran\Rooms::store/$1');
    $routes->get('by_pertemuan/(:num)/(:num)', 'Laboran\Rooms::by_pertemuan/$1/$2');
    $routes->post('post', 'Laboran\Rooms::post');
});

$routes->group('pertemuan', static function ($routes) {
    $routes->post('post', 'Laboran\Pertemuan::post');
    $routes->put('put', 'Laboran\Pertemuan::put');
    $routes->delete('delete/(:any)', 'Laboran\Pertemuan::delete/$1');
});

$routes->group('nilai', static function ($routes) {
    $routes->get('/', 'Laboran\Nilai::index');
    $routes->get('store', 'Laboran\Nilai::store');
    $routes->get('read/(:any)', 'Laboran\Nilai::read/$1');
    $routes->get('set/(:any)', 'Laboran\Nilai::set/$1');
    $routes->post('post', 'Laboran\Nilai::post');
    $routes->put('put', 'Laboran\Nilai::put');
    $routes->delete('delete/(:any)', 'Laboran\Nilai::delete/$1');
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
