<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$users = isset($users) ? $users : null;

?><h1>Show all users</h1>

<?php if (!$users) : ?>
    <p>There are no users to show.</p>
<?php else : ?>
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
