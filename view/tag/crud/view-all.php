<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$tags = isset($tags) ? $tags : null;

?><h1>Show all tags</h1>

<?php if (!$tags) : ?>
    <p>There are no tags to show.</p>
    <?php
    return;
endif;
?>

<?php foreach ($tags as $tag) : ?>
    <?php if ($tag) : ?>
        <h3>
            <a href="<?= url("question/tag/{$tag->slug}")?>" class="tag btn"><?=$tag->tag?>&nbsp;<i class="fas fa-tag"></i>&nbsp;(<?=$tag->count?>)</a>
        </h3>
    <?php endif ?>
<?php endforeach; ?>
