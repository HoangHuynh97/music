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

// home
$routes->get('/', 'Home::index');

// menu
$routes->get('/menu', 'Home::menu');

// login
$routes->get('/login', 'Login::index');
$routes->post('/login/check-login', 'Login::checkLogin');

// upload
$routes->post('/upload/setData', 'Upload::setData');

//API
$routes->post('/api_login', 'Home::api_login');
$routes->post('/api_signup', 'Home::api_signup');
$routes->post('/upload_song', 'Home::upload_song');
$routes->post('/get_DataSong', 'Home::get_DataSong');
$routes->post('/add_playlist', 'Home::add_playlist');
$routes->post('/get_Singer', 'Home::get_Singer');
$routes->post('/get_Playlist', 'Home::get_Playlist');
$routes->post('/search_song', 'Home::search_song');
$routes->post('/search_song_byName', 'Home::search_song_byName');
$routes->post('/get_DataProfile', 'Home::get_DataProfile');
$routes->post('/add_like', 'Home::add_like');
$routes->post('/del_like', 'Home::del_like');
$routes->post('/add_like_playlist', 'Home::add_like_playlist');
$routes->post('/add_like_byURL', 'Home::add_like_byURL');
$routes->post('/del_like_byURL', 'Home::del_like_byURL');
$routes->post('/check_like', 'Home::check_like');
$routes->post('/get_DataNew', 'Home::get_DataNew');
$routes->post('/get_playlist_id', 'Home::get_playlist_id');
$routes->post('/add_song_playlist', 'Home::add_song_playlist');
$routes->post('/get_ramdom_song', 'Home::get_ramdom_song');
$routes->post('/get_song_by_url', 'Home::get_song_by_url');


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
