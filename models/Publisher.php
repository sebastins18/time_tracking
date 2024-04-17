<?php
// file: models/Publishers.php
class Publisher extends Model {
    protected static $table = 'Publishers';

    public static function getPublisher($id_publisher) {
        return DB::select("SELECT * FROM " . static::$table . " WHERE id_publisher = ?", [$id_publisher]);
    }

    public static function findWithBooks($publisher_id) {
        $author = static::getPublisher($publisher_id);

        if ($author) {
            $author['books'] = DB::select('SELECT * FROM Books WHERE publisher_id = ?', [$publisher_id]);
        }

        return $author;
    }

    public static function destroy($id) {
        if (!$id) {
            throw new Exception("Invalid ID provided for deletion.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_publisher', '=', $id]] 
        ];

        DB::_delete($params);
    }

    public static function update($id, $item) {
        if (!$id || empty($item)) {
            throw new Exception("Invalid parameters for update.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_publisher', '=', $id]],
            'values' => $item
        ];

        DB::_update($params, $item);
    }
}
?>

