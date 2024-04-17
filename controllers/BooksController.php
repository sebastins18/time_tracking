<?php
// file: controllers/BooksController.php

require_once('models/Book.php');
require_once('models/Author.php');
require_once('controllers/AuthorsController.php');
require_once('models/Publisher.php');
require_once('controllers/PublishersController.php');

class BooksController extends Controller {

    public function index() {  
        $books = Book::all();

        foreach ($books as $key => $book) {
            $authorInfo = Author::getAuthor($book['author_id']);
            $books[$key]['authorName'] = $authorInfo[0]['author'] ?? 'Desconocido';

            $publisherInfo = Publisher::getPublisher($book['publisher_id']);
            $books[$key]['publisherName'] = $publisherInfo[0]['publisher'] ?? 'Desconocido';
        }

        return view('books/index', [
            'books' => $books,
            'title' => 'Books List',
        ]);
    }

    public function show($id_book) {
        $book = Book::getBook($id_book);
        $authorInfo = Author::getAuthor($book[0]['author_id']);
        $book[0]['authorName'] = $authorInfo[0]['author'] ?? 'Desconocido';
        
        $publisherInfo = Publisher::getPublisher($book[0]['publisher_id']);
        $book[0]['publisherName'] = $publisherInfo[0]['publisher'] ?? 'Desconocido';
        
        return view('books/show', [
            'book' => $book,
        ]);
    }

    public function create() {
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('books/create', [
            'authors' => $authors,
            'publishers' => $publishers,
            'title' => 'Create Book'
        ]);
    }  

    public function store($param1 = null) {
        $title = Input::get('title');
        $author_id = Input::get('author_id');
        $publisher_id = Input::get('publisher_id');
        $edition = Input::get('edition');
        $copyright = Input::get('copyright');
        $language = Input::get('language');
        $pages = Input::get('pages');
        
        $item = [
            'title' => $title, 
            'author_id' => $author_id, 
            'publisher_id' => $publisher_id, 
            'edition' => $edition, 
            'copyright' => $copyright, 
            'language' => $language, 
            'pages' => $pages
        ];
        Book::create($item);
        return redirect('/');
    }

    public function edit($id) {
        $book = Book::getBook($id);
        $authors = Author::all();
        foreach ($authors as $key => $author) {
            $authors[$key]['selected'] = ($author['id_author'] == $book[0]['author_id']) ? 'selected' : '';
        }
        $publishers = Publisher::all();
        foreach ($publishers as $key => $publisher) {
            $publishers[$key]['selected'] = ($publisher['id_publisher'] == $book[0]['publisher_id']) ? 'selected' : '';
        }

        return view('books/edit', [
            'book' => $book[0],
            'authors' => $authors,
            'publishers' => $publishers,
            'title' => 'Edit Book'
        ]);
    }  

    public function update($param1, $id_book = null) {
        $title = Input::get('title');
        $author_id = Input::get('author_id');
        $publisher_id = Input::get('publisher_id');
        $edition = Input::get('edition');
        $copyright = Input::get('copyright');
        $language = Input::get('language');
        $pages = Input::get('pages');
        
        $item = [
            'title' => $title, 
            'author_id' => $author_id, 
            'publisher_id' => $publisher_id, 
            'edition' => $edition, 
            'copyright' => $copyright, 
            'language' => $language, 
            'pages' => $pages
        ];
        Book::update($id_book, $item);
        return redirect('/');
    }
    
    public function destroy($id) {  
        error_log('destroying book with id: ' . $id);
        Book::destroy($id);
        return redirect('/');
    }
}
?>
