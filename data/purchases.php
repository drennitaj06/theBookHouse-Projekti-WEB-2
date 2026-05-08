<?php

$purchases = array(

    array(
        'purchase_id' => 1,
        'user_id' => 2,
        'purchase_date' => '2026-05-05 10:00:00',
        'total_amount' => 22.0,
        'status' => 'completed',
        'delivery_method' => 'standard',
        'shipping_address' => 'Prishtine, Kosovo',
        'cardholder_name' => 'Dren Nitaj'
    ),

    array(
        'purchase_id' => 2,
        'user_id' => 3,
        'purchase_date' => '2026-05-06 13:30:00',
        'total_amount' => 11.0,
        'status' => 'processed',
        'delivery_method' => 'express',
        'shipping_address' => 'Prizren, Kosovo',
        'cardholder_name' => 'Donat Hasani'
    ),

    array(
        'purchase_id' => 3,
        'user_id' => 4,
        'purchase_date' => '2026-05-07 17:10:00',
        'total_amount' => 22.0,
        'status' => 'completed',
        'delivery_method' => 'standard',
        'shipping_address' => 'Peje, Kosovo',
        'cardholder_name' => 'Drini Gashi'
    )

);



$purchase_items = array(

    array(
        'purchase_item_id' => 1,
        'purchase_id' => 1,
        'book_id' => 2,
        'quantity' => 1,
        'price' => 11.0
    ),

    array(
        'purchase_item_id' => 2,
        'purchase_id' => 1,
        'book_id' => 4,
        'quantity' => 1,
        'price' => 11.0
    ),

    array(
        'purchase_item_id' => 3,
        'purchase_id' => 2,
        'book_id' => 3,
        'quantity' => 1,
        'price' => 11.0
    ),

    array(
        'purchase_item_id' => 4,
        'purchase_id' => 3,
        'book_id' => 1,
        'quantity' => 2,
        'price' => 22.0
    )

);