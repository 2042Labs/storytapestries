<?php
/* wppa-gp-widget.php
* Package: wp-photo-album-plus
*
* gp wppa+ widget
*
* A text widget that hooks the wppa+ filter
*
* Version 6.2.0
*/

class WppaGpWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'wppa_gp_widget', 'description' => __('WPPA+ General purpose widget', 'wppa'));
		parent::__construct('wppa_gp_widget', __('WPPA+ Text', 'wppa'), $widget_ops );
	}

	function widget( $args, $instance ) {
		global $wppa; 

		require_once(dirname(__FILE__) . '/wppa-links.php');
		require_once(dirname(__FILE__) . '/wppa-styles.php');
		require_once(dirname(__FILE__) . '/wppa-functions.php');
		require_once(dirname(__FILE__) . '/wppa-thumbnails.php');
		require_once(dirname(__FILE__) . '/wppa-boxes-html.php');
		require_once(dirname(__FILE__) . '/wppa-slideshow.php');
		wppa_initialize_runtime();

		extract($args);
		
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('WPPA+ Text', 'wppa'), 'text' => '', 'loggedinonly' => false ) );

		if ( $instance['loggedinonly'] && ! is_user_logged_in() ) {
			return;
		}
		
 		$title = apply_filters('widget_title', $instance['title']);

		$wppa['in_widget'] = 'gp';
		$wppa['mocc']++;
				
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
		
		$text = apply_filters( 'widget_text', $instance['text'], $instance );
//		$text = apply_filters('widget_text', __($instance['text']));
		
		if ($instance['filter']) $text = wpautop($text);

		$text = '<div class="wppa-gp-widget" style="margin-top:2px; margin-left:2px;" >'.wppa_albums_filter(do_shortcode($text)).'</div>';
		
		echo $text;
		echo '<div style="clear:both"></div>';
		echo $after_widget;
		
		$wppa['in_widget'] = false;
		$wppa['fullsize'] = '';	// Reset to prevent inheritage of wrong size in case widget is rendered before main column

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		$instance['loggedinonly'] = isset($new_instance['loggedinonly']);
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => __('WPPA+ Text', 'wppa'), 'text' => '', 'loggedinonly' => false ) );
		$title = $instance['title'];
		$text = format_to_edit($instance['text']);
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p><?php _e('Enter the content just like a normal text widget. This widget will interprete [wppa] shortcodes.', 'wppa'); ?></p>
		<p><?php echo sprintf( __( 'Don\'t forget size="%s"', 'wppa' ), wppa_opt( 'wppa_widget_width' ) ) ?></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p>
			<input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;
			<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('loggedinonly'); ?>" name="<?php echo $this->get_field_name('loggedinonly'); ?>" type="checkbox" <?php checked(isset($instance['loggedinonly']) ? $instance['loggedinonly'] : 0); ?> />&nbsp;
			<label for="<?php echo $this->get_field_id('loggedinonly'); ?>"><?php _e('Show to logged in users only'); ?></label>
		</p>
<?php
	}
}
// register WppaGpWidget widget
add_action('widgets_init', create_function('', 'return register_widget("WppaGpWidget");'));