<?php
/* wppa_widgetadmin.php
* Pachkage: wp-photo-album-plus
*
* admin sidebar widget
* version 6.1.0
*
*/

function _wppa_sidebar_page_options() {
global $wpdb;
	
	$options_error = false;
	
	if (isset($_GET['walbum'])) {
		$walbum = wppa_walbum_sanitize($_GET['walbum']);
		wppa_update_option('wppa_widget_album', $walbum);
	}
	if (isset($_POST['wppa-set-submit'])) {
		check_admin_referer( '$wppa_nonce', WPPA_NONCE );
		
		if (isset($_POST['wppa-widgettitle'])) wppa_update_option('wppa_widgettitle', $_POST['wppa-widgettitle']);
		if (isset($_POST['wppa-potd-align'])) wppa_update_option('wppa_potd_align', $_POST['wppa-potd-align']);
		if (isset($_POST['wppa-widget-albums'])) wppa_update_option('wppa_widget_album', wppa_walbum_sanitize($_POST['wppa-widget-albums']));
		if (isset($_POST['wppa-widget-photo'])) wppa_update_option('wppa_widget_photo', $_POST['wppa-widget-photo']);
		if (isset($_POST['wppa-widget-method'])) wppa_update_option('wppa_widget_method', $_POST['wppa-widget-method']);
		if (isset($_POST['wppa-widget-period'])) wppa_update_option('wppa_widget_period', $_POST['wppa-widget-period']);
		if (isset($_POST['wppa-widget-subtitle'])) wppa_update_option('wppa_widget_subtitle', $_POST['wppa-widget-subtitle']);
		if (isset($_POST['wppa-widget-linkpage'])) wppa_update_option('wppa_widget_linkpage', $_POST['wppa-widget-linkpage']);
		if (isset($_POST['wppa-widget-linkurl'])) wppa_update_option('wppa_widget_linkurl', $_POST['wppa-widget-linkurl']);
		if (isset($_POST['wppa-widget-linktitle'])) wppa_update_option('wppa_widget_linktitle', $_POST['wppa-widget-linktitle']);
		if (isset($_POST['wppa-widget-linktype'])) wppa_update_option('wppa_widget_linktype', $_POST['wppa-widget-linktype']);
		if (wppa_check_numeric($_POST['wppa-potd-widget-width'], '100', __('Widget Photo Width.'))) {
			wppa_update_option('wppa_potd_widget_width', $_POST['wppa-potd-widget-width']);
		} else {
			$options_error = true;
		}
		if (!$options_error) wppa_update_message(__('Changes Saved. Don\'t forget to activate the widget!', 'wppa')); 
	} 
	wppa_initialize_runtime('force');
	?>
	
	<div class="wrap">
		<?php $iconurl = WPPA_URL.'/images/settings32.png'; ?>
		<div id="icon-album" class="icon32" style="background: transparent url(<?php echo($iconurl); ?>) no-repeat">
			<br />
		</div>
		<h2><?php _e('Photo of the Day Widget Settings', 'wppa'); ?></h2>
		
		<form action="<?php echo(wppa_dbg_url(get_admin_url().'admin.php?page=wppa_photo_of_the_day')) ?>" method="post">
			<?php wp_nonce_field('$wppa_nonce', WPPA_NONCE); ?>

			<table class="form-table wppa-table wppa-photo-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label ><?php _e('Widget Title:', 'wppa'); ?></label>
						</th>
						<td>
							<input type="text" name="wppa-widgettitle" id="wppa-widgettitle" value="<?php echo wppa_opt( 'widgettitle' ) ?>" />
							<span class="description"><br/><?php _e('Enter/modify the title for the widget. This is a default and can be overriden at widget activation.', 'wppa'); ?></span>
						</td>
					</tr>	
					
					<tr valign="top">
						<th scope="row">
							<label ><?php _e('Widget Photo Width:', 'wppa'); ?></label>
						</th>
						<td>
							<input type="text" name="wppa-potd-widget-width" id="wppa-potd-widget-width" value="<?php echo wppa_opt( 'potd_widget_width' ) ?>" style="width: 50px;" />
							<?php _e('pixels.', 'wppa'); echo(' '); _e('Horizontal alignment:', 'wppa'); ?>
							<select name="wppa-potd-align" id="wppa-potd-align">
								<?php $ali = wppa_opt( 'potd_align' ) ?>
								<?php $sel = 'selected="selected"'; ?>
								<option value="none" <?php if ($ali == 'none') echo($sel) ?>><?php _e('--- none ---', 'wppa') ?></option>
								<option value="left" <?php if ($ali == 'left') echo($sel) ?>><?php _e('left', 'wppa') ?></option>
								<option value="center" <?php if ($ali == 'center') echo($sel) ?>><?php _e('center', 'wppa') ?></option>
								<option value="right" <?php if ($ali == 'right') echo($sel) ?>><?php _e('right', 'wppa') ?></option>
							</select>
							<span class="description"><br/><?php _e('Enter the desired display width and alignment of the photo in the sidebar.', 'wppa'); ?></span>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label ><?php _e('Use album(s):', 'wppa'); ?></label>
						</th>
						<td>
							<script type="text/javascript">
							/* <![CDATA[ */
							function wppaCheckWa() {
								document.getElementById('wppa-spin').style.visibility = 'visible';
								document.getElementById('wppa-upd').style.visibility = 'hidden';
								var album = document.getElementById('wppa-wa').value;
								if ( album != 'all' && album != 'sep' && album != 'all-sep' && album != 'topten' && album != 'clr' )
									album = document.getElementById('wppa-was').value + ',' + album;
								var url = "<?php echo(wppa_dbg_url(get_admin_url().'admin.php?page=wppa_photo_of_the_day')) ?>&walbum=" + album;
								document.location.href = url;
							}
							/* ]]> */
							</script>
							<?php _e('Select:', 'wppa'); ?><select name="wppa-widget-album" id="wppa-wa" onchange="wppaCheckWa()" ><?php echo wppa_walbum_select( wppa_opt( 'widget_album' ) ) ?></select>
							<img id="wppa-spin" src="<?php echo(wppa_get_imgdir()); ?>wpspin.gif" style="visibility:hidden;"/>
							<?php _e('Or Edit:', 'wppa'); ?><input type="text" name="wppa-widget-albums" id="wppa-was" value="<?php echo wppa_opt( 'widget_album' ) ?>" />
							<input class="button-primary" name="wppa-upd" id="wppa-upd" value="<?php _e('Update thumbnails', 'wppa'); ?>" onclick="wppaCheckWa()" />
							<span class="description"><br/>
								<?php _e('Select or edit the album(s) you want to use the photos of for the widget.', 'wppa'); ?>
								<br />
								<?php _e('If you want a <b>- special -</b> selection or get rid of it, you may need to use <b>- start over -</b> first.', 'wppa'); ?>
							</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label ><?php _e('Display method:', 'wppa'); ?></label>
						</th>
						<td>
							<?php $sel 		= 'selected="selected"'; ?>
							<?php $method 	= wppa_opt( 'widget_method' ); ?>
							<select name="wppa-widget-method" id="wppa-wm" onchange="wppaCheckWidgetMethod()" >
								<option value="1" <?php if ($method == '1') echo($sel); ?>><?php _e('Fixed photo', 'wppa'); ?></option> 
								<option value="2" <?php if ($method == '2') echo($sel); ?>><?php _e('Random', 'wppa'); ?></option>
								<option value="3" <?php if ($method == '3') echo($sel); ?>><?php _e('Last upload', 'wppa'); ?></option>
								<option value="4" <?php if ($method == '4') echo($sel); ?>><?php _e('Change every', 'wppa'); ?></option>
							</select>
							<?php $period = wppa_opt( 'widget_period' ); ?>
							<select name="wppa-widget-period" id="wppa-wp" >
								<option value="0" <?php if ($period == '0') echo($sel); ?>><?php _e('pageview.', 'wppa'); ?></option>
								<option value="1" <?php if ($period == '1') echo($sel); ?>><?php _e('hour.', 'wppa'); ?></option>
								<option value="24" <?php if ($period == '24') echo($sel); ?>><?php _e('day.', 'wppa'); ?></option>
								<option value="168" <?php if ($period == '168') echo($sel); ?>><?php _e('week.', 'wppa'); ?></option>
								<option value="736" <?php if ($period == '736') echo($sel); ?>><?php _e('month.', 'wppa'); ?></option>
								<option value="day-of-week" <?php if ($period == 'day-of-week') echo($sel); ?>><?php _e('day of week is order#', 'wppa'); ?></option>
								<option value="day-of-month" <?php if ($period == 'day-of-month') echo($sel); ?>><?php _e('day of month is order#', 'wppa'); ?></option>
							</select>
							<span class="description"><br/><?php _e('Select how the widget should display.', 'wppa'); ?></span>								
						</td>
					</tr>
<?php
					$linktype = wppa_opt( 'widget_linktype' );
					if ($linktype != 'custom') { ?>
						<tr>
							<th scope="row">
								<label ><?php _e('Link to:', 'wppa'); ?></label>
							</th>
							<td>
								<?php _e('Links are set on the <b>Photo Albums -> Settings</b> screen.', 'wppa'); ?>
							</td>
						</tr>
<?php				} 
					else { ?>
						<tr class="wppa-wlu" >
							<th scope="row">
								<label ><?php _e('Link to:', 'wppa'); ?></label>
							</th>
							<td>
								<?php _e('Title:', 'wppa') ?>
								<input type="text" name="wppa-widget-linktitle" id="wppa-widget-linktitle" value="<?php echo wppa_opt( 'widget_linktitle' ) ?>"style="width:20%" />
								<?php _e('Url:', 'wppa') ?>
								<input type="text"  name="wppa-widget-linkurl" id="wppa-widget-linkurl" value="<?php echo wppa_opt( 'widget_linkurl' ) ?>" style="width:50%" />
								<span class="description"><br/><?php _e('Enter the title and the url. Do\'nt forget the HTTP://', 'wppa') ?></span>
							</td>
						</tr>
<?php 				} ?>
					<!--<script type="text/javascript">wppaCheckWidgetLink()</script>-->
					<tr>
						<th scope="row">
							<label ><?php _e('Subtitle:', 'wppa'); ?></label>
						</th>
						<td>
							<?php $subtit = wppa_opt( 'widget_subtitle' ) ?>
							<select name="wppa-widget-subtitle" id="wppa-st" onchange="wppaCheckWidgetSubtitle()" >
								<option value="none" <?php if ($subtit == 'none') echo($sel); ?>><?php _e('--- none ---', 'wppa'); ?></option>
								<option value="name" <?php if ($subtit == 'name') echo($sel); ?>><?php _e('Photo Name', 'wppa'); ?></option>
								<option value="desc" <?php if ($subtit == 'desc') echo($sel); ?>><?php _e('Description', 'wppa'); ?></option>
								<option value="owner" <?php if ( $subtit == 'owner' ) echo $sel ?>><?php _e('Owner', 'wppa'); ?></option>
							</select>
							<span class="description"><br/><?php _e('Select the content of the subtitle.', 'wppa'); ?></span>	
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" class="button-primary" name="wppa-set-submit" value="<?php _e('Save Changes', 'wppa'); ?>" />
			</p>
			<?php 
			$alb 	= wppa_opt( 'widget_album' );
			$photos = wppa_get_widgetphotos( $alb );
			if ( empty( $photos ) ) {
				echo '<p>' . __('No photos yet in this album.', 'wppa') . '</p>';
			} 
			else {
				$curid 	= wppa_opt( 'widget_photo' );
				$wi 	= wppa_get_minisize() + 24;
				$hi 	= $wi + 48;
				
				// Process photos
				foreach ( $photos as $photo ) { 
					$id = $photo['id'];
					
					// Open container div
					echo '<div' .
								' class="photoselect"' .
								' style="' .
									'width:' . wppa_opt( 'widget_width' ) . 'px;' .
									'height:' . $hi . 'px;' .
									'overflow:hidden;' .
								'" >';
								
					// The image if a video
					if ( wppa_is_video( $id ) ) {
						echo wppa_get_video_html( array( 	'id' 		=> $id,
															'style' 	=> 'width:' . wppa_opt( 'widget_width' ) . 'px;'
												));
					}
					
					// The image if a photo
					else {
						echo '<img' .
								' src=" '. wppa_fix_poster_ext( wppa_get_thumb_url( $id ), $id ) . '"' .
								' style="' .
									'width:' . wppa_opt( 'widget_width' ) . 'px;' .
									'"' . 
								' alt="' . $photo['name'] .'" />';
								
						// Audio ?
						if ( wppa_has_audio( $id ) ) {
							echo wppa_get_audio_html( array( 	'id' 		=> 	$id,
																'style' 	=> 	'width:' . wppa_opt( 'widget_width' ) . 'px;' . 
																				'position:relative;' .
																				'bottom:' . ( wppa_get_audio_control_height() + 4 ) .'px;'																					
													));
						}
					} ?>
						<input type="radio" name="wppa-widget-photo" id="wppa-widget-photo<?php echo $id ?>" value="<?php echo $id ?>" <?php if ( $id == $curid ) echo 'checked="checked"'; ?>/>
						<div class="clear"></div>
						<h4 style="position: absolute; top:<?php echo( $wi - 12 ); ?>px; font-size:11px; overflow:hidden;"><?php echo wppa_qtrans(stripslashes($photo['name'])) ?></h4>
						<h6 style="position: absolute; top:<?php echo( $wi + 6); ?>px; font-size:9px; line-height:10px;"><?php echo(wppa_qtrans(stripslashes($photo['description']))); ?></h6>
						<h5 style="position: absolute; top:<?php echo( $wi + 24); ?>px; font-size:9px; line-height:10px;"><?php echo '(#'.$photo['p_order'].')' ?></h5>
						</div><?php 
				}
				echo '<div class="clear"></div>';
			} ?>
			<script type="text/javascript">wppaCheckWidgetMethod();</script>
			<script type="text/javascript">wppaCheckWidgetSubtitle();</script>
			<br />
			<p>
				<input type="submit" class="button-primary" name="wppa-set-submit" value="<?php _e('Save Changes', 'wppa'); ?>" />
			</p>
		</form>
	</div>
<?php
}

require_once ('wppa-widget-functions.php');
