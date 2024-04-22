<?php
// file: controllers/LoginController.php

require_once('models/User.php');

class LoginController extends Controller {

    public function index() {
        return view('login/index');
    }

    public function handleLogin() {
        if (session_status() == PHP_SESSION_NONE) {
            error_log('---------------------');
            error_log("Inicio de sesion");
            error_log('---------------------');
            session_start();
        }
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = User::authenticate($username, $password);
        if ($user) {
            $_SESSION['user'] = $user[0];
            session_regenerate_id(true); 
            if ($user[0]['role'] === 'admin') {
                header('Location: /user/dashboard_admin');
                exit;
            } else {
                header('Location: /user/dashboard_user');
                exit;
            }
        } else {
            return view('login/index', ['error' => 'Credenciales inválidas']);
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /'); 
        exit;
    }
}
