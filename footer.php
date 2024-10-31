<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    scaffold
 * @copyright  Copyright (c) 2019, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

	</div><!-- .site-content -->

	<footer class="site-footer">
		<div class="container">
			<div class="site-info">
				<?php scaffold_the_custom_logo(); ?>
			</div>
			<div class="site-map">
				<div class="site-map-category">
					<?php esc_html_e( 'Site Navigation', 'scaffold' ); ?>
					<h3>Group</h3>
					<ul>
						<li>
							<a>Page</a>
						</li>
					</ul>
					<a>SPECIAL LINK</a>
				</div>
			</div>
			<hr />
			<div class="site-links">
				<div class="social-links">
					<a href="https://www.linkedin.com/in/bruce-broussard-ba2b69b">LinkedIn</a>
				</div>
				<div class="legal-links">
					<a>Privacy Policy</a>
					<a>Cookie Policy</a>
					<a>DMCA & Reporting Piracy</a>
					<a>Legal Notices</a>
					<a>©Bruce Broussard 2024</a>
				</div>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>

</div><!-- .site-wrapper -->

</body>
</html>
