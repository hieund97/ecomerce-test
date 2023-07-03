<?php

return [
    /**
     * Basic status (On, Off)
     */
    'status' => [
        'off' => 0,
        'on'  => 1,
    ],

    /**
     * Highlight product (Yes, No)
     */
    'highlight' => [
        'no' => 0,
        'yes'  => 1,
    ],

    /**
     * Show number of admin paginate
     */
    'admin_paginate' => 5,
    /**
     * Attribute type
     */
    'attribute_type' => [
        'size'  => 1,
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
    'show_on_product_page' => [
        'category' => 6,
        'tag'      => 6,
    ],

    /**
     * Number of category on FE index
     */
    'show_cate_index' => 3,

    /**
     * Number of product on FE index
     */
    'show_prod_index' => 8,

    /**
     * Number of slider show on FE products
     */
    'show_slider' => 5,

    /**
     * Number of product show on FE products
     */
    'show_product' => 2,

    /**
     * destination path to save images
     */
    'destination_path' => 'public/images',

    /**
     * path to show image
     */
    'show_image_path' => 'storage/images/',

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
        'category' => 4,
    ],

    /**
     * type for process image
     */
    'type_image_path' => [
        'product' => 'product',
        'slider'  => 'slider',
        'blog'    => 'blog',
        'category' => 'category',

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
    'type_of_tag' => [
        'product' => 1,
        'blog'    => 2,
    ],

    /**
     * type of product(best seller, new arrivals, hot sales)
     */
    'home_category' => [26, 27, 28],

    /**
     * sorted by option
     */
    'sort_option' => [
        'low_to_high' => 1,
        'high_to_low' => 2,
    ],

    /**
     * Type to select in admin page
     */
    'type' => [
        'discount' => [
            'cash'    => 0,
            'percent' => 1,
        ],
    ],

    /**
     * type of filter in product menu
     */
    'filter' => [
        'type' => [
            'category' => 1,
            'price'    => 2,
            'color'    => 3,
            'size'     => 4,
            'tag'      => 5,
            'search'   => 6,
        ],
    ],
];
