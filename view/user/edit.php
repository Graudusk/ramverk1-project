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
$urlToProfile = url("user/profile");

// var_dump($user);

?><h1>User</h1>

<p>
    <a class="btn" href="<?= $urlToProfile ?>"><i class="fas fa-user fa-lg"></i>&nbsp;Back to profile</a>
</p>

<?= $form ?>
