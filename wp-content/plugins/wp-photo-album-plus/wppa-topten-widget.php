<?php
/* wppa-topten-widget.php
* Package: wp-photo-album-plus
*
* display the top rated photos
* Version 6.2.10
*/

class TopTenWidget extends WP_Widget {
    /** constructor */
    function __construct() {
		$widget_ops = array('classname' => 'wppa_topten_widget', 'description' => __( 'WPPA+ Top Ten Rated Photos', 'wppa') );
		parent::__construct('wppa_topten_widget', __('Top Ten Photos', 'wppa'), $widget_ops);
    }

	/** @see WP_Widget::widget */
    function widget($args, $instance) {
		global $wpdb;
		global $wppa_opt;
		global $wppa;

		require_once(dirname(__FILE__) . '/wppa-links.php');
		require_once(dirname(__FILE__) . '/wppa-styles.php');
		require_once(dirname(__FILE__) . '/wppa-functions.php');
		require_once(dirname(__FILE__) . '/wppa-thumbnails.php');
		require_once(dirname(__FILE__) . '/wppa-boxes-html.php');
		require_once(dirname(__FILE__) . '/wppa-slideshow.php');
		wppa_initialize_runtime();

        $wppa['in_widget'] = 'topten';
		$wppa['mocc']++;
		extract( $args );

		$instance 		= wp_parse_args( (array) $instance, array(
														'title' => '',
														'sortby' => 'mean_rating',
														'title' => '',
														'album' => '',
														'display' => 'thumbs',
														'meanrat' => 'yes',
														'ratcount' => 'yes',
														'viewcount' => 'yes',
														'includesubs' => 'yes',
														'showowner' => 'no',
														'showalbum' => 'no'
														) );
 		$widget_title 	= apply_filters('widget_title', $instance['title'] );
		$page 			= in_array( $wppa_opt['wppa_topten_widget_linktype'], $wppa['links_no_page'] ) ? '' : wppa_get_the_landing_page('wppa_topten_widget_linkpage', __a('Top Ten Photos'));
		$albumlinkpage 	= wppa_get_the_landing_page('wppa_topten_widget_album_linkpage', __a('Top Ten Photo album'));
		$max  			= $wppa_opt['wppa_topten_count'];
		$album 			= $instance['album'];
		switch ( $instance['sortby'] ) {
			case 'mean_rating':
				$sortby = '`mean_rating` DESC, `rating_count` DESC, `views` DESC';
				break;
			case 'rating_count':
				$sortby = '`rating_count` DESC, `mean_rating` DESC, `views` DESC';
				break;
			case 'views':
				$sortby = '`views` DESC, `mean_rating` DESC, `rating_count` DESC';
				break;
		}
		$display 		= $instance['display'];
		$meanrat		= $instance['meanrat'] == 'yes';
		$ratcount 		= $instance['ratcount'] == 'yes';
		$viewcount 		= $instance['viewcount'] == 'yes';
		$includesubs 	= $instance['includesubs'] == 'yes';
		$albenum 		= '';
		$showowner 		= $instance['showowner'] == 'yes';
		$showalbum 		= $instance['showalbum'] == 'yes';

		if ( $album ) {
			if ( $album == '-2' ) $album = '0';
			if ( $includesubs ) {
				$albenum = wppa_alb_to_enum_children( $album );
				$albenum = wppa_expand_enum( $albenum );
				$album = str_replace( '.', ',', $albenum );
			}
			$thumbs = $wpdb->get_results( "SELECT * FROM `".WPPA_PHOTOS."` WHERE `album` IN (".$album.") ORDER BY " . $sortby . " LIMIT " . $max, ARRAY_A );
//wppa_log('dbg', "SELECT * FROM `".WPPA_PHOTOS."` WHERE `album` IN (".$album.") ORDER BY " . $sortby . " LIMIT " . $max);
		}
		else {
			$thumbs = $wpdb->get_results( "SELECT * FROM `".WPPA_PHOTOS."` ORDER BY " . $sortby . " LIMIT " . $max, ARRAY_A );
		}

		$widget_content = "\n".'<!-- WPPA+ TopTen Widget start -->';
		$maxw = $wppa_opt['wppa_topten_size'];
		$maxh = $maxw;
		$lineheight = $wppa_opt['wppa_fontsize_widget_thumb'] * 1.5;
		$maxh += $lineheight;
		if ( $meanrat ) 	$maxh += $lineheight;
		if ( $ratcount ) 	$maxh += $lineheight;
		if ( $viewcount ) 	$maxh += $lineheight;
		if ( $showowner ) 	$maxh += $lineheight;
		if ( $showalbum ) 	$maxh += $lineheight;

		if ( $thumbs ) foreach ( $thumbs as $image ) {

			$thumb = $image;
			// Make the HTML for current picture
			if ( $display == 'thumbs' ) {
				$widget_content .= "\n".'<div class="wppa-widget" style="width:'.$maxw.'px; height:'.$maxh.'px; margin:4px; display:inline; text-align:center; float:left;">';
			}
			else {
				$widget_content .= "\n".'<div class="wppa-widget" >';
			}
			if ( $image ) {
				$no_album = !$album;
				if ($no_album) $tit = __a('View the top rated photos', 'wppa_theme'); else $tit = esc_attr(wppa_qtrans(stripslashes($image['description'])));
				$compressed_albumenum = wppa_compress_enum( $albenum );
				$link       = wppa_get_imglnk_a('topten', $image['id'], '', $tit, '', $no_album, $compressed_albumenum );
				$file       = wppa_get_thumb_path($image['id']);
				$imgstyle_a = wppa_get_imgstyle_a( $image['id'], $file, $maxw, 'center', 'ttthumb');
				$imgurl 	= wppa_get_thumb_url($image['id'], '', $imgstyle_a['width'], $imgstyle_a['height']);
				$imgevents 	= wppa_get_imgevents('thumb', $image['id'], true);
				$title 		= $link ? esc_attr(stripslashes($link['title'])) : '';

				$widget_content .= wppa_get_the_widget_thumb('topten', $image, $album, $display, $link, $title, $imgurl, $imgstyle_a, $imgevents);

				$widget_content .= "\n\t".'<div style="font-size:'.$wppa_opt['wppa_fontsize_widget_thumb'].'px; line-height:'.$lineheight.'px;">';

					// Display (owner) ?
					if ( $showowner ) {
						$widget_content .= '<div>(' . $image['owner'] . ')</div>';
					}

					// Display (album) ?
					if ( $showalbum ) {
						$href = wppa_convert_to_pretty( wppa_get_album_url( $image['album'], $albumlinkpage, 'content', '1' ) );
						$widget_content .= '<div>(<a href="' . $href . '" >' . wppa_get_album_name( $image['album'] ) . '</a>)</div>';
					}

					$rating = wppa_get_rating_by_id( $image['id'] );
					switch ( $instance['sortby'] ) {
						case 'mean_rating':
							if ( $meanrat  	== 'yes' ) $widget_content .= '<div>'.wppa_get_rating_by_id( $image['id'] ).'</div>';
							if ( $ratcount 	== 'yes' ) $widget_content .= '<div>'.sprintf( __a( '%s Votes' ), wppa_get_rating_count_by_id( $image['id'] ) ).'</div>';
							if ( $viewcount == 'yes' && $image['views'] ) $widget_content .= '<div>'.sprintf( __a( 'Views: %s times', 'wppa_theme' ), $image['views'] ).'</div>';
							break;
						case 'rating_count':
							if ( $ratcount 	== 'yes' ) $widget_content .= '<div>'.sprintf( __a( '%s Votes' ), wppa_get_rating_count_by_id( $image['id'] ) ).'</div>';
							if ( $meanrat  	== 'yes' ) $widget_content .= '<div>'.wppa_get_rating_by_id( $image['id'] ).'</div>';
							if ( $viewcount == 'yes' && $image['views'] ) $widget_content .= '<div>'.sprintf( __a( 'Views: %s times', 'wppa_theme' ), $image['views'] ).'</div>';
							break;
						case 'views':
							if ( $viewcount == 'yes' && $image['views'] ) $widget_content .= '<div>'.sprintf( __a( 'Views: %s times', 'wppa_theme' ), $image['views'] ).'</div>';
							if ( $meanrat  	== 'yes' ) $widget_content .= '<div>'.wppa_get_rating_by_id( $image['id'] ).'</div>';
							if ( $ratcount 	== 'yes' ) $widget_content .= '<div>'.sprintf( __a( '%s Votes' ), wppa_get_rating_count_by_id( $image['id'] ) ).'</div>';
							break;
					}
				$widget_content .= '</div>';
			}
			else {	// No image
				$widget_content .= __a('Photo not found.', 'wppa_theme');
			}
			$widget_content .= "\n".'</div>';
		}
		else $widget_content .= 'There are no rated photos (yet).';

		$widget_content .= '<div style="clear:both"></div>';
		$widget_content .= "\n".'<!-- WPPA+ TopTen Widget end -->';

		echo "\n" . $before_widget;
		if ( !empty( $widget_title ) ) { echo $before_title . $widget_title . $after_title; }
		echo $widget_content . $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['album'] 			= strval( intval( $new_instance['album'] ) );
		$instance['sortby'] 		= $new_instance['sortby'];
		$instance['display'] 		= $new_instance['display'];
		$instance['meanrat']		= $new_instance['meanrat'];
		$instance['ratcount'] 		= $new_instance['ratcount'];
		$instance['viewcount'] 		= $new_instance['viewcount'];
		$instance['includesubs'] 	= $new_instance['includesubs'];
		$instance['showalbum'] 		= $new_instance['showalbum'];
		$instance['showowner'] 		= $new_instance['showowner'];

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		global $wppa_opt;
		//Defaults
		$instance 		= wp_parse_args( (array) $instance, array(
														'sortby' => 'mean_rating',
														'title' => __('Top Ten Photos', 'wppa'),
														'album' => '0',
														'display' => 'thumbs',
														'meanrat' => 'yes',
														'ratcount' => 'yes',
														'viewcount' => 'yes',
														'includesubs' => 'yes',
														'showowner' => 'no',
														'showalbum' => 'no'

														) );
 		$widget_title 	= apply_filters('widget_title', $instance['title']);
		$sortby 		= $instance['sortby'];
		$album 			= $instance['album'];
		$display 		= $instance['display'];
		$meanrat		= $instance['meanrat'];
		$ratcount 		= $instance['ratcount'];
		$viewcount 		= $instance['viewcount'];
		$includesubs 	= $instance['includesubs'];
		$showowner 		= $instance['showowner'];
		$showalbum 		= $instance['showalbum'];

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wppa'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $widget_title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('album'); ?>"><?php _e('Album:', 'wppa'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('album'); ?>" name="<?php echo $this->get_field_name('album'); ?>" >

				<?php echo wppa_album_select_a(array('selected' => $album, 'addall' => true, 'path' => wppa_switch('wppa_hier_albsel'))) //('', $album, true, '', '', true); ?>

			</select>
		</p>
		<p>
			<?php _e('Display:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
				<option value="thumbs" <?php if ($display == 'thumbs') echo 'selected="selected"' ?>><?php _e('thumbnail images', 'wppa'); ?></option>
				<option value="names" <?php if ($display == 'names') echo 'selected="selected"' ?>><?php _e('photo names', 'wppa'); ?></option>
			</select>

		</p>

		<p><label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Sort by:', 'wppa'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('sortby'); ?>" name="<?php echo $this->get_field_name('sortby'); ?>" >
				<option value="mean_rating" <?php if ($instance['sortby'] == 'mean_rating') echo 'selected="selected"' ?>><?php _e('Mean value', 'wppa') ?></option>
				<option value="rating_count" <?php if ($instance['sortby'] == 'rating_count') echo 'selected="selected"' ?>><?php _e('Number of votes', 'wppa') ?></option>
				<option value="views" <?php if ( $instance['sortby'] == 'views' ) echo 'selected="selected"' ?>><?php _e('Number of views', 'wppa') ?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('includesubs'); ?>"><?php _e('Include sub albums:', 'wppa'); ?></label>
			<select id="<?php echo $this->get_field_id('includesubs'); ?>" name="<?php echo $this->get_field_name('includesubs'); ?>" >
				<option value="yes" <?php if ( $includesubs == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $includesubs == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
		</p>

		<p><label ><?php _e('Subtitle:', 'wppa'); ?></label>
			<br /><?php _e('Show owner:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('showowner'); ?>" name="<?php echo $this->get_field_name('showowner'); ?>" >
				<option value="yes" <?php if ( $showowner == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $showowner == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
			<br /><?php _e('Show album:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('showalbum'); ?>" name="<?php echo $this->get_field_name('showalbum'); ?>" >
				<option value="yes" <?php if ( $showalbum == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $showalbum == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
			<br /><?php _e('Mean rating:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('meanrat'); ?>" name="<?php echo $this->get_field_name('meanrat'); ?>" >
				<option value="yes" <?php if ( $meanrat == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $meanrat == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
			<br /><?php _e('Rating count:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('ratcount'); ?>" name="<?php echo $this->get_field_name('ratcount'); ?>" >
				<option value="yes" <?php if ( $ratcount == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $ratcount == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
			<br /><?php _e('View count:', 'wppa'); ?>
			<select id="<?php echo $this->get_field_id('viewcount'); ?>" name="<?php echo $this->get_field_name('viewcount'); ?>" >
				<option value="yes" <?php if ( $viewcount == 'yes' ) echo 'selected="selected"' ?>><?php _e('yes', 'wppa') ?></option>
				<option value="no" <?php if ( $viewcount == 'no' ) echo 'selected="selected"' ?>><?php _e('no', 'wppa') ?></option>
			</select>
		</p>

		<p><?php _e('You can set the sizes in this widget in the <b>Photo Albums -> Settings</b> admin page.', 'wppa'); ?></p>
<?php
    }

} // class TopTenWidget

// register TopTenWidget widget
add_action('widgets_init', create_function('', 'return register_widget("TopTenWidget");'));
