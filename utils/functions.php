<?php

/**
 * Search books by title
 */
function searchBooks($books, $keyword) {
    $keyword = trim($keyword);

    if ($keyword === '') return $books;

    return array_filter($books, function ($b) use ($keyword) {
        return stripos($b['title'], $keyword) !== false;
    });
}

/**
 * Filter books by category
 */
function filterBooksByCategory($books, $categoryId) {
    if ($categoryId === '' || $categoryId === null) return $books;

    return array_filter($books, function ($b) use ($categoryId) {
        return $b['category_id'] == $categoryId;
    });
}

/**
 * Sort books by price
 */
function sortBooksByPrice($books, $asc = true) {
    usort($books, function ($a, $b) use ($asc) {
        return $asc
            ? $a['price'] <=> $b['price']
            : $b['price'] <=> $a['price'];
    });

    return $books;
}

/**
 * Optional: Reset array keys after filtering
 */
function normalizeArray($array) {
    return array_values($array);
}
