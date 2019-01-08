<?php

namespace Anax\View;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$src = isset($src)
    ? $src
    : null;

$text = isset($text)
    ? $text
    : null;


?>
<div class="flash" style="background-image:url('<?= asset($src) ?>')">
    <h1><?= $text ?></h1>
</div>
