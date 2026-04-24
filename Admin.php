<?php

require_once 'User.php';

class Admin extends User {

    public function __construct($data) {
        parent::__construct($data);
    }

    // ===== BOOK MANAGEMENT =====
    public function addBook(&$books, $newBook) {
        $books[] = $newBook;
    }

    public function deleteBook(&$books, $bookId) {
        foreach ($books as $key => $book) {
            if ($book['book_id'] == $bookId) {
                unset($books[$key]);
                return true;
            }
        }
        return false;
    }

    public function updateBook(&$books, $bookId, $updatedData) {
        foreach ($books as &$book) {
            if ($book['book_id'] == $bookId) {
                $book = array_merge($book, $updatedData);
                return true;
            }
        }
        return false;
    }

    public function updateStock(&$books, $bookId, $stock) {
        return $this->updateBook($books, $bookId, [
            'stock_quantity' => $stock
        ]);
    }

    // ===== AUTHOR MANAGEMENT =====

    public function addAuthor(&$authors, $newAuthor) {
        $authors[] = $newAuthor;
    }

    public function deleteAuthor(&$authors, $authorId) {
        foreach ($authors as $key => $author) {
            if ($author['author_id'] == $authorId) {
                unset($authors[$key]);
                return true;
            }
        }
        return false;
    }

    public function updateAuthor(&$authors, $authorId, $updatedData) {
        foreach ($authors as &$author) {
            if ($author['author_id'] == $authorId) {
                $author = array_merge($author, $updatedData);
                return true;
            }
        }
        return false;
    }
}