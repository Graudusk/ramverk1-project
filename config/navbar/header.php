<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Tags",
            "url" => "tag",
            "title" => "Tags.",
        ],
        [
            "text" => "Questions",
            "url" => "question",
            "title" => "Questions.",
        ],
        [
            "text" => "Users",
            "url" => "user",
            "title" => "Users.",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "Om denna webbplats.",
        ],
    ],
];
