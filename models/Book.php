<?php
// file: models/Book.php

require_once('models/Author.php');
require_once('models/Publisher.php');

class Book extends Model {
    protected static $table = 'Books';

    public static function getBook($id_book) {
        return DB::select("SELECT * FROM " . static::$table . " WHERE id_book = ?", [$id_book]);
    }

    public static function destroy($id) {
        error_log("destroying book in class Book");
        if (!$id) {
            throw new Exception("Invalid ID provided for deletion.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_book', '=', $id]] 
        ];

        DB::_delete($params);
    }

    public static function update($id, $item) {
        if (!$id || empty($item)) {
            throw new Exception("Invalid parameters for update.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_book', '=', $id]],
            'values' => $item
        ];

        DB::_update($params, $item);
    }

}
?>
