<?php
// file: controllers/PublishersController.php

require_once('models/Publisher.php');

class PublishersController extends Controller {

    public function index() {  
        return view('publishers/index', [
            'publishers' => Publisher::all(),
            'title' => 'Publishers List'
        ]);
    }

    public function show($id) {
        $data = Publisher::findWithBooks($id);
        $publisher = $data[0];  
        $publisher['books'] = $data['books'];
        return view('publishers/show', [
            'publisher' => $publisher,
            'title' => 'Publisher Detail'
        ]);
    }

    public function create() {
        return view('publishers/create', [
            'title' => 'Create Publisher'
        ]);
    }  

    public function store($param1 = null) {
        $publisher = Input::get('publisher');
        $country = Input::get('country');
        $founded = Input::get('founded');
        $genre = Input::get('genre');
        $item = ['publisher' => $publisher, 'country' => $country, 'founded' => $founded, 'genre' => $genre];
        Publisher::create($item);
        return redirect('/publishers');
    }
    

    public function edit($id) {
        $publisher = Publisher::getPublisher($id);
        return view('publishers/edit', [
            'publisher' => $publisher,
            'title' => 'Edit Publisher'
        ]);
    }  

    public function update($param1, $id = null) {
        $publisher = Input::get('publisher');
        $country = Input::get('country');
        $founded = Input::get('founded');
        $genre = Input::get('genre');
        $item = ['publisher' => $publisher, 'country' => $country, 'founded' => $founded, 'genre' => $genre];
        Publisher::update($id, $item);
        return redirect('/publishers');
    }
    

    public function destroy($id) {  
        Publisher::destroy($id);
        return redirect('/publishers');
    }
}
?>
