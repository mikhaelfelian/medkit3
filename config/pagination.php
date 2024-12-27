<?php
return [
    'templates' => [
        'default' => [
            'wrapper_start' => '<ul class="pagination pagination-sm m-0 float-right">',
            'wrapper_end' => '</ul>',
            
            'item_start' => '<li class="page-item">',
            'item_end' => '</li>',
            
            'active_item_start' => '<li class="page-item active">',
            'active_item_end' => '</li>',
            
            'disabled_item_start' => '<li class="page-item disabled">',
            'disabled_item_end' => '</li>',
            
            'link_start' => '<a class="page-link rounded-0" href="',
            'link_mid' => '">',
            'link_end' => '</a>',
            
            'disabled_link' => '<a class="page-link rounded-0" href="#">',
            'active_link' => '<a class="page-link rounded-0" href="#">',
            
            'prev_symbol' => '&laquo;',
            'next_symbol' => '&raquo;',
            'dots_symbol' => '...'
        ],
        // You can add other templates here
        'bootstrap3' => [
            // Bootstrap 3 specific template
        ],
        'tailwind' => [
            // Tailwind specific template
        ]
    ]
]; 