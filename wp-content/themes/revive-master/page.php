<?php get_header(); ?>

<!-- Row for main content area -->
<div class="row">
	<div class="small-12 large-8 columns" id="content" role="main">
		<?php if ($GLOBALS['$show_titles']){ echo 'Page'; }  ?>
	
	<?php /* Start loop */ ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php reverie_entry_meta(); ?>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'reverie'), 'after' => '</p></nav>' )); ?>
			</footer>
		</article>
	<?php endwhile; // End the loop ?>

	</div>
	<aside id="sidebar" class="small-12 large-4 columns">
		<?php get_sidebar(); ?>
	</aside>	
</div><!-- Row End -->

		
<?php get_footer(); ?>