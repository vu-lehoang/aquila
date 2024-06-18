<?php

/**
 * Main template file
 * @package aquila
 */
?>
<?php get_header(); ?>
<div id="primary">
	<main id="main" class="site-main mt-5" role="main">
		<?php if (have_posts()) : ?>

			<div class="container">
				<?php if (is_home() && !is_front_page()) : ?>
					<header class="mb-5">
						<h1 class="page-title screen reader-text">
							<?php single_post_title(); ?>
						</h1>
					</header>
				<?php endif; ?>
				<!-- Start custom layout -->
				<div class="row mb-5">
					<?php
					$index = 0;
					$no_of_columns = 3;

					while (have_posts()) : the_post();

						// Display post content
						if (0 === $index % $no_of_columns) : ?>
							<div class="col-lg-4 col-md-6 col-sm-12">

							<?php endif; ?>
							<?php get_template_part('template-parts/blog-content') ?>
							<?php
							$index++;
							if (0 !== $index && 0 === $index % $no_of_columns) : ?>
							</div>
					<?php
							endif;
						endwhile;
					?>
				</div>
				<!-- End custom layout -->
			</div>
		<?php else : get_template_part('template-parts/blog-content-none'); ?>
		<?php endif;
		aquila_pagination();
		?>
	</main>
</div>

<?php get_footer(); ?>