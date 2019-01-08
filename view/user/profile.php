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
$answers = isset($answers) ? $answers : null;
$questionComments = isset($questionComments) ? $questionComments : null;
$answerComments = isset($answerComments) ? $answerComments : null;
$isUser = isset($isUser) ? $isUser : null;

// Create urls for navigation
$urlToEdit = url("user/edit");
$urlToCreateQuestion = url("question/create");

// var_dump($user);

?><h1><?= $user->name ?></h1>
<h3><?= $user->email ?></h3>
<p>
    <?= $avatar ?>
</p>
<?php if ($isUser) : ?>
    <p>
        <a class="btn blue" href="<?= $urlToEdit ?>"><i class="fas fa-user-edit fa-lg"></i>&nbsp;Edit profile</a>
        <a class="btn" href="<?= $urlToCreateQuestion ?>"><i class="fas fa-question fa-lg"></i>&nbsp;Ask question</a>
    </p>
<?php endif ?>
<?php if ($questions) : ?>
    <h2>Your asked questions</h2>
    <?php foreach ($questions as $item) : ?>
        <article class="questionSummary">
            <h3><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h3>
            <p>Posted <small><?= $item->created ?></small></a></p>
            <?php if ($item->tags) : ?>
                <div class="tags">
                    <?php foreach ($item->tags as $tag) : ?>
                        <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i></a>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </article>
    <?php endforeach; ?>
<?php endif ?>
<?php if ($answers) : ?>
    <h2>Your posted answers</h2>
    <?php foreach ($answers as $answer) : ?>
        <div class="questionSummary">
            <p>
                Posted <small><?= $answer->created ?></small></a>
            </p>
            <p>
                On: <a href="<?= url("question/show/{$answer->slug}"); ?>"><?= $answer->title ?></a>
            </p>
            <div class="textBox">
                <?= $answer->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php if ($questionComments || $answerComments) : ?>
    <h2>Your posted comments</h2>
<?php endif ?>
<?php if ($questionComments) : ?>
    <?php foreach ($questionComments as $comment) : ?>
        <div class="questionSummary">
                <p>
                    Posted <small><?= $comment->created ?></small></a>
                </p>
                <p>
                    On: <a href="<?= url("question/show/{$comment->slug}"); ?>"><?= $comment->title ?></a>
                </p>
            <div class="textBox">
                <?= $comment->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php if ($answerComments) : ?>
    <?php foreach ($answerComments as $comment) : ?>
        <div class="questionSummary">
                <p>
                    Posted <small><?= $comment->created ?></small></a>
                </p>
                <p>
                    On: <a href="<?= url("question/show/{$comment->slug}"); ?>"><?= $comment->title ?></a>
                </p>
            <div class="textBox">
                <?= $comment->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
