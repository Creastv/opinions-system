<?php
get_header();
while ( have_posts() ) : the_post(); ?>
	<article>
    <h2><b>Nazzwa sklepu: </b><?php the_title(); ?></h2>
</article>
<?php endwhile;
get_footer();
