<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newsphere
 */

get_header(); ?>


<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<!--<div class="af-container-row">-->

		<?php

		do_action('newsphere_action_banner_featured_section');

		do_action('newsphere_action_banner_sites_section');

		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$indexQuery = new WP_Query(array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__not_in' => $GLOBALS['exclude_ids'],
			'paged' => $paged 
		));

		if ($indexQuery->have_posts()) :

			if (is_home() && !is_front_page()) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			//div wrap start
			do_action('newsphere_archive_layout_before_loop');
			?>
			<!--<div class="af-container-row aft-archive-wrapper clearfix <?php /*echo esc_attr( $archive_class ); */ ?>">-->

			<?php

			while ($indexQuery->have_posts()) {
				$indexQuery->the_post();

				$GLOBALS['exclude_ids'][] = get_the_ID();

				/**
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */

				get_template_part('template-parts/content', get_post_format());
			}
			//div wrap end
			do_action('newsphere_archive_layout_after_loop');

			?>

		<?php

		else :
			get_template_part('template-parts/content', 'none');

		endif; ?>

		<!--</div>-->
	</main><!-- #main -->
	<div class="col col-ten">
		<div class="newsphere-pagination">
			<?php newsphere_numeric_pagination(); ?>
		</div>
	</div>
</div><!-- #primary -->

<?php
get_sidebar();
?>

<?php
get_footer();
