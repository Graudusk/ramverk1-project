<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToQuestions = url("question");



?><p>
    <a class="btn" href="<?= $urlToQuestions ?>"><i class="fas fa-angle-double-left fa-lg"></i>&nbsp;Back to questions</a>
</p>

<h1>Ask a question</h1>
<?= $form ?>
