<?php
/*
Template Name: Gotcha (No Header)
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div style="background:black;color:#00ff00;font-family:monospace;text-align:center;padding-top:100px;height:100vh;">

    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>

</div>

<?php wp_footer(); ?>
</body>
</html>