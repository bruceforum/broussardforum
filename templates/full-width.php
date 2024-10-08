<?php
/**
 * Template Name: Full-width Template
 * Template Post Type: post, page
 *
 * @package    scaffold
 * @copyright  Copyright (c) 2019, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

get_header(); ?>

	<div class="content-area">

		<?php
		while ( have_posts() ) :
			the_post();

			?>

			<article <?php post_class(); ?>>

				<?php scaffold_thumbnail( 'scaffold-full-width' ); ?>

				<?php if ( is_front_page() ) : ?>
					<div class="entry-content front-page">
				<?php else : ?>
					<div class="entry-content">
				<?php endif; ?>
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'scaffold' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<?php
				if ( get_edit_post_link() ) :

					edit_post_link( esc_html__( '(Edit)', 'scaffold' ), '<p class="edit-link">', '</p>' );

				endif;
				?>

			</article>

			<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</div><!-- .content-area -->

<?php
get_footer();
