<?php
// file: controllers/AuthorsController.php

require_once('models/Author.php');
require_once('models/Book.php');
require_once('controllers/BooksController.php');

class AuthorsController extends Controller {

    public function index() {  
        return view('authors/index', [
            'authors' => Author::all(),
            'title' => 'Authors List'
        ]);
    }

    public function show($id) {
        $data = Author::findWithBooks($id);
        $author = $data[0];  
        $author['books'] = $data['books'];

    
        return view('authors/show', [
            'author' => $author,
            'title' => 'Author Detail'
        ]);
    }
    

    public function create() {
        return view('authors/create', [
            'title' => 'Crear Autor'
        ]);
    }  

    public function store($param1 = null) {
        $author = Input::get('author');
        $nationality = Input::get('nationality');
        $birth_year = Input::get('birth_year');
        $fields = Input::get('fields');
        $item = ['author' => $author, 'nationality' => $nationality, 'birth_year' => $birth_year, 'fields' => $fields];
        Author::create($item);
        return redirect('/authors');
    }

    public function edit($id) {
        $data = Author::findWithBooks($id);
        $author = $data[0];  
        $author['books'] = $data['books'];

        return view('authors/edit', [
            'author' => $author,
            'title' => 'Edit Author'
        ]);
    }  

    public function update($param1, $id = null) {
        $author = Input::get('author');
        $nationality = Input::get('nationality');
        $birth_year = Input::get('birth_year');
        $fields = Input::get('fields');
        $item = ['author' => $author, 'nationality' => $nationality, 'birth_year' => $birth_year, 'fields' => $fields];

        Author::update($id,$item);
        return redirect('/authors');
    }
    
    public function destroy($id) {  
        Author::destroy($id);
        return redirect('/authors');
    }
}
?>
