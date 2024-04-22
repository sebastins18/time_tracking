<?php
// Path: controllers/EventGuestController.php

require_once('models/EventGuest.php');
require_once('models/User.php');
require_once('models/Event.php');

class EventGuestController extends Controller {

    public function showGuests($eventId) {
        $guests = EventGuest::getByEventId($eventId);
        return view('event/guests', ['guests' => $guests, 'eventId' => $eventId]);
    }

    public function deleteGuest($eventId, $userId) {
        EventGuest::deleteByEventAndUserId($eventId, $userId);
        return redirect("/event/$eventId/guests");
    }

    public function addGuestsView($eventId) {
        $users = User::all(); 
        $event = Event::getEvent($eventId);

        return view('event/add_guests', [
            'users' => $users,
            'event' => $event
        ]);
    }

    public function addGuests($eventId) {

        $event_id = $eventId['event_id'];
        $guestIds = $_POST['guests'] ?? [];
        $status = $_POST['status'] ?? 'Invited';

        if (!empty($guestIds)) {
            foreach ($guestIds as $guestId) {
                EventGuest::addGuests($event_id, $guestId, $status);
            }
            return redirect("/event/$event_id");
        } else {
            return redirect("/event/$event_id/guests/add");
        }
    }
    
}
?>
