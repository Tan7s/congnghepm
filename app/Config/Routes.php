<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->get('login', 'LoginController::index');
$routes->post('login', 'LoginController::login');

//$routes->get('home', 'Home::index');

$routes->get('logout', 'LoginController::logout');

$routes->group('admin', ['filter' => 'UserFilter'], function ($routes) {
    $routes->get('home', 'Home::index');
    $routes->get('list-sinhvien', 'SinhvienController::index');
    $routes->get('list-monhoc', 'MonHocController::index');
    $routes->get('list-giaovien', 'GiaovienController::index');

    $routes->group('', ['filter' => 'TeacherAndAdminFilter'], function ($routes) {
        $routes->get('diemdanh/(:num)', 'DiemDanhController::index/$1');
        $routes->post('diemdanh/update', 'DiemDanhController::diemdanh');
        $routes->post('student/update', 'SinhvienController::updateStudent');
        $routes->group('', ['filter' => 'AdminFilter'], function ($routes) {
            $routes->post('home/submit-form', 'Home::submitForm');
            $routes->post('student/addStudent', 'SinhvienController::addStudent');
            $routes->post('delete_student', 'SinhvienController::deleteStudent');
            $routes->post('teachers/update', 'GiaovienController::update');
            $routes->post('teachers/addTeacher', 'GiaovienController::addTeacher');
            $routes->post('deleteTeacher', 'GiaovienController::deleteTeachers');
        });
    });
});

//$routes->get('list-sinhviens/(:segment)', 'SinhvienController::search');