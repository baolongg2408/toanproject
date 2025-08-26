<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

<<<<<<< HEAD
// ====== PUBLIC ======
$routes->get('/', 'Profile::index');                 // Trang đầu: Profile
$routes->get('project/(:segment)', 'Projects::show/$1');

// Đăng nhập/đăng xuất (chỉ mở khi click)
$routes->match(['get','post'], 'login',  'Auth::login');   // KHÔNG map '/' vào login nữa
$routes->get('logout', 'Auth::logout');

// ====== ADMIN (có filter 'auth') ======
$routes->group('admin', ['filter' => 'auth'], static function($routes) {
  // Trang mặc định admin
  $routes->get('/', fn() => redirect()->to('/admin/albums'));

  // Albums
=======
$routes->match(['get','post'], '/', 'Auth::login');
$routes->match(['get','post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'auth'], static function($routes){

  // Albums (chủ đề)
  $routes->get('/', fn() => redirect()->to('/admin/albums'));
>>>>>>> feature/source-upload
  $routes->get('albums',                 'Admin\Albums::index');
  $routes->post('albums',                'Admin\Albums::create');
  $routes->post('albums/(:num)',         'Admin\Albums::update/$1');
  $routes->post('albums/(:num)/delete',  'Admin\Albums::delete/$1');

<<<<<<< HEAD
  // Sets
  $routes->get('albums/(:num)/sets',         'Admin\Sets::byAlbum/$1');
  $routes->post('albums/(:num)/sets',        'Admin\Sets::create/$1');
  $routes->post('sets/(:num)',               'Admin\Sets::update/$1');
  $routes->post('sets/(:num)/delete',        'Admin\Sets::delete/$1');

  // Photos
=======
  // Sets (bộ ảnh) theo album
  $routes->get('albums/(:num)/sets',         'Admin\Sets::byAlbum/$1');
  $routes->post('albums/(:num)/sets',        'Admin\Sets::create/$1');     // create set cho album
  $routes->post('sets/(:num)',               'Admin\Sets::update/$1');
  $routes->post('sets/(:num)/delete',        'Admin\Sets::delete/$1');

  // Photos theo set
>>>>>>> feature/source-upload
  $routes->get('sets/(:num)/photos',         'Admin\Photos::bySet/$1');
  $routes->post('sets/(:num)/photos/create', 'Admin\Photos::bulkCreate/$1');
  $routes->post('photos/(:num)',             'Admin\Photos::update/$1');
  $routes->post('photos/(:num)/delete',      'Admin\Photos::delete/$1');
<<<<<<< HEAD
  $routes->post('photos/bulk',               'Admin\Photos::bulkCreate'); // set_id trong POST
=======
    // Tạo ảnh: cho phép cả 2 cách
    $routes->post('photos/bulk',               'Admin\Photos::bulkCreate');    // set_id trong POST (tương thích)

  // Đặt cover
  $routes->post('sets/(:num)/cover/(:num)',  'Admin\Sets::setCover/$1/$2');   // set cover = photo
>>>>>>> feature/source-upload
});
