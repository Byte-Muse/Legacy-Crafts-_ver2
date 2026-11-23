<?php

require_once __DIR__ . "/database/connexion.php";  
require_once __DIR__ . "/includes/functions.php";   
 

$active = "home";

require_once __DIR__ . "/includes/header.php"; ?>


<section class="hero mb-5">
    <h1> Join Us Now in Legacy Crafts</h1>
    <p class="lead mb-0"> We offer Workshops for everyone at all skill level</p>
</section>
 
<div class="row g-4">
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Formations</h2>
            <p class="text-muted">Check out the arts our Workshops offer</p>
            <a class="btn btn-main" href="formations/index.php">Check</a>
        </div>
    </div>
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Students</h2>
            <p class="text-muted">A list of our enrolled students</p>
            <a class="btn btn-main" href="etudiant/index.php">Check</a>
        </div>
    </div>
 
    <div class="col-md-4">
        <div class="entity-card">
            <h2 class="h4 mt-2">Modules</h2>
            <p class="text-muted">Take a look at the diffrent modules each Workshop offers</p>
            <a class="btn btn-main" href="module/index.php">Check</a>
        </div>
    </div>
 
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
