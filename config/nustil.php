<?php


return [


    'seed' => [
        'roles' => [
            'Yönetici',
            'Editör',
        ],
        'permissions' => [
            'users',
            'roles',
            'permissions',
            'menus',
            'categories',
            'products',
            'blogs',
            'settings',
        ],
    ],

    'nutrition_units' => [
        'mg',
        'g',
        'kJ',
        'kcal',
    ],

    'unit_conversions' => [
        'µg' => [
            'mg' => 1000,
        ],
        'mg' => [
            'g' => 1000,
        ],
        'kJ' => [
            'kcal' => 4.184,
        ],
        'kcal' => [
            'kJ' => 0.239006,
        ],
    ],

    'nutritions' => [
        'Energy' => 'kJ',
        'Protein' => 'g',
        'Carbohydrate' => 'g',
        'Sugars' => 'g',
        'Fiber' => 'g',
        'Salt' => 'g',
        'Fat' => 'g',
        'Potassium' => 'mg',
        'Calcium' => 'mg',
        'Iron' => 'mg',
        'Magnesium' => 'mg',
        'Phosphorus' => 'mg',
        'Vitamin A' => 'µg',
        'Vitamin B1' => 'mg',
        'Vitamin B2' => 'mg',
        'Vitamin B3' => 'mg',
        'Vitamin B5' => 'mg',
        'Vitamin B6' => 'mg',
        'Vitamin B11' => 'mg',
        'Vitamin B12' => 'µg',
        'Vitamin C' => 'mg',
        'Vitamin D' => 'µg',
    ],

    'menu_positions' => [
        'main',
        'useful-links',
        'footer',
    ],

    'settings' => [
        'site_name' => 'Nustil',
        'phone_number' => '+90 216 353 04 00',
        'address' => 'Barbaros Mh. Yeşil Çim Sk. No:11/3, Ataşehir, İstanbul',
        'contact_email' => 'info@nustil.com',
        'social_media' => [
            'facebook' => 'Nustil.Nutrition.Style',
            'twitter' => '_nustil_',
            'instagram' => 'nustil_',
            'youtube' => 'channel/UCv_e3nsR8l7iqsfiCAAa32Q',
        ],
        'ecommerce' => [
            'pricing' => false,
            'shipping' => false,
            'tax' => false,
            'payment' => false,
        ],
        'product' => [
            'newProductInterval' => '1 month',
        ],
        'home' => [
            'latestProductsCount' => 6,
            'latestProductsDescription-tr' => "bölüm açıklaması",
            "latestProductsDescription-en" => "section description",
        ],
        'blog' => [
            'showSidebar' => false,
            'showLatestPosts' => false,
            'showPopularPosts' => false,
            'showCategories' => false,
            'showTags' => false,
            'showPublishedAt' => false,
            'displayPostCountOnCategory' => false,
            'showViewCount' => false,
            'showReadTime' => false,
        ],
        'newsletter' => [
            'enabled' => false,
        ],
    ],
    'designDebug' => false,
];
