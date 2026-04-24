<?php

require_once 'Author.php';
require_once 'Category.php';

class Book {
    private $id;
    private $title;
    private $author_id;
    private $category_id;
    private $price;
    private $stock;
    private $description;
    private $cover;

    public function __construct($data) {
        $this->id = $data['book_id'];
        $this->title = $data['title'];
        $this->author_id = $data['author_id'];
        $this->category_id = $data['category_id'];
        $this->price = $data['price'];
        $this->stock = $data['stock_quantity'];
        $this->description = $data['description'];
        $this->cover = $data['cover_image_url'];
    }

    // ===== Getters =====
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getPrice() { return $this->price; }
    public function getStock() { return $this->stock; }
    public function getDescription() { return $this->description; }
    public function getCover() { return $this->cover; }

    // ===== Relations =====
    public function getAuthor($authors) {
        return Author::findById($authors, $this->author_id);
    }

    public function getCategory($categories) {
        return Category::findById($categories, $this->category_id);
    }

    // ===== Business Logic =====
    public function isInStock() {
        return $this->stock > 0;
    }

    public function reduceStock($qty = 1) {
        if ($this->stock >= $qty) {
            $this->stock -= $qty;
            return true;
        }
        return false;
    }

    // ===== Static Helpers =====
    public static function getAll($books) {
        return array_map(fn($b) => new Book($b), $books);
    }

    public static function findById($books, $id) {
        foreach ($books as $book) {
            if ($book['book_id'] == $id) {
                return new Book($book);
            }
        }
        return null;
    }

    // FILTERING (books.php page)
    public static function filterByCategory($books, $categoryId) {
        return array_filter($books, fn($b) => $b['category_id'] == $categoryId);
    }

    public static function filterInStock($books) {
        return array_filter($books, fn($b) => $b['stock_quantity'] > 0);
    }

    // SEARCH
    public static function search($books, $keyword) {
        return array_filter($books, function ($b) use ($keyword) {
            return stripos($b['title'], $keyword) !== false;
        });
    }

    // SORTING
    public static function sortByPrice($books, $asc = true) {
        usort($books, function ($a, $b) use ($asc) {
            return $asc
                ? $a['price'] <=> $b['price']
                : $b['price'] <=> $a['price'];
        });
        return $books;
    }
}