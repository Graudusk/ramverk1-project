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
$questionHtml = isset($questionHtml) ? $questionHtml : null;

// Create urls for navigation
$urlToTags = url("question/");
// var_dump($answers);


?><h1>View question</h1>

<p>
    <a href="<?= $urlToTags ?>">Show all</a>
</p>

<?php if (!$question) : ?>
    <p>404 question not found</p>
<?php
    return;
endif;
$urlToAnswer = url("answer/write/{$question->id}");
$urlToComment = url("question/comment/{$question->id}");

?>
<div class="question">
<p>Posted <small><?= $question->created ?></small> by <strong><?= $question->name ?></strong></p>
<h3><?= $question->title ?></h3>
<div class="textBox">
    <?= $questionHtml ?>
</div>
<!-- <p><?= $question->tags ?></p>
 -->
<p>
    <a class="btn" href="<?= $urlToAnswer?>">Answer <i class="fas fa-share fa-lg fa-flip-horizontal"></i></a>
    <a class="btn" href="<?= $urlToComment ?>">Comment <i class="fas fa-comment fa-lg"></i></a>
</p>

<?php if ($comments) : ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <div class="textBox">
                <p>
                    Posted <small><?= $comment->created ?></small> by <a href="<?= url("user/view/{$comment->user}")?>"><strong><?= $comment->name ?></strong></a>
                </p>
                <?= $comment->html ?>
            </div>
        </div>
        
    <?php endforeach ?>
<?php else: ?>
<?php endif ?>
</div>
<?php if ($answers) : ?>
    <?php foreach ($answers as $answer): ?>
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
                <?php foreach ($answer->comments as $comment): ?>
                    <div class="comment">
                        <p>
                            Posted <small><?= $answer->created ?></small> by <a href="<?= url("user/view/{$answer->user}")?>"><strong><?= $answer->name ?></strong></a>
                        </p>
                        <div class="textBox">
                            <?= $answer->html ?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
<?php else: ?>
    <p>No answers yet</p>
<?php endif ?>
