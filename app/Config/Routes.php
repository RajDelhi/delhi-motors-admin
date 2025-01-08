<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Login::signin');
$routes->get('about-us', 'Home::about');

$routes->get('login', 'Login::signin');
$routes->post('register', 'Login::employee_register');
$routes->post('signin', 'Login::login');
$routes->get('activate/(:any)', 'Login::activate/$1');
$routes->get('forget-password', 'Login::forget_password');
$routes->post('send-password-link', 'Login::send_password_link');
$routes->get('password-reset/(:any)', 'Login::reset_password/$1');
$routes->post('reset-password-value', 'Login::reset_password_value');
$routes->get('resend-email/(:any)', 'Login::resend_mail/$1');





//**********Admin Routing ********************************************** */

$routes->get('all-list', 'Item::all_list', ['filter' => 'authGuard']);
$routes->get('all-user', 'Agent::all_users', ['filter' => 'authGuard']);

//******************************************************** */


$routes->get('dashboard', 'Invoice::index', ['filter' => 'authGuard']);
$routes->get('estimate-bill', 'Invoice::estimate', ['filter' => 'authGuard']);
$routes->get('bill', 'Invoice::billing', ['filter' => 'authGuard']);

//$routes->get('dashboard', 'Item::dashboard', ['filter' => 'authGuard']);
$routes->get('agent-profile', 'Agent::edit_profile', ['filter' => 'authGuard']);
$routes->get('edit-user/(:any)', 'Agent::edit_user/$1', ['filter' => 'authGuard']);
$routes->get('edit-user/(:any)', 'Agent::edit_user/$1', ['filter' => 'authGuard']);
$routes->post('agent-profile-ajax', 'Agent::edit_profile_ajax', ['filter' => 'authGuard']);
$routes->post('agent-user-ajax', 'Agent::edit_user_ajax', ['filter' => 'authGuard']);
$routes->get('item-list', 'Item::dashboard', ['filter' => 'authGuard']);
$routes->get('add-list', 'Item::add_list', ['filter' => 'authGuard']);
$routes->post('add-list', 'Item::add_mls_ajax', ['filter' => 'authGuard']);
$routes->get('edit-list/(:any)', 'Item::edit_list/$1', ['filter' => 'authGuard']);
$routes->post('edit-list-ajax', 'Item::edit_list_ajax', ['filter' => 'authGuard']);
$routes->get('logout', 'Login::logout', ['filter' => 'authGuard']);
$routes->post('delete-list-item', 'Item::delete_item_ajax', ['filter' => 'authGuard']);

