<?php
// Path: models/Event.php
class Event extends Model {
    protected static $table = 'events';

    public static function getByUserAndMonth($userId, $month, $year) {
        $startDate = "$year-$month-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        $query = "
            SELECT e.* FROM " . static::$table . " e
            WHERE e.user_id = ?
            AND e.start_time BETWEEN ? AND ?
            UNION
            SELECT e.* FROM " . static::$table . " e
            JOIN event_guests eg ON e.id_event = eg.event_id
            WHERE eg.user_id = ?
            AND e.start_time BETWEEN ? AND ?
        ";

        return DB::select($query, [$userId, $startDate, $endDate, $userId, $startDate, $endDate]);
    }


    public static function addGuest($eventId, $guestId, $status = 'Invited') {
        DB::insert('event_guests', [
            'event_id' => $eventId,
            'user_id' => $guestId,
            'status' => $status
        ]);
    }

    public static function getEvent($id_event) {
        $events = DB::select("SELECT * FROM " . static::$table . " WHERE id_event = ?", [$id_event]);
        if (!empty($events)) {
            $eventData = $events[0];
            $guests = DB::select("SELECT u.username, eg.status FROM users u JOIN event_guests eg ON u.id_user = eg.user_id WHERE eg.event_id = ?", [$id_event]);
            $eventData['guests'] = $guests;
            return $eventData;
        }
        return null;
    }
    

    public static function destroy($id) {
        error_log("destroying event in class Event");
        if (!$id) {
            throw new Exception("Invalid ID provided for deletion.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_event', '=', $id]] 
        ];

        DB::_delete($params);

        $params = [
            'table' => 'event_guests',
            'where' => [['event_id', '=', $id]] 
        ];

        DB::_delete($params);
    }

    public static function update($id, $item) {
        if (!$id || empty($item)) {
            throw new Exception("Invalid parameters for update.");
        }

        $params = [
            'table' => static::$table,
            'where' => [['id_event', '=', $id]],
            'values' => $item
        ];

        DB::_update($params, $item);
    }

    public static function create($data) {
        $query = "INSERT INTO " . static::$table . " (user_id, title, description, start_time, end_time, type) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$data['user_id'], $data['title'], $data['description'], $data['start_time'], $data['end_time'], $data['type']];
        return DB::insert($query, $params);
    }
}
?>
