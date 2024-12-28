<?php
return [
    'template' => 'default',
    'num_links' => 5,
    'templates' => [
        'default' => [
            'wrapper_start' => '<ul class="pagination pagination-sm m-0 float-right">',
            'wrapper_end' => '</ul>',
            'first_link' => '«',
            'last_link' => '»',
            'next_link' => '›',
            'prev_link' => '‹',
            'link_start' => '<li class="page-item">',
            'link_end' => '</li>',
            'link_tag_open' => '<a class="page-link" href="{url}">',
            'link_tag_close' => '</a>',
            'active_start' => '<li class="page-item active">',
            'active_end' => '</li>',
            'active_tag_open' => '<span class="page-link">',
            'active_tag_close' => '</span>',
            'disabled_start' => '<li class="page-item disabled">',
            'disabled_end' => '</li>',
            'disabled_tag_open' => '<span class="page-link">',
            'disabled_tag_close' => '</span>',
            'ellipsis' => '<li class="page-item disabled"><span class="page-link">...</span></li>'
        ]
    ]
]; 