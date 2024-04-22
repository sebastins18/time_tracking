<?php
// Path: models/EventGuest.php

class EventGuest extends Model {
    protected static $table = 'event_guests';

    public static function getByEventId($eventId) {
        $query = "SELECT eg.*, u.username FROM " . static::$table . " eg
                  JOIN users u ON eg.user_id = u.id_user
                  WHERE eg.event_id = ?";
        return DB::select($query, [$eventId]);
    }

    public static function deleteByEventAndUserId($eventId, $userId) {

        $query = "DELETE FROM " . static::$table . " WHERE event_id = ? AND user_id = ?";
        DB::delete($query, [$eventId, $userId]);
    }

    public static function addGuests($eventId, $guestId, $status) {
        $query = "INSERT INTO " . static::$table . " (event_id, user_id, status) VALUES (?, ?, ?)";

        DB::insert($query,[$eventId, $guestId, $status]);  
    }
}
?>
