<?php

namespace Anax\View;
use Michelf\MarkdownExtra;
$my_html = MarkdownExtra::defaultTransform($question->question);
/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$question = isset($question) ? $question : null;
$comments = isset($comments) ? $comments : null;
$answers = isset($answers) ? $answers : null;

// Create urls for navigation
$urlToTags = url("question/");
// var_dump($question);


?><h1>Comment question</h1>

<p>
    <a href="<?= $urlToTags ?>">Show all</a>
</p>

<?php if (!$question) : ?>
    <p>404 question not found</p>
<?php
    return;
endif;
$urlToAnswer = url("answer/{$question->id}");

?>

<h2><?= $question->title ?></h2>
<p><small><?= $question->created ?></small></p>
<p><?= $my_html ?></p>
<p><?= $question->tags ?></p>

<?= $form ?>

<?php if ($comments) : ?>
    <?php foreach ($comments as $comment): ?>
        
    <?php endforeach ?>
<?php else: ?>
    <p>No comments yet</p>
<?php endif ?>
<a href="<?= $urlToAnswer?>">Answer question</a>
<?php if ($answers) : ?>
    <?php foreach ($answers as $answer): ?>
        
        <?php if (!$answer->comments) : ?>
            <?php foreach ($answer->comments as $comment): ?>
                
            <?php endforeach ?>
        <?php else: ?>
            <p>No comments yet</p>
        <?php endif ?>
    <?php endforeach ?>
<?php else: ?>
    <p>No answers yet</p>
<?php endif ?>
