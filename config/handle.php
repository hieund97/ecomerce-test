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
     * Attribute type
     */
    'attribute_type' => [
        'size' => 1,
        'color' => 2,
    ],

    /**
     * Blog status (Approve)
     */
    'blog_status' => [ 
        'unapprove' => 0,
        'approving' => 1,
        'approved'  => 2,
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
     * type_of_category
     */
    'category_type' => [
        'product' => 0,
        'blog'    => 1,
    ],

    /**
     * image type
     */
    'image_type' => [
        'product' => 1,
        'slider'  => 2,
        'blog'    => 3,
    ],

    /**
     * type for process image
     */
    'type_image_path' => [
        'product' => 'product',
        'slider'  => 'slider',
        'blog'    => 'blog',
    ],

    /**
     * primary image
     */
    'primary_image' => [
        'not_primary' => 0,
        'primary'     => 1,
    ],

    /**
     * type of tags
     */
    'type_of_tag' =>[
        'product' => 1,
        'blog'    => 2,
    ],
];