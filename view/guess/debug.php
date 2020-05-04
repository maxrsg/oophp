<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes

echo "<pre>";
echo "<p>Session</p>";
var_dump($_SESSION);
echo "<p>Post</p>";
var_dump($_POST);
echo "<p>Get</p>";
var_dump($_GET);
echo "</pre>";
