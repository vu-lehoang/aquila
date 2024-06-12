<?php

/**
 * Main template file
 * @package aquila
 */
?>
<?php get_header(); ?>




<?php


spl_autoload_register(function ($class) {
    include 'namespace/includes/' . $class . '.php';
});





?>

<?php get_footer(); ?>