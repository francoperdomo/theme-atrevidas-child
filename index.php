<?php
/**
 * The main template file
 */

get_header(); ?>

<div class="w-full px-margin md:px-margin-desktop py-space-xl">
    <div class="max-w-7xl mx-auto prose">
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                // Don't render a duplicate title on WooCommerce account pages
                // (Mi Cuenta templates render their own heading inside the card)
                if ( ! is_account_page() ) {
                    the_title( '<h1 class="font-headline-lg text-on-surface">', '</h1>' );
                }
                the_content();
            }
        } else {
            echo '<p>No content found.</p>';
        }
        ?>
    </div>
</div>


<?php get_footer(); ?>
