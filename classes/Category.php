<?php

class Category {
    private $id;
    private $name;

    public function __construct($data) {
        $this->id = $data['category_id'];
        $this->name = $data['name'];
    }

    public function getId() { 
        return $this->id; 
    }

    public function getName() { 
        return $this->name; 
    }

    public static function getAll($categories) {
        return array_map(fn($c) => new Category($c), $categories);
    }

    public static function findById($categories, $id) {
        foreach ($categories as $category) {
            if ($category['category_id'] == $id) {
                return new Category($category);
            }
        }
        return null;
    }
}