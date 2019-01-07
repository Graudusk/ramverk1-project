<?php

namespace Anax\View;

use Michelf\MarkdownExtra;

// $my_html = MarkdownExtra::defaultTransform($answer->answer);
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
$urlToQuestions = url("question/");
// var_dump($answer);


?><h1>Comment answer</h1>

<p>
    <a class="btn" href="<?= $urlToQuestions ?>"><i class="fas fa-angle-double-left fa-lg"></i>&nbsp;Show all questions</a>
</p>

<?php if (!$answer) : ?>
    <p>404 answer not found</p>
    <?php
    return;
endif;
$urlToAnswer = url("answer/{$answer->id}");

?>

<div class="question">
    <div class="header">
    Posted <small><?= $answer->created ?></small> by <a href="<?= url("user/view/{$answer->user}")?>"><strong><?= $answer->name ?></strong></a>
</div>
<div class="textBox">
    <?= $answerHtml ?>
</div>


<?php if ($comments) : ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="comment">
            <div class="textBox">
                <p>
                    Posted <small><?= $comment->created ?></small> by <a href="<?= url("user/view/{$comment->user}")?>"><strong><?= $comment->name ?></strong></a>
                </p>
                <?= $comment->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php else : ?>
<?php endif ?>

<?= $form ?>
