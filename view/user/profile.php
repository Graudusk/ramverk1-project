<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToEdit = url("user/edit");
$urlToCreateQuestion = url("question/create");

// var_dump($user);

?><h1><?= $user->name ?></h1>
<p>
    <?= $avatar ?>
</p>
<p>
    <a href="<?= $urlToEdit ?>">Redigera</a> | 
    <a href="<?= $urlToCreateQuestion ?>">Skapa fråga</a>
</p>
