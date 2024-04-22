<?php
// file: controllers/UserController.php

require_once('models/User.php');

class UserController extends Controller {

    public function dashboard_admin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /');
            exit;
        }
        return view('user/dashboard_admin', [
            'title' => 'Dashboard de Administrador',
            'user' => $_SESSION['user']
        ]);
    }

    public function dashboard_user() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: /');
            exit;
        }
        return view('user/dashboard_user', [
            'title' => 'Dashboard de Usuario',
            'user' => $_SESSION['user']
        ]);
    }

    public function index() {  
        return view('user/index', [
            'users' => User::all(),
            'title' => 'Lista de Usuarios'
        ]);
    }

    public function show($id) {
        $user = User::getUser($id);

        return view('user/show', [
            'users' => $user,
            'title' => 'Detalle de Usuario'
        ]);
    }

    public function create() {
        return view('user/create', [
            'title' => 'Crear Usuario'
        ]);
    }

    public function store($param1 = null) {
        $username = Input::get('username');
        $password = Input::get('password');
        $role = Input::get('role');
        $email = Input::get('email');

        $item = ['username' => $username, 'password' => $password, 'role' => $role, 'email' => $email];
        User::create($item);
        return redirect('/user');
    }

    public function edit($id) {
        $user = User::getUser($id);

        return view('user/edit', [
            'users' => $user,
            'title' => 'Editar Usuario'
        ]);
    }

    public function update($param1, $id = null) {
        $username = Input::get('username');
        $password = Input::get('password');
        $role = Input::get('role');
        $email = Input::get('email');

        $item = ['username' => $username, 'password' => $password, 'role' => $role, 'email' => $email];
        User::update($id, $item);
        return redirect('/user');
    }

    public function destroy($id) {
        User::destroy($id);
        return redirect('/user');
    }

}
?>
