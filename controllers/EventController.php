<?php
// Path: controllers/EventController.php

require_once('models/Event.php');

class EventController extends Controller {


    public function create() {
        return view('event/create');
    }

    public function create2() {
        $data = $_POST;
        error_log(print_r($data, true));
        try {
            $eventId = Event::create([
                'user_id' => $_SESSION['user']['id_user'],
                'title' => $data['title'],
                'description' => $data['description'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'type' => $data['type']
            ]);
            header("Location: /user/dashboard_user"); 
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function show($id) {
        $event = Event::getEvent($id);
        error_log(print_r($event, true));
        return view('event/show',
        ['event' => $event]);
    }
    
    public function edit($id) {
        $event = Event::getEvent($id);
        return view('event/edit', ['event' => $event]);
    }

    public function update($param1, $id_event = null) {
        $title = Input::get('title');
        $description = Input::get('description');
        $start_time = Input::get('start_time');
        $end_time = Input::get('end_time');
        $type = Input::get('type');

        $item = [
            'title' => $title, 
            'description' => $description, 
            'start_time' => $start_time, 
            'end_time' => $end_time, 
            'type' => $type
        ];

        error_log('-----------------------------');
        error_log(print_r($item, true));
        error_log('-----------------------------');
        Event::update($id_event, $item);
        return redirect('/user/dashboard_user');
    }
    
    public function destroy($id) {  
        error_log('destroying Event with id: ' . $id);
        Event::destroy($id);
        return redirect('/user/dashboard_user');
    }


}
?>