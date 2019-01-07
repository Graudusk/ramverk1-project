<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Create urls for navigation

$urlToQuestions = url("question/");
$urlToQuestion = url("question/show/$question->slug");


?>
<p>
    <a class="btn" href="<?= $urlToQuestions ?>"><i class="fas fa-angle-double-left fa-lg"></i>&nbsp;Show all questions</a>
    <a class="btn" href="<?= $urlToQuestion ?>"><i class="fas fa-angle-double-left fa-lg"></i>&nbsp;View Question</a>
</p>

<h1>Delete an answer</h1>

<?= $form ?>
