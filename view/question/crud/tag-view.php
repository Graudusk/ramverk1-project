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




?><h1>View all questions with tag '<?= $tag ?>'</h1>

<?php if (!$questions) : ?>
    <p>There are no questions to show.</p>
<?php
    return;
endif;
?>

<?php foreach ($questions as $item) : ?>

<article class="questionSummary">

    <h3><a href="<?= url("question/show/{$item->slug}"); ?>"><?= $item->title ?></a></h3>
    <p>Posted <small><?= $item->created ?></small> by <strong><?= $item->name ?></strong></p>
    <?php if ($item->tags): ?>
        <div class="tags">
            <?php foreach ($item->tags as $tag): ?>
                <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i></a>
            <?php endforeach ?>
        </div>
        
    <?php endif ?>
</article>
<?php endforeach; ?>
