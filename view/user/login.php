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
$urlToCreate = url("user/create");



?><h1>Login</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create new user</a>
</p>

<?= $form ?>
