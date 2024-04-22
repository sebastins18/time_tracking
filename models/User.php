<?php
// file: models/User.php

Class User extends  Model{
    protected static $table = 'users';

    public static function getUser($id_user){
        return DB::select("SELECT * FROM " . static::$table . " WHERE id_user = ?", [$id_user]);
    }

    public static function destroy($id) {
        if (!$id) {
            throw new Exception("Invalid ID provided for deletion.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_user', '=', $id]] 
        ];

        DB::_delete($params);
    }

    public static function update($id, $item) {
        if (!$id || empty($item)) {
            throw new Exception("Invalid parameters for update.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_user', '=', $id]],
            'values' => $item
        ];

        DB::_update($params, $item);
    }

    public static function authenticate($username, $password) {

        error_log('Usuario autenticado 1: ' . $username . ' ' . $password);

        $user = DB::select("SELECT * FROM " . static::$table . " WHERE username = ? AND password = ?", [$username, $password]);
        return $user;
    }


}