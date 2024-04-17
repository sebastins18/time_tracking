<?php
// file: models/Author.php
class Author extends Model {
    protected static $table = 'Authors';

    public static function getAuthor($id_author) {
        return DB::select("SELECT * FROM " . static::$table . " WHERE id_author = ?", [$id_author]);
    }

    public static function findWithBooks($id_author) {
        $author = static::getAuthor($id_author);

        if ($author) {
            $author['books'] = DB::select('SELECT * FROM Books WHERE author_id = ?', [$id_author]);
        }

        return $author;
    }

    public static function destroy($id) {
        if (!$id) {
            throw new Exception("Invalid ID provided for deletion.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_author', '=', $id]] 
        ];

        DB::_delete($params);
    }

    public static function update($id, $item) {
        if (!$id || empty($item)) {
            throw new Exception("Invalid parameters for update.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_author', '=', $id]],
            'values' => $item
        ];

        DB::_update($params, $item);
    }
    
}
?>
