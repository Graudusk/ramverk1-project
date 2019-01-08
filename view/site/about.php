<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
// var_dump($popularTags);
// Create urls for navigation
// $urlToCreate = url("question/create");
// $urlToDelete = url("question/delete");
$smith = isset($smith) ? $smith : null;
$locke = isset($locke) ? $locke : null;
$johansson = isset($johansson) ? $johansson : null;

?>
<h1>About</h1>

<h3>Ask questions, get answers and send comments!</h3>

<p class="lead">
    Ever scoured through guide books and online lists in search of answers to your, sometimes very specific, questions and could not find them? Do you trust sponsored travel journalists who always write amazing reviews for the hotel they're paid to write about? Do you wish there were a place for seasoned travelers and curious beginners to meet and help each other?
</p>
<h2>Welcome to Travelers' info!</h2>
<p class="lead">
    We try to bring together information regarding travel from all over the world, from destination trip-tips to foreign food spice-advice.
</p>
<h3>Safe travels!</h3>
<h1>Us</h1>
<p class="lead">We knew there was a gap of information out there, being avid travelers ourself, we set out to do something about it. Say hello to the team:</p>

<div class="row">
    <div class="col-sm-6">
        <h3>CEO</h3>
        <p class="lead">John Smith</p>
        <p><?= $smith ?></p>
        <p class="lead"><a href="mailto:smith@travelers@com"><i class="fas fa-envelope fa-fw"></i> smith@travelers@com</a></p>
        <p class="lead"><a href="https://www.linkedin.com/in/john-smith"><i class="fab fa-linkedin fa-fw"></i> Linkedin</a></p>
    </div>
    <div class="col-sm-6">
        <h3>Vice CEO</h3>
        <p class="lead">Adam Homer</p>
        <p><?= $homer ?></p>
        <p class="lead"><a href="mailto:homer@travelers@com"><i class="fas fa-envelope fa-fw"></i> homer@travelers@com</a></p>
        <p class="lead"><a href="https://www.linkedin.com/in/john-homer"><i class="fab fa-linkedin fa-fw"></i> Linkedin</a></p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <h3>Head of marketing</h3>
        <p class="lead">Anne Locke</p>
        <p><?= $locke ?></p>
        <p class="lead"><a href="mailto:locke@travelers@com"><i class="fas fa-envelope fa-fw"></i> locke@travelers@com</a></p>
        <p class="lead"><a href="https://www.linkedin.com/in/anne-locke"><i class="fab fa-linkedin fa-fw"></i> Linkedin</a></p>
    </div>
    <div class="col-sm-6">
        <h3>The web designer</h3>
        <p class="lead">Eric Johansson</p>
        <p><?= $johansson ?></p>
        <p class="lead"><a href="mailto:johansson@travelers@com"><i class="fas fa-envelope fa-fw"></i> johansson@travelers@com</a></p>
        <p class="lead"><a href="https://github.com/Graudusk"><i class="fab fa-github fa-fw"></i> Github</a></p>
    </div>
</div>


<h2>About the project</h2>
<a href="https://github.com/Graudusk/ramverk1-project">Project on GitHub <i class="fab fa-github fa-2x"></i></a>
