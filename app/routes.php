<?php

use TestApp\Middleware\LoggedInMiddleware;
use TestApp\Middleware\GuestMiddleware;
use TestApp\Middleware\AdminMiddleware;

$app->group('', function () {
    $this->get('/signup', 'SignUpController:get')->setName('signup');
    $this->post('/signup', 'SignUpController:post');

    $this->get('/login', 'LogInController:get')->setName('login');
    $this->post('/login', 'LogInController:post');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/', 'HomeController:index')->setName('home');
    $this->get('/test', 'TestController:testList')->setName('test_list');
    $this->get('/test/{id}', 'TestController:showTest')->setName('test_view');
    $this->post('/test/{id}', 'TestController:checkTest');
    $this->get('/certificate', 'CertificateController:showList')->setName('certificate');
    $this->get('/certificate/{id}', 'PDFGeneratorController:get')->setName('gen_pdf');
    $this->get('/logout', 'LogOutController:get')->setName('logout');
})->add(new LoggedInMiddleware($container));

$app->group('/admin', function () {
    $this->get('', 'AdminPanelController:get')->setName('admin');
    $this->get('/test/add', 'AdminNewTestController:get')->setName('add_test');
    $this->post('/test/add', 'AdminNewTestController:post');
    $this->get('/test/{id}/add-question', 'AdminNewQuestionController:get')->setName('add_question');
    $this->post('/test/{id}/add-question', 'AdminNewQuestionController:post');
    $this->get('/test/{id}/delete', 'AdminDeleteTestController:get')->setName('delete_test');
    $this->post('/test/{id}/delete', 'AdminDeleteTestController:post');
    $this->post('/test/{id}/deactivate', 'AdminTestActivationController:deactivate')->setName('deactivate_test');
    $this->post('/test/{id}/activate', 'AdminTestActivationController:activate')->setName('activate_test');
//    $this->get('/test/{id}/edit', 'AdminEditTestController:get')->setName('edit_test');
//    $this->get('/test/{id}/edit', 'AdminEditTestController:post');
    $this->get('/test/{id}/results', 'AdminTestResultsController:get')->setName('test_results');
    $this->post('/test/{test_id}/allow-retake/{user_id}', 'AdminTestResultsController:post')->setName('allow_retake_test');
})->add(new AdminMiddleware($container));