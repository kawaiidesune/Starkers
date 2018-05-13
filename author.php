<?php
/**
 * The template for displaying Author Archive pages
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) );
if ( have_posts() ): the_post(); ?>

<h2><?php printf(__('Author Archives: %s','starkers'), get_the_author()); ?></h2>

<?php
if ( get_the_author_meta( 'description' ) ) :
	echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
<h3><?php printf(__('About %s','starkers'), get_the_author()) ; ?></h3>
<?php the_author_meta( 'description' );
endif; ?>

<ol>
<?php rewind_posts(); while ( have_posts() ) : the_post(); ?>
	<li>
		<article>
			<h2><a href="<?php esc_url( the_permalink() ); ?>" title="<?php printf(__('Permalink to %s','starkers'), get_the_title()); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
			<?php the_content(); ?>
		</article>
	</li>
<?php endwhile; ?>
</ol>

<?php else: ?>
<h2><?php printf(__('No posts to display for %','starkers'), get_the_author()); ?></h2>	
<?php endif;
Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>