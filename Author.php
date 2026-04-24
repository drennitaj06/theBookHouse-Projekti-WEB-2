<?php

class Author {
    private $id;
    private $name;

    public function __construct($data) {
        $this->id = $data['author_id'];
        $this->name = $data['name'];
    }

    public function getId() { 
        return $this->id; 
    }

    public function getName() { 
        return $this->name; 
    }

    // Static
    public static function getAll($authors) {
        return array_map(fn($a) => new Author($a), $authors);
    }

    public static function findById($authors, $id) {
        foreach ($authors as $author) {
            if ($author['author_id'] == $id) {
                return new Author($author);
            }
        }
        return null;
    }
}