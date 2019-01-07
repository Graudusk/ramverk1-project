<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;
$questionComments = isset($questionComments) ? $questionComments : null;
$answerComments = isset($answerComments) ? $answerComments : null;

// Create urls for navigation


?><h1><?= $user->name ?></h1>
<h3><?= $user->email ?></h3>
<p>
    <?= $avatar ?>
</p>
<h2>Questions</h2>
<?php if ($questions) : ?>
    <?php foreach ($questions as $item) : ?>
        <article class="questionSummary">
            <h3><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h3>
            <p>Posted <small><?= $item->created ?></small> by <a href="<?= url("user/view/{$item->user}")?>"><strong><?= $item->name ?></strong></a></p>
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

<h2>Comments</h2>
<?php if ($questionComments) : ?>
    <?php foreach ($questionComments as $comment) : ?>
        <div class="comment">
            <div class="textBox">
                <p>
                    Posted <small><?= $comment->created ?></small> by <a href="<?= url("user/view/{$comment->user}")?>"><strong><?= $comment->name ?></strong></a>
                </p>
                <p>
                    On: <a href="<?= url("question/show/{$comment->slug}"); ?>"><?= $comment->title ?></a>
                </p>
                <?= $comment->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php if ($answerComments) : ?>
    <?php foreach ($answerComments as $comment) : ?>
        <div class="comment">
            <div class="textBox">
                <p>
                    Posted <small><?= $comment->created ?></small> by <a href="<?= url("user/view/{$comment->user}")?>"><strong><?= $comment->name ?></strong></a>
                </p>
                <p>
                    On: <a href="<?= url("question/show/{$comment->slug}"); ?>"><?= $comment->title ?></a>
                </p>
                <?= $comment->html ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
