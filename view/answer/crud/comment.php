<?php

namespace Anax\View;
use Michelf\MarkdownExtra;
$my_html = MarkdownExtra::defaultTransform($answer->answer);
/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$answer = isset($answer) ? $answer : null;
$comments = isset($comments) ? $comments : null;

// Create urls for navigation
$urlToTags = url("question/");
// var_dump($question);


?><h1>Comment answer</h1>

<p>
    <a href="<?= $urlToTags ?>">Show all</a>
</p>

<?php if (!$answer) : ?>
    <p>404 answer not found</p>
<?php
    return;
endif;
$urlToAnswer = url("answer/{$answer->id}");

?>

<!-- <h2><?= $answer->title ?></h2> -->
<p><small><?= $answer->created ?></small></p>
<p><?= $my_html ?></p>
<!-- <p><?= $answer->tags ?></p> -->

<?= $form ?>

<?php if ($comments) : ?>
    <?php foreach ($comments as $comment): ?>
        
    <?php endforeach ?>
<?php else: ?>
    <p>No comments yet</p>
<?php endif ?>
