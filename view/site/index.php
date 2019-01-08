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

$urlToCreate = url("question/create");
$urlToViewQuestions = url("question");
$urlToViewUsers = url("user");
$urlToViewTags = url("tag");


?>
<h2 class="text-center">Welcome!</h2>
<p class="lead text-center">Get your answers about everything travel-related!</p>

<?php if ($questions) : ?>
    <h2>Latest questions</h2>
    <p>
        <a class="btn blue" href="<?= $urlToCreate ?>"><i class="fas fa-question fa-lg"></i>&nbsp;Ask question</a>
        <a class="btn" href="<?= $urlToViewQuestions ?>">View all questions</a>
    </p>
    <?php foreach ($questions as $item) : ?>
    <article class="questionSummary">
        <h4><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h4>
        <p>
            Posted <small><?= $item->created ?></small> by <a href="<?= url("user/view/{$item->user}")?>"><strong><?= $item->name ?></strong></a>
        </p>
        <?php if ($item->updated) : ?>
            <p>
                Updated <small><?= $item->updated ?></small>
            </p>
        <?php endif ?>
        <?php if ($item->tags) : ?>
            <div class="tags">
                <?php foreach ($item->tags as $tag) : ?>
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
<?php else : ?>
    <h2>Most popular tags</h2>
    <p>
        <a class="btn" href="<?= $urlToViewTags ?>"><i class="fas fa-tags fa-lg"></i>&nbsp;View all tags</a>
    </p>
    <?php foreach ($popularTags as $tag) : ?>
        <?php if ($tag) : ?>
            <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i>&nbsp;(<?=$tag->count?>)</a>
        <?php endif ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!$users) : ?>
    <p>There are no users to show.</p>
<?php else : ?>
    <h2>Most active users</h2>
    <p>
        <a class="btn" href="<?= $urlToViewUsers ?>"><i class="fas fa-users fa-lg"></i>&nbsp;View all users</a>
    </p>
    <?php foreach ($users as $user) : ?>
        <?php if ($user) : ?>
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
