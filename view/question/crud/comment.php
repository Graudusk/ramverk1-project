<?php

namespace Anax\View;

use Michelf\MarkdownExtra;

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
$tags = isset($tags) ? $tags : null;

// Create urls for navigation
$urlToQuestions = url("question/");
// var_dump($question);
?>

<p>
    <a class="btn" href="<?= $urlToQuestions ?>"><i class="fas fa-angle-double-left fa-lg"></i>&nbsp;Back to questions</a>
</p>

<?php if (!$question) : ?>
    <p>404 question not found</p>
    <?php
    return;
endif;
$urlToAnswer = url("question/answer/{$question->id}");

?>

<h1><?= $question->title ?></h1>

<div class="question">
    <div class="header">
    Posted <small><?= $question->created ?></small> by <a href="<?= url("user/view/{$question->user}")?>"><strong><?= $question->name ?></strong></a>
</div>
<div class="textBox">
    <?= $questionHtml ?>
</div>
<?php if ($tags) : ?>
    <div class="tags">
        <?php foreach ($tags as $tag) : ?>
            <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i></a>
        <?php endforeach ?>
    </div>
<?php endif ?>

<?= $form ?>

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
</div>

<?php if ($answers) : ?>
    <?php foreach ($answers as $answer) : ?>
        <div class="answer">
            <p>
                Posted <small><?= $answer->created ?></small> by <a href="<?= url("user/view/{$answer->user}")?>"><strong><?= $answer->name ?></strong></a>
            </p>
            <div class="textBox">
                <?= $answer->html ?>
            </div>
            <p>
                <a class="btn" href="<?= url("answer/comment/{$answer->id}") ?>">Comment <i class="fas fa-comment fa-lg"></i></a>
            </p>
            <?php if (isset($answer->comments)) : ?>
                <?php foreach ($answer->comments as $comment) : ?>
                    <div class="comment">
                        <p>
                            Posted <small><?= $comment->created ?></small> by <a href="<?= url("user/view/{$comment->user}")?>"><strong><?= $comment->name ?></strong></a>
                        </p>
                        <div class="textBox">
                            <?= $comment->html ?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
<?php else : ?>
    <p>No answers yet</p>
<?php endif ?>
