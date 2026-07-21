<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/',                    'Home::index');
$routes->post('checkout',            'CheckoutController::process');
$routes->get('checkout/payment',     'CheckoutController::payment');
$routes->post('checkout/confirm',    'CheckoutController::confirm');
$routes->get('checkout/success',     'CheckoutController::success');
$routes->get('checkout/pending',     'CheckoutController::pending');
$routes->get('checkout/error',       'CheckoutController::error');
$routes->post('kontak/kirim',        'KontakController::kirim');
