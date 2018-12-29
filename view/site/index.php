<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;

// Create urls for navigation
// $urlToCreate = url("question/create");
// $urlToDelete = url("question/delete");



?>

<?php if ($questions) : ?>
    <h1>Latest questions</h1>
    <?php foreach ($questions as $item) : ?>
    <article>
        <p><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></p>
        <p><?= $item->tagsHtml ?></p>
    </article>
    <hr>
    <?php endforeach; ?>
<?php else : ?>
    <p>There are no questions to show.</p>
<?php endif; ?>

