<?php

return[
    /**
     * Basic status (On, Off)
     */
    'status' => [ 
        'off' => 0,
        'on'  => 1,
    ],

    /**
     * Number of category on FE products
     */
    'show_category' => 20,

    /**
     * Number of slider show on FE products
     */
    'show_slider' => 5,

    /**
     * Number of product show on FE products
     */
    'show_product' => 12,

    /**
     * destination path of images
     */
    'destination_path' => 'public/images',

    /**
     * image type
     */
    'image_type' => [
        'product' => 1,
        'slider'  => 2,
    ],

    /**
     * type for process image
     */
    'type_image_path' => [
        'product' => 'product',
        'slider'  => 'slider',
    ],

    /**
     * primary image
     */
    'primary_image' => [
        'not_primary' => 0,
        'primary'     => 1,
    ],
];