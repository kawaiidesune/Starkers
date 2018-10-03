<?php
/**
 * Starkers functions and definitions
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.1
 */

/* ========================================================================================================================
   Theme-specific globals
   ======================================================================================================================== */
define('STARKERS_VERSION', '4.1');
define('STARKERS_FONTS_URL', get_template_directory_uri().'/css/fonts.css');

/* ========================================================================================================================
   Required external files
   ======================================================================================================================== */
require_once('external/starkers-utilities.php');

/* ========================================================================================================================
   Theme-specific settings

   Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
   ======================================================================================================================== */
add_theme_support('post-thumbnails');
add_theme_support('align-wide');
// register_nav_menus(array('primary' => 'Primary Navigation'));

/* ========================================================================================================================
   Actions and Filters
   ======================================================================================================================== */
add_action('wp_enqueue_scripts', 'starkers_script_enqueuer');
add_action('after_setup_theme', 'starkers_theme_slug_setup');

add_filter('body_class', array('Starkers_Utilities', 'add_slug_to_body_class'));

/* ========================================================================================================================
   Custom Post Types - include custom post types and taxonimies here e.g.

   e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
   ======================================================================================================================== */



/* ========================================================================================================================
   Scripts
   ======================================================================================================================== */

/**
 * Add scripts via wp_head()
 *
 * @return void
 * @author Keir Whitaker
 * @author Véronique Bellamy
 */
function starkers_script_enqueuer() {
	wp_register_script('site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
	wp_enqueue_script('site');

	wp_register_style('fonts', STARKERS_FONTS_URL, '', '', 'screen');
	wp_register_style('screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen');
    wp_enqueue_style('screen');
}	

/**
 * Enqueue style sheets and fonts for Gutenberg Editor only
 * 
 * @author Véronique Bellamy
 * @return void
 * @since 4.1
 */
function starkers_enqueue_gutenberg_block_editor_assets() {
	$editor_file = get_template_directory_uri() . '/css/gutenberg/gutenberg-editor.css';
	
	wp_enqueue_style('starkers_gutenberg_fonts', STARKERS_FONTS_URL);
	wp_enqueue_style('starkers_gutenberg_base_style', $editor_file, array(), STARKERS_VERSION);	
}
add_action('enqueue_block_editor_assets', 'starkers_enqueue_gutenberg_block_editor_assets'); // Gutenberg invokes this action.

/**
 * Enqueue style sheets for Gutenberg Editor and front end.
 * 
 * @author Véronique Bellamy
 * @return void
 * @since 4.1
 */
function starker_enqueue_gutenberg_block_assets() {
	wp_enqueue_style('starkers_gutenberg_block', get_template_directory_uri() . '/css/gutenberg/gutenberg-blocks.css');
}
add_action('enqueue_block_assets', 'starkers_enqueue_gutenberg_block_assets'); // Gutenberg invokes this action.

/* ========================================================================================================================
   Comments
   ======================================================================================================================== */

/**
 * Custom callback for outputting comments 
 *
 * @return void
 * @author Keir Whitaker
 */
function starkers_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; 
	?>
	<?php if ( $comment->comment_approved == '1' ): ?>	
	<li>
		<article id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment ); ?>
			<h4><?php comment_author_link() ?></h4>
			<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
			<?php comment_text() ?>
		</article>
	<?php endif;
}

/**
 * starkers_theme_slug_setup function.
 * 
 * Supporting title functionality in WordPress 4.1+
 * 
 * @access public
 * @author Véronique Bellamy
 * @return void
 * @see https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
 * @since 4.0
 */
function starkers_theme_slug_setup() {
	add_theme_support('title-tag');
}
?>