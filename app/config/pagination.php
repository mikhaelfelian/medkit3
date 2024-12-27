<?php

return [
    'per_page' => 10,
    'num_links' => 5,
    'template' => 'bootstrap4',
    'templates' => [
        'bootstrap4' => [
            'wrapper_start' => '<ul class="pagination pagination-sm m-0 float-right">',
            'wrapper_end' => '</ul>',
            'item_start' => '<li class="page-item">',
            'item_end' => '</li>',
            'link_class' => 'page-link',
            'active_class' => 'active',
            'disabled_class' => 'disabled',
            'prev_link' => '&laquo;',
            'next_link' => '&raquo;',
            'first_link' => 'First',
            'last_link' => 'Last'
        ]
    ]
]; 