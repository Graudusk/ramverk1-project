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
$popularTags = isset($popularTags) ? $popularTags : null;
$users = isset($users) ? $users : null;
// var_dump($popularTags);
// Create urls for navigation
// $urlToCreate = url("question/create");
// $urlToDelete = url("question/delete");



?>

<?php if ($questions) : ?>
    <h1>Latest questions</h1>
    <?php foreach ($questions as $item) : ?>
    <article class="questionSummary">

        <h4><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h4>
        <p>
            Posted <small><?= $item->created ?></small> by <a href="<?= url("user/view/{$item->user}")?>"><strong><?= $item->name ?></strong></a>
        </p>
        <?php if ($item->updated): ?>
            <p>
                Updated <small><?= $item->updated ?></small>
            </p>
        <?php endif ?>
        <?php if ($item->tags): ?>
            <div class="tags">
                <?php foreach ($item->tags as $tag): ?>
                    <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i></a>
                <?php endforeach ?>
            </div>
            
        <?php endif ?>
    </article>
    <?php endforeach; ?>
<?php else : ?>
    <p>There are no questions to show.</p>
<?php endif; ?>


<?php if (!$popularTags) : ?>
    <p>There are no tags to show.</p>
<?php else: ?>
    <h1>Most popular tags</h1>
    <?php foreach ($popularTags as $tag) : ?>
    <?php if ($tag): ?>
            <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i>&nbsp;(<?=$tag->count?>)</a>
    <?php endif ?>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!$users) : ?>
    <p>There are no users to show.</p>
<?php else: ?>
    <h1>Most active users</h1>
    <?php foreach ($users as $user) : ?>
        <?php if ($user): ?>
        <article class="questionSummary">
            <h3><?=$user->avatar?>&nbsp;&nbsp;<a href="<?= url("user/view/{$user->id}")?>"><?=$user->name?> - <small><?=$user->email?></small></a></h3>
            <div class="statCounterBox">
                <div class="statCounter">
                    <span><?=$user->qcount?></span> questions
                </div>
                <div class="statCounter">
                    <span><?=$user->acount?></span> answers
                </div>
                <div class="statCounter">
                    <span><?=$user->ccount?></span> comments
                </div>
                <div class="statCounter">
                    <span><?=$user->countsum?></span> total
                </div>
            </div>
        </article>
        <?php endif ?>
    <?php endforeach; ?>
<?php endif; ?>


