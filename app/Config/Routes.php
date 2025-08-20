<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Create a new instance of our RouteCollection class
$routes->get('/', 'Home::index');


$routes->get('/program', 'Program::index');


$routes->get('/program/(:any)?', 'Program::detail/$1');

$routes->post('/midtrans', 'Midtrans::index');
$routes->post('/midtrans/notification', 'Midtrans::notification');
$routes->get('/midtrans/notification', 'Midtrans::notification');


$routes->get('/contact', 'Contact::index');


$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Logout::index');
$routes->post('/login', 'Login::process');


$routes->get('/register', 'Register::index');
$routes->POST('/register/save', 'Register::save');

//Group routes for apps
$routes->group('apps', ['namespace' => 'App\Controllers\Apps', 'filter' => 'auth'], function ($routes) {
    // Define the route for the apps index page
    $routes->get('/', 'Home::index');

    $routes->group('pengguna', function ($routes) {
        $routes->get('/', 'Pengguna::index');
        $routes->get('add', 'Pengguna::add');
        $routes->post('save', 'Pengguna::save');
        $routes->get('edit/(:any)', 'Pengguna::edit/$1');
        $routes->post('update/(:any)', 'Pengguna::update/$1');
        $routes->delete('delete/(:any)', 'Pengguna::delete/$1');
    });

    $routes->group('profile', function ($routes) {
        $routes->get('/', 'Profile::index');
        $routes->post('update', 'Profile::update');
        $routes->post('password/(:any)', 'Profile::password/$1');
    });

    // $routes->group('backup', function ($routes) {
    //     $routes->get('/', 'Backup::index');
    //     $routes->get('create', 'Backup::create');
    // });

    // $routes->group('backup', function($routes) {
    //     $routes->get('/', 'Backup::index');                    // Halaman utama backup
    //     $routes->post('create', 'Backup::create');             // Membuat backup
    //     $routes->post('restore', 'Backup::restore');           // Restore database
    //     $routes->get('download/(:segment)', 'Backup::download/$1'); // Download backup file
    //     $routes->get('delete/(:segment)', 'Backup::delete/$1'); // Delete backup file
    // });

    $routes->get('backup', 'Backup::index');
    $routes->post('backup/create', 'Backup::create');
    $routes->get('backup/create', 'Backup::create'); // Untuk backward compatibility
    $routes->post('backup/restore', 'Backup::restore');
    $routes->get('backup/download/(:segment)', 'Backup::download/$1');
    $routes->get('backup/delete/(:segment)', 'Backup::delete/$1');


    $routes->group('pengaturan', function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->post('update', 'Pengaturan::update');
    });

    $routes->group('instansi', function ($routes) {
        $routes->get('/', 'Instansi::index');
        $routes->post('update', 'Instansi::update');
    });

    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Laporan::index');
        $routes->get('(:any)', 'Laporan::list/$1');
    });

    $routes->group('program', function ($routes) {
        $routes->get('/', 'Program::index');
        $routes->get('add', 'Program::add');
        $routes->get('edit/(:segment)', 'Program::edit/$1'); // taruh di atas
        $routes->post('save', 'Program::save');
        $routes->post('update/(:any)', 'Program::update/$1');
        $routes->get('delete/(:num)', 'Program::delete/$1');
        $routes->get('(:any)', 'Program::detail/$1');
        // $routes->get('(:any)/(:any)', 'Program::detail/$1/$2'); // taruh di paling bawah
    });

    $routes->group('donatur', function ($routes) {
        $routes->get('/', 'Donatur::index');
        $routes->get('edit/(:any)', 'Donatur::edit/$1');
        $routes->post('update/(:any)', 'Donatur::update/$1');
        $routes->post('password/(:any)', 'Donatur::password/$1');
        $routes->get('delete/(:any)', 'Donatur::delete/$1');
    });

    $routes->group('fundraiser', function ($routes) {
        $routes->get('/', 'Fundraiser::index');
        $routes->get('add', 'Fundraiser::add');
        $routes->post('save', 'Fundraiser::save');
        $routes->get('edit/(:any)', 'Fundraiser::edit/$1');
        $routes->post('update/(:any)', 'Fundraiser::update/$1');
        $routes->post('password/(:any)', 'Fundraiser::password/$1');
        $routes->delete('delete/(:any)', 'Fundraiser::delete/$1');
    });

    $routes->group('donasi', function ($routes) {
        $routes->get('/', 'Donasi::index');
        $routes->get('(:any)', 'Donasi::list/$1');
        $routes->post('saveAdmin/(:any)', 'Donasi::saveAdmin/$1');
        $routes->delete('(:any)/delete/(:num)', 'Donasi::deleteAdmin/$1/$2');
        $routes->post('updateAdmin/(:any)/(:num)', 'Donasi::updateAdmin/$1/$2');
    });

    $routes->group('riwayat', function ($routes) {
        $routes->get('/', 'Riwayat::index');
    });
});