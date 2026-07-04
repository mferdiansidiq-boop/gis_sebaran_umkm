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
$routes->setTranslateURIDashes(true);
$routes->set404Override();



// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set $autoRoutesImproved to true in app/Config/Feature.php and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default route.

$routes->get('/', 'Home::index');
$routes->get('admin','Admin::index');
$routes->get('Admin','Admin::index');
$routes->get('admin/setting','Admin::Setting');
$routes->get('Admin/Setting','Admin::Setting');
$routes->post('Admin/UpdateSetting','Admin::UpdateSetting');
$routes->post('admin/updatesetting','Admin::UpdateSetting');
$routes->post('admin/updatesetting', 'Admin::updatesetting');
$routes->get('wilayah', 'Wilayah::index');
$routes->get('Wilayah', 'Wilayah::index');
$routes->get('Wilayah/Input', 'Wilayah::Input');
$routes->get('wilayah/input', 'Wilayah::Input');
$routes->get('wilayah/input', 'Wilayah::input');
$routes->get('wilayah/input', 'wilayah::input');
$routes->post('wilayah/proses-simpan', 'Wilayah::InsertData');
$routes->post('wilayah/proses-simpan', 'Wilayah::insertData');
$routes->post('wilayah/InsertData', 'Wilayah::InsertData');
$routes->post('wilayah/insert-data', 'Wilayah::InsertData');
$routes->post('wilayah/simpan', 'Wilayah::InsertData');
$routes->get('wilayah/Edit/(:num)', 'Wilayah::Edit/$1');
$routes->get('Wilayah/Edit/(:num)', 'Wilayah::Edit/$1');
$routes->post('wilayah/UpdateData/(:any)', 'Wilayah::UpdateData/$1');
$routes->post('Wilayah/UpdateData/(:any)', 'Wilayah::UpdateData/$1');
$routes->get('wilayah/Delete/(:num)', 'Wilayah::Delete/$1');
$routes->get('Wilayah/Delete/(:num)', 'Wilayah::Delete/$1');
//user
$routes->get('user', 'User::index');
$routes->get('User', 'User::index');
//UMKM
$routes->get('umkm', 'Umkm::index');
$routes->get('UMKM', 'Umkm::index');
//Skala Usaha
$routes->get('Skala-Usaha', 'SkalaUsaha::index');
$routes->get('skala-usaha', 'SkalaUsaha::index');
//Skala/UpdateData
$routes->add('Skalausaha/UpdateData/(:num)', 'Skalausaha::UpdateData/$1');
$routes->post('Skala-usaha/UpdateData/(:num)', 'Skalausaha::UpdateData/$1');
$routes->get('Skala-usaha', 'Skalausaha::index');
//Input Umpm
$routes->get('umkm/input', 'Umkm::Input');
$routes->post('umkm/input', 'Umkm::input');
$routes->get('Umkm/Input', 'Umkm::Input');
//Route AJAX Kabupaten
$routes->post('Umkm/Kabupaten', 'Umkm::Kabupaten');
$routes->get('Umkm/Kabupaten', 'Umkm::Kabupaten');
$routes->get('umkm/kabupaten', 'Umkm::Kabupaten');
//Route AJAX Kecamatan
$routes->post('Umkm/Kecamatan', 'Umkm::Kecamatan');
$routes->get('Umkm/Kecamatan', 'Umkm::Kecamatan');
$routes->get('umkm/kecamatan', 'Umkm::Kecamatan');

$routes->post('umkm/insertdata', 'Umkm::InsertData');
$routes->post('Umkm/InsertData', 'Umkm::InsertData');
$routes->get('umkm', 'Umkm::Index');
$routes->get('Umkm', 'Umkm::Index');

$routes->get('umkm/edit/(:num)', 'Umkm::Edit/$1');
$routes->get('Umkm/Edit/(:num)', 'Umkm::Edit/$1');
$routes->post('umkm/updatedata/(:num)', 'Umkm::UpdateData/$1');
$routes->post('Umkm/UpdateData/(:num)', 'Umkm::UpdateData/$1');
$routes->get('umkm/delete/(:num)', 'Umkm::Delete/$1');
$routes->get('Umkm/Delete/(:num)', 'Umkm::Delete/$1');

// --- ROUTE UNTUK SISTEM AUTENTIKASI LOGIN ---
$routes->get('login', 'Auth::Login');
$routes->post('ceklogin', 'Auth::CekLogin');
$routes->get('logout', 'Auth::Logout');

$routes->get('dashboard', 'Dashboard::index'); // Mengarah ke Controller Dashboard
$routes->get('auth/logout', 'Auth::logout');   // Mengarah ke Fungsi Logout di Controller Auth
$routes->get('Dashboard', 'Dashboard::index');

$routes->get('wilayah/(:num)', 'Home::wilayah/$1');




// Otomatis mendaftarkan semua sub-URL di dalam controller UMKM
$routes->group('umkm', static function ($routes) {
    $routes->add('/', 'UMKM::index');
    $routes->add('(:any)', 'UMKM::$1');
});

// Duplikat group untuk mengantisipasi jika ada pemanggilan dengan huruf kapital 'Umkm'
$routes->group('Umkm', static function ($routes) {
    $routes->add('/', 'UMKM::index');
    $routes->add('(:any)', 'UMKM::$1');
});



// Otomatis mendaftarkan semua sub-URL di dalam controller User (Huruf Kecil)
$routes->group('user', static function ($routes) {
    $routes->add('/', 'User::index');
    $routes->add('(:any)', 'User::$1');
});

// Duplikat group untuk mengantisipasi pemanggilan dengan huruf kapital 'User'
$routes->group('User', static function ($routes) {
    $routes->add('/', 'User::index');
    $routes->add('(:any)', 'User::$1');
});






/*
$routes->get('feedback', 'Feedback::index');
$routes->post('feedback/store', 'FeedbackPublic::store');


// Contoh rute untuk halaman "Sekolah"
$routes->get('sekolah', 'Sekolah::daftar');
$routes->get('sekolah/(:num)', 'Sekolah::detail/$1');

// Contoh rute untuk halaman "Profil"
$routes->get('profil', 'Profil::index');
$routes->get('profil/edit/(:num)', 'Profil::edit/$1');
$routes->post('profil/update/(:num)', 'Profil::update/$1');

// Contoh rute untuk halaman "Kontak"
$routes->get('kontak', 'Kontak::index');
$routes->post('kontak/kirim', 'Kontak::kirim');

// Contoh rute untuk API (jika Anda membangun API)
$routes->group('api', function ($routes) {
    $routes->get('sekolah', 'Api\Sekolah::index');
    $routes->post('sekolah', 'Api\Sekolah::create');
    $routes->get('sekolah/(:num)', 'Api\Sekolah::show/$1');
    $routes->put('sekolah/(:num)', 'Api\Sekolah::update/$1');
    $routes->delete('sekolah/(:num)', 'Api\Sekolah::delete/$1');
});
*/

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be organized in a sensible manner. For this, we recommend
 * using scoped routes. This will allow you to create groups of routes
 * that all share a common prefix. For example:
 *
 * $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
 * $routes->get('dashboard', 'Dashboard::index');
 * $routes->get('users', 'Users::index');
 * });
 */

/*
 * --------------------------------------------------------------------
 * Example Routes
 * --------------------------------------------------------------------
 *
 * When you are developing your site, you will need to tweak this section
 * often. (e.g. Add routes, remove routes, etc.)
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';


}
