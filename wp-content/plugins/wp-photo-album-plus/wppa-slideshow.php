<?php
/* wppa-slideshow.php
* Package: wp-photo-album-plus
*
* Contains all the slideshow high level functions
* Version 6.2.10
*
*/

if ( ! defined( 'ABSPATH' ) ) die( "Can't load this file directly" );

function wppa_the_slideshow() {
global $wppa_opt;

	wppa_prepare_slideshow_pagination();

	if ( $wppa_opt['wppa_pagelink_pos'] == 'top' || $wppa_opt['wppa_pagelink_pos'] == 'both' ) wppa_slide_page_links();

	if ( wppa_switch('wppa_split_namedesc') ) {
		$indexes = explode(',', $wppa_opt['wppa_slide_order_split']);
		$i = '0';
		while ( $i < '12' ) {
			switch ( $indexes[$i] ) {
				case '0':
					wppaStartStop('optional');				// The 'Slower | start/stop | Faster' bar
					break;
				case '1':
					wppa_slide_frame();						// The photo / slide
					break;
				case '2':
					wppa_slide_name_box('optional');		// Show name in a box.
					break;
				case '3':
					wppa_slide_desc_box('optional');		// Show description in a box.
					break;
				case '4':
					wppa_slide_custom('optional');			// Custom box
					break;
				case '5':
					wppa_slide_rating('optional');			// Rating box
					break;
				case '6':
					wppa_slide_filmstrip('optional');		// Show Filmstrip
					break;
				case '7':
					wppa_browsebar('optional');				// The 'Previous photo | Photo n of m | Next photo' bar
					break;
				case '8':
					wppa_comments('optional');				// The Comments box
					break;
				case '9':
					wppa_iptc('optional');					// The IPTC box
					break;
				case '10':
					wppa_exif('optional');					// The EXIF box
					break;
				case '11':
					wppa_share('optional');					// The Share box
					break;
				default:
					break;
			}
			$i++;
		}
	}
	else {
		$indexes = explode(',', $wppa_opt['wppa_slide_order']);
		$i = '0';
		while ( $i < '11' ) {
			switch ( $indexes[$i] ) {
				case '0':
					wppaStartStop('optional');				// The 'Slower | start/stop | Faster' bar
					break;
				case '1':
					wppa_slide_frame();						// The photo / slide
					break;
				case '2':
					wppa_slide_name_desc('optional');		// Show name and description in a box.
					break;
				case '3':
					wppa_slide_custom('optional');			// Custom box
					break;
				case '4':
					wppa_slide_rating('optional');			// Rating box
					break;
				case '5':
					wppa_slide_filmstrip('optional');		// Show Filmstrip
					break;
				case '6':
					wppa_browsebar('optional');				// The 'Previous photo | Photo n of m | Next photo' bar
					break;
				case '7':
					wppa_comments('optional');				// The Comments box
					break;
				case '8':
					wppa_iptc('optional');					// The IPTC box
					break;
				case '9':
					wppa_exif('optional');					// The EXIF box
					break;
				case '10':
					wppa_share('optional');					// The Share box
					break;
				default:
					break;
			}
			$i++;
		}
	}
	if ( $wppa_opt['wppa_pagelink_pos'] == 'bottom' || $wppa_opt['wppa_pagelink_pos'] == 'both' ) wppa_slide_page_links();
}

function wppa_prepare_slideshow_pagination() {
global $wppa_opt;
global $wppa;
global $thumbs;
global $thumbs_ids;

	// Save thumb ids of full selection
	$thumbs_ids = array();
	if ( $thumbs ) foreach ( $thumbs as $t ) {
		$thumbs_ids[] = $t['id'];
	}

	// Page size defined?
	if ( ! $wppa_opt['wppa_slideshow_pagesize'] ) {
		$wppa['slideshow_pagination'] = false;
		return;
	}

	// Not in a widget!
	if ( $wppa['in_widget'] ) {
		$wppa['slideshow_pagination'] = false;
		return;
	}

	// Not when slideonly
	if ( $wppa['is_slideonly'] || $wppa['is_slideonlyf'] ) {
		$wppa['slideshow_pagination'] = false;
		return;
	}

	// Fits in one page?
	$pagsiz = $wppa_opt['wppa_slideshow_pagesize'];
	if ( count($thumbs) <= $pagsiz ) {
		$wppa['slideshow_pagination'] = false;
		return;
	}

	// Pagination on and required
	$wppa['slideshow_pagination'] = true;
	$nslides = count($thumbs);
	$wppa['npages'] = ceil($nslides / $pagsiz);

	// Assume page = 1
	$wppa['curpage'] = '1';

	// If a page is requested, find it
	$pagreq = wppa_get_get('page');
	if ( is_numeric($pagreq) && $pagreq > '0' ) {
		$wppa['curpage'] = $pagreq;
	}

	// If a photo requested, find the page where its on
	elseif ( $wppa['start_photo'] ) {
		$first = true;
		foreach ( array_keys($thumbs) as $key ) {
		if ( $first ) { wppa_dbg_msg('First index = '.$key); $first = false; }
			if ( $thumbs[$key]['id'] == $wppa['start_photo'] ) {
				$wppa['curpage'] = floor($key / $pagsiz) + '1';
				wppa_dbg_msg('Startphoto is on page #'.$wppa['curpage']);
			}
		}
	}

	// Filmstrip assumes array $thumbs to start at index 0.
	// We shift the req'd part down to the beginning and unset the rest
	$skips = ( $wppa['curpage'] - '1' ) * $pagsiz;
	wppa_dbg_msg('Skips = '.$skips);
	foreach ( array_keys($thumbs) as $key ) {
		if ( $key < $pagsiz ) {
			if ( isset($thumbs[$key + $skips]) ) {
				if ( $skips ) $thumbs[$key] = $thumbs[$key + $skips];
			}
			else unset($thumbs[$key]);	// last page < pagesize
		}
		else unset ( $thumbs[$key] );
	}
	wppa_dbg_msg('Thumbs has '.count($thumbs).' elements.');
}

function wppa_slide_page_links() {
global $wppa;
global $thumbs;

	if ( ! $wppa['slideshow_pagination'] ) return;	// No pagination

	wppa_page_links($wppa['npages'], $wppa['curpage'], true);

}

function wppaStartStop($opt = '') {
global $wppa;
global $wppa_opt;

	if (is_feed()) return;	// Not in a feed

	// A single image slideshow needs no navigation
	if ( $wppa['is_single'] ) return;
	if ( $wppa['is_filmonly'] ) return;

	// we always need this for the functionality (through filmstrip etc).
	// so if not wanted: hide it
	$hide = 'display:none; '; // assume hide
	if ( $opt != 'optional' ) $hide = '';														// not optional: show
	if ( wppa_switch('wppa_show_startstop_navigation') && !$wppa['is_slideonly'] ) $hide = '';	// we want it

	if ( $wppa_opt['wppa_start_slide'] || $wppa['in_widget'] ) {
		$wppa['out'] .= "\n";
		wppa_add_js_page_data( '<script type="text/javascript">' );
//		$wppa['out'] .= '/* <![CDATA[ */'."\n";

		wppa_add_js_page_data( 'wppaSlideInitRunning['.$wppa['mocc'].'] = true;' );
		wppa_add_js_page_data( 'wppaMaxOccur = '.$wppa['mocc'].';' );

//		$wppa['out'] .= "/* ]]> */\n";
		wppa_add_js_page_data( "</script>" );
	}

	$wppa['out'] .= wppa_nltab('+').'<div id="prevnext1-'.$wppa['mocc'].'" class="wppa-box wppa-nav wppa-nav-text" style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-nav').__wcs('wppa-nav-text').$hide.'">';
		$wppa['out'] .= wppa_nltab().'<a id="speed0-'.$wppa['mocc'].'" class="wppa-nav-text speed0" style="'.__wcs('wppa-nav-text').'" onclick="wppaSpeed('.$wppa['mocc'].', false); return false;">'.__a('Slower', 'wppa_theme').'</a> | ';
		$wppa['out'] .= wppa_nltab().'<a id="startstop-'.$wppa['mocc'].'" class="wppa-nav-text startstop" style="'.__wcs('wppa-nav-text').'" onclick="wppaStartStop('.$wppa['mocc'].', -1); return false;">'.__a('Start', 'wppa_theme').'</a> | ';
		$wppa['out'] .= wppa_nltab().'<a id="speed1-'.$wppa['mocc'].'" class="wppa-nav-text speed1" style="'.__wcs('wppa-nav-text').'" onclick="wppaSpeed('.$wppa['mocc'].', true); return false;">'.__a('Faster', 'wppa_theme').'</a>';
	$wppa['out'] .= wppa_nltab('-').'</div><!-- #prevnext1 -->';
}

function wppa_slide_frame() {
global $wppa;
global $wppa_opt;

	if ( is_feed() ) return;
	if ( $wppa['is_filmonly'] ) return;

//	if ( wppa_switch('wppa_slide_swipe') ) {
//		$ontouch = 'ontouchstart="wppaTouchStart(event,\'slide_frame-'.$wppa['mocc'].'\', '.$wppa['mocc'].');"  ontouchend="wppaTouchEnd(event);" ontouchmove="wppaTouchMove(event);" ontouchcancel="wppaTouchCancel(event);"';
//	}
//	else
	$ontouch = '';
	if ( wppa_switch('wppa_slide_pause') ) {
		$pause = 'onmouseover="wppaSlidePause['.$wppa['mocc'].'] = \''.__a('Paused', 'wppa_theme').'\'" onmouseout="wppaSlidePause['.$wppa['mocc'].'] = false"';
	}
	else $pause = '';

	// There are still users who turn off javascript...
	$wppa['out'] .= wppa_nltab().'<noscript style="text-align:center; " ><span style="color:red; ">'.__a('To see the full size images, you need to enable javascript in your browser.', 'wppa').'</span></noscript>';

	$wppa['out'] .= wppa_nltab('+').'<div id="slide_frame-'.$wppa['mocc'].'" '.$ontouch.' '.$pause.' class="slide-frame" style="overflow:hidden; '.wppa_get_slide_frame_style().'">';
		$auto = false;
		if ( $wppa['auto_colwidth'] ) $auto = true;
		elseif ( $wppa_opt['wppa_colwidth'] == 'auto' ) $auto = true;
		if ( $auto ) {
			$wppa['out'] .= wppa_nltab().'<div id="theslide0-'.$wppa['mocc'].'" class="theslide theslide-'.$wppa['mocc'].'" style="width:100%; margin:auto;" ></div>';
			$wppa['out'] .= wppa_nltab().'<div id="theslide1-'.$wppa['mocc'].'" class="theslide theslide-'.$wppa['mocc'].'" style="width:100%; margin:auto;" ></div>';
		}
		else {
			$wppa['out'] .= wppa_nltab().'<div id="theslide0-'.$wppa['mocc'].'" class="theslide theslide-'.$wppa['mocc'].'" style="width:'.$wppa['slideframewidth'].'px; " ></div>';
			$wppa['out'] .= wppa_nltab().'<div id="theslide1-'.$wppa['mocc'].'" class="theslide theslide-'.$wppa['mocc'].'" style="width:'.$wppa['slideframewidth'].'px; " ></div>';
		}
		$wppa['out'] .= wppa_nltab().'<div id="spinner-'.$wppa['mocc'].'" class="spinner" ></div>';
		if ( ! wppa_page('oneofone') ) {
			if ( ( wppa_switch('wppa_show_bbb') && ! $wppa['in_widget'] ) || ( wppa_switch('wppa_show_bbb_widget') && $wppa['in_widget'] ) ){	// big browsing buttons enabled
				$wppa['out'] .= wppa_nltab().'<img id="bbb-'.$wppa['mocc'].'-l" class="bbb-l bbb-'.$wppa['mocc'].'" src="'.wppa_get_imgdir().'bbbl.png" alt="bbbl" style="background-color: transparent; border:none; z-index:83; position: absolute; float:left;  top: 0px; width: '.($wppa['slideframewidth']*0.5).'px; height: '.$wppa['slideframeheight'].'px; box-shadow: none; cursor:default;" onmouseover="wppaBbb('.$wppa['mocc'].',\'l\',\'show\')" onmouseout="wppaBbb('.$wppa['mocc'].',\'l\',\'hide\')" onclick="wppaBbb('.$wppa['mocc'].',\'l\',\'click\')" />';
				$wppa['out'] .= wppa_nltab().'<img id="bbb-'.$wppa['mocc'].'-r" class="bbb-r bbb-'.$wppa['mocc'].'" src="'.wppa_get_imgdir().'bbbr.png" alt="bbbr" style="background-color: transparent; border:none; z-index:83; position: absolute; float:right; top: 0px; width: '.($wppa['slideframewidth']*0.5).'px; height: '.$wppa['slideframeheight'].'px; box-shadow: none; cursor:default;" onmouseover="wppaBbb('.$wppa['mocc'].',\'r\',\'show\')" onmouseout="wppaBbb('.$wppa['mocc'].',\'r\',\'hide\')" onclick="wppaBbb('.$wppa['mocc'].',\'r\',\'click\')" />';
			} /***/
			if ( ( wppa_switch('wppa_show_ubb') && ! $wppa['in_widget'] ) || ( wppa_switch('wppa_show_ubb_widget') && $wppa['in_widget'] ) ) { // Ugly browse buttons
				$wppa['out'] .= wppa_nltab().'<img id="ubb-'.$wppa['mocc'].'-l" class="ubb ubb-l ubb-'.$wppa['mocc'].'" src="'.wppa_get_imgdir().'ubbl'.wppa_opt('ubb_color').'.png" alt="ubbl" style="background-color: transparent; border:none; z-index:183; position: absolute; top: 100px; left:0; box-shadow: none; cursor:pointer; top:'.($wppa['slideframeheight']/2-10).'px;" onmouseover="wppaUbb('.$wppa['mocc'].',\'l\',\'show\')" onmouseout="wppaUbb('.$wppa['mocc'].',\'l\',\'hide\')" onclick="wppaUbb('.$wppa['mocc'].',\'l\',\'click\')" />';
				$wppa['out'] .= wppa_nltab().'<img id="ubb-'.$wppa['mocc'].'-r" class="ubb ubb-r ubb-'.$wppa['mocc'].'" src="'.wppa_get_imgdir().'ubbr'.wppa_opt('ubb_color').'.png" alt="ubbr" style="background-color: transparent; border:none; z-index:183; position: absolute; top: 100px; right:0; box-shadow: none; cursor:pointer; top:'.($wppa['slideframeheight']/2-10).'px;" onmouseover="wppaUbb('.$wppa['mocc'].',\'r\',\'show\')" onmouseout="wppaUbb('.$wppa['mocc'].',\'r\',\'hide\')" onclick="wppaUbb('.$wppa['mocc'].',\'r\',\'click\')" />';
			}
		}
		wppa_numberbar();

	$wppa['out'] .= wppa_nltab('-').'</div>';
}

function wppa_slide_name_desc($key = 'optional') {
global $wppa;
global $wppa_opt;

	$do_it = false;
	if ($key != 'optional') $do_it = true;
	if ($wppa['is_slideonly']) {
		if ($wppa['name_on']) $do_it = true;
		if ($wppa['desc_on']) $do_it = true;
	}
	else {
		if ( wppa_switch('wppa_show_full_desc') ) $do_it = true;
		if ( wppa_switch('wppa_show_full_name') || wppa_switch('wppa_show_full_owner') ) $do_it = true;
	}
	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="namedesc-'.$wppa['mocc'].'" class="wppa-box wppa-name-desc" style="'.__wcs('wppa-box').__wcs('wppa-name-desc').'" >';
			if ( wppa_switch('wppa_swap_namedesc') ) {
				wppa_slide_name($key);			// The name of the photo
				wppa_slide_description($key);		// The description of the photo
			}
			else {
				wppa_slide_description($key);		// The description of the photo
				wppa_slide_name($key);			// The name of the photo
			}
		$wppa['out'] .= wppa_nltab('-').'</div><!-- #namedesc -->';
	}
}

function wppa_slide_name_box($key = 'optional') {
global $wppa;
global $wppa_opt;

	$do_it = false;
	if ($key != 'optional') $do_it = true;
	if ($wppa['is_slideonly']) {
		if ($wppa['name_on']) $do_it = true;
	}
	else {
		if ( wppa_switch('wppa_show_full_name') || wppa_switch('wppa_show_full_owner') ) $do_it = true;
	}
	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="namebox-'.$wppa['mocc'].'" class="wppa-box wppa-name-desc" style="'.__wcs('wppa-box').__wcs('wppa-name-desc').'" >';
				wppa_slide_name($key);			// The name of the photo
		$wppa['out'] .= wppa_nltab('-').'</div><!-- #namedesc -->';
	}
}

function wppa_slide_desc_box($key = 'optional') {
global $wppa;
global $wppa_opt;

	$do_it = false;
	if ($key != 'optional') $do_it = true;
	if ($wppa['is_slideonly']) {
		if ($wppa['desc_on']) $do_it = true;
	}
	else {
		if (wppa_switch('wppa_show_full_desc')) $do_it = true;
	}
	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="descbox-'.$wppa['mocc'].'" class="wppa-box wppa-name-desc" style="'.__wcs('wppa-box').__wcs('wppa-name-desc').'" >';
				wppa_slide_description($key);		// The description of the photo
		$wppa['out'] .= wppa_nltab('-').'</div><!-- #namedesc -->';
	}
}

function wppa_slide_name($opt = '') {
global $wppa;
global $wppa_opt;

	if ( $wppa['is_slideonly'] ) {
		if ( $wppa['name_on'] ) $doit = true;
		else $doit = false;
	}
	else {
		if ( $opt == 'optional' ) {
			if ( wppa_switch('wppa_show_full_name') || wppa_switch('wppa_show_full_owner') ) $doit = true;
			else $doit = false;
		}
		else $doit = true;
	}
	if ( $opt == 'description' ) $doit = false;

	if ( $doit ) $wppa['out'] .= wppa_nltab().'<div id="imagetitle-'.$wppa['mocc'].'" class="wppa-fulltitle imagetitle" style="'.__wcs('wppa-fulltitle').'padding:3px; width:100%"></div>';
}

function wppa_slide_description($opt = '') {
global $wppa;
global $wppa_opt;

	if ( $wppa['is_slideonly'] ) {
		if ( $wppa['desc_on'] ) $doit = true;
		else $doit = false;
	}
	else {
		if ( $opt == 'optional' ) {
			if ( wppa_switch('wppa_show_full_desc') ) $doit = true;
			else $doit = false;
		}
		else $doit = true;
	}
	if ( $opt == 'name' ) $doit = false;

	if ( $doit ) $wppa['out'] .= wppa_nltab().'<div id="imagedesc-'.$wppa['mocc'].'" class="wppa-fulldesc imagedesc" style="'.__wcs('wppa-fulldesc').'padding:3px; width:100%; text-align:'.$wppa_opt['wppa_fulldesc_align'].'"></div>';
}

function wppa_slide_custom($opt = '') {
global $wppa;
global $wppa_opt;

	if ( $opt == 'optional' && ! wppa_switch('wppa_custom_on') ) return;
	if ( $wppa['is_slideonly'] == '1' ) return;	/* Not when slideonly */
	if ( is_feed() ) {
		return;
	}

	$content = __( stripslashes( $wppa_opt['wppa_custom_content'] ) );

	// w#albdesc
	if ( is_numeric( $wppa['start_album'] ) && $wppa['start_album'] > '0' ) {
		$content = str_replace( 'w#albdesc', wppa_get_album_desc( $wppa['start_album'] ), $content );
	}
	else {
		$content = str_replace( 'w#albdesc', '', $content );
	}
	// w#fotomoto
	if ( wppa_switch('wppa_fotomoto_on') ) {
		$fontsize = $wppa_opt['wppa_fotomoto_fontsize'];
		if ( $fontsize ) {
			$s = '<style>.FotomotoToolbarClass{font-size:'.$wppa_opt['wppa_fotomoto_fontsize'].'px !important;}</style>';
		}
		else $s = '';
		$content = str_replace( 'w#fotomoto',
								$s .
								'<div' .
									' id="wppa-fotomoto-container-'.$wppa['mocc'].'"' .
									' class="wppa-fotomoto-container"' .
									' >' .
								'</div>' .
								'<div' .
									' id="wppa-fotomoto-checkout-'.$wppa['mocc'].'"' .
									' class="wppa-fotomoto-checkout FotomotoToolbarClass"' .
									' style="float:right; clear:none;"' .
									' >' .
									'<ul' .
										' class="FotomotoBar"' .
										' style="list-style:none outside none;"' .
										' >' .
										'<li>' .
											'<a' .
											' onclick="FOTOMOTO.API.checkout(); return false;"' .
											' >' .
												__('Checkout') .
											'</a>' .
										'</li>' .
									'</ul>' .
								'</div>' .
								'<div' .
									' style="clear:both;"' .
									' >' .
								'</div>',
								$content );
	}
	else {
		$content = str_replace( 'w#fotomoto', '', $content );
	}

	$content = wppa_html($content);

	$wppa['out'] .= wppa_nltab('+').'<div id="wppa-custom-'.$wppa['mocc'].'" class="wppa-box wppa-custom" style="'.__wcs('wppa-box').__wcs('wppa-custom').'">';
		$wppa['out'] .= wppa_nltab().$content;
	$wppa['out'] .= wppa_nltab('-').'</div>';
}

function wppa_slide_rating($opt = '') {
global $wppa_opt;
	if ( $wppa_opt['wppa_rating_max'] == '1' ) wppa_slide_rating_vote_only($opt);
	else wppa_slide_rating_range($opt);
}

function wppa_slide_rating_vote_only($opt) {
global $wppa;
global $wppa_opt;

	if ($opt == 'optional' && !wppa_switch('wppa_rating_on')) return;
	if ($wppa['is_slideonly'] == '1') return;	/* Not when slideonly */
	if (is_feed()) {
		wppa_dummy_bar(__a('- - - Voting enabled - - -', 'wppa_theme'));
		return;
	}

	// Open the voting box
	$wppa['out'] .= '
	<!-- wppa-voting-'.$wppa['mocc'].' -->
	<div id="wppa-rating-'.$wppa['mocc'].'" class="wppa-box wppa-nav wppa-nav-text" style="'.__wcs('wppa-box').__wcs('wppa-nav').__wcs('wppa-nav-text').' text-align:center;">';

	if ( ! wppa_switch('wppa_rating_login') || is_user_logged_in() ) {	// Logged in or do'nt care
		$cnt = '0';
		if ( wppa_switch('wppa_show_avg_rating') ) {
			$wppa['out'] .= sprintf(__a('Number of votes: <span id="wppa-vote-count-%s" >%s</span>&nbsp;', 'wppa'), $wppa['mocc'], $cnt);
		}
		$wppa['out'] .= '<input id="wppa-vote-button-'.$wppa['mocc'].'" class="wppa-vote-button" style="margin:0;" type="button" onclick="wppaRateIt('.$wppa['mocc'].', 1)" value="'.$wppa_opt['wppa_vote_button_text'].'" />';
	}
	else {
		if ( wppa_switch( 'wppa_login_links' ) ) {
			$wppa['out'] .= sprintf(__a( 'You must <a href="%s">login</a> to vote' ), site_url('wp-login.php', 'login'));
		}
		else {
			$wppa['out'] .= __a( 'You must login to vote' );
		}
	}

	// Close the voting box
	$wppa['out'] .= '
	</div><!-- wppa-voting-'.$wppa['mocc'].' -->';

}

function wppa_slide_rating_range($opt) {
global $wppa;
global $wppa_opt;

	if ($opt == 'optional' && !wppa_switch('wppa_rating_on')) return;
	if ($wppa['is_slideonly'] == '1') return;	/* Not when slideonly */
	if (is_feed()) {
		wppa_dummy_bar(__a('- - - Rating enabled - - -', 'wppa_theme'));
		return;
	}

	$fs = $wppa_opt['wppa_fontsize_nav'];
	if ($fs != '') $fs += 3; else $fs = '15';	// iconsize = fontsize+3, Default to 15
	$dh = $fs + '6';
	$size = 'font-size:'.$fs.'px;';

	// Open the rating box
	$wppa['out'] .= '
	<!-- wppa-rating-'.$wppa['mocc'].' -->
	<div id="wppa-rating-'.$wppa['mocc'].'" class="wppa-box wppa-nav wppa-nav-text" style="'.__wcs('wppa-box').__wcs('wppa-nav').__wcs('wppa-nav-text').$size.' text-align:center;">';

	// Graphic display ?
	if ( $wppa_opt['wppa_rating_display_type'] == 'graphic' ) {
		if ( $wppa_opt['wppa_rating_max'] == '5' ) {
			$r['1'] = __a('very low', 'wppa_theme');
			$r['2'] = __a('low', 'wppa_theme');
			$r['3'] = __a('average', 'wppa_theme');
			$r['4'] = __a('high', 'wppa_theme');
			$r['5'] = __a('very high', 'wppa_theme');
		}
		else for ( $i = '1'; $i <= '10'; $i++ ) $r[$i] = $i;

		$style = 'style="height:'.$fs.'px; margin:0 0 -3px 0; padding:0; box-shadow:none; display:inline;"';
		$icon = 'star.png';

		// Display avg rating
		if ( wppa_switch('wppa_show_avg_rating') ) {
			$wppa['out'] .= '<span id="wppa-avg-rat-'.$wppa['mocc'].'">'.__a('Average&nbsp;rating', 'wppa_theme').'</span>&nbsp;';

			$i = '1';
			while ($i <= $wppa_opt['wppa_rating_max']) {
				$wppa['out'] .= wppa_nltab().'<img id="wppa-avg-'.$wppa['mocc'].'-'.$i.'" class="wppa-avg-'.$wppa['mocc'].' no-shadow" '.$style.' src="'.wppa_get_imgdir().$icon.'" alt="'.$i.'" title="'.__a('Average&nbsp;rating', 'wppa_theme').': '.$r[$i].'" />';
				$i++;
			}
		}

		$wppa['out'] .= '<img id="wppa-filler-'.$wppa['mocc'].'" src="'.wppa_get_imgdir().'transp.png" alt="f" style="width:'.$wppa_opt['wppa_ratspacing'].'px; height:15px; box-shadow:none; padding:0; margin:0; border:none;" />';

		// Display my rating
		if ( ! wppa_switch('wppa_rating_login') || is_user_logged_in() ) {	// Logged in or do'nt care
			// Show dislike icon?
			$pad = round(($wppa_opt['wppa_ratspacing'] - $fs) / 2);
			if ( $pad < 5 ) $pad = '5';
			$tdstyle = 'style="height:'.$fs.'px; margin:0 0 -3px 0; padding:0 '.$pad.'px; box-shadow:none; display:inline;"';
			if ( $wppa_opt['wppa_dislike_mail_every'] ) {
				$evnts = 'onmouseover="jQuery(this).stop().fadeTo(100, 1.0)" onmouseout="jQuery(this).stop().fadeTo(100, wppaStarOpacity)" onclick="if (confirm(\''.__a('Are you sure you want to mark this image as inappropriate?').'\')) wppaRateIt('.$wppa['mocc'].', -1)"';
				$title = 'title="'.__a('Click this if you do NOT like this image!', 'wppa_theme').'"';
				$wppa['out'] .= '<img id="wppa-dislike-'.$wppa['mocc'].'" '.$title.' src="'.wppa_get_imgdir().'thumbdown.png" alt="d" '.$tdstyle.' class="no-shadow" '.$evnts.' />';
				if ( wppa_switch('wppa_dislike_show_count') ) $wppa['out'] .= '<span id="wppa-discount-'.$wppa['mocc'].'" style="cursor:default" title="'.__a('Number of people who marked this photo as inapprpriate').'"></span>';
			}

			// Text left if no avg rating
			if ( ! wppa_switch('wppa_show_avg_rating') ) $wppa['out'] .= __a('My&nbsp;rating', 'wppa_theme').':&nbsp;';

			// Display the my rating stars
			$i = '1';
			while ($i <= $wppa_opt['wppa_rating_max']) {
				$wppa['out'] .= wppa_nltab().'<img id="wppa-rate-'.$wppa['mocc'].'-'.$i.'" class="wppa-rate-'.$wppa['mocc'].' no-shadow" '.$style.' src="'.wppa_get_imgdir().$icon.'" alt="'.$i.'" title="'.__a('My&nbsp;rating', 'wppa_theme').': '.$r[$i].'" onmouseover="wppaFollowMe('.$wppa['mocc'].', '.$i.')" onmouseout="wppaLeaveMe('.$wppa['mocc'].', '.$i.')" onclick="wppaRateIt('.$wppa['mocc'].', '.$i.')" />';
				$i++;
			}

			// Text right if avg rating diaplayed
			if ( wppa_switch('wppa_show_avg_rating') ) $wppa['out'] .= '&nbsp;'.'<span id="wppa-my-rat-'.$wppa['mocc'].'">'.__a('My&nbsp;rating', 'wppa_theme').'</span>';
		}
		else {
			if ( wppa_switch( 'wppa_login_links' ) ) {
				$wppa['out'] .= sprintf(__a( 'You must <a href="%s">login</a> to vote' ), site_url('wp-login.php', 'login'));
			}
			else {
				$wppa['out'] .= __a( 'You must login to vote' );
			}
		}
	}
	// display_type = numeric?
	elseif ( $wppa_opt['wppa_rating_display_type'] == 'numeric' ) {
		// Display avg rating
		if ( wppa_switch('wppa_show_avg_rating') ) {
			$wppa['out'] .= __a('Average&nbsp;rating', 'wppa_theme').':&nbsp;';
			$wppa['out'] .= '<span id="wppa-numrate-avg-'.$wppa['mocc'].'"></span>';
			$wppa['out'] .= ' &bull;';
		}

		// Display my rating
		if ( ! wppa_switch('wppa_rating_login') || is_user_logged_in() ) {	// Logged in or do'nt care
			// Show dislike icon?
			$pad = round(($wppa_opt['wppa_ratspacing'] - $fs) / 2);
			if ( $pad < 5 ) $pad = '5';
			$tdstyle = 'style="height:'.$fs.'px; margin:0 0 -3px 0; padding:0 '.$pad.'px; box-shadow:none; display:inline;"';
			if ( $wppa_opt['wppa_dislike_mail_every'] ) {
				$evnts = 'onmouseover="jQuery(this).stop().fadeTo(100, 1.0)" onmouseout="jQuery(this).stop().fadeTo(100, wppaStarOpacity)" onclick="if (confirm(\''.__a('Are you sure you want to mark this image as inappropriate?').'\')) wppaRateIt('.$wppa['mocc'].', -1)"';
				$title = 'title="'.__a('Click this if you do NOT like this image!', 'wppa_theme').'"';
				$wppa['out'] .= '<div id="wppa-dislike-imgdiv-'.$wppa['mocc'].'" style="display:inline" ><img id="wppa-dislike-'.$wppa['mocc'].'" '.$title.' src="'.wppa_get_imgdir().'thumbdown.png" alt="d" '.$tdstyle.' class="no-shadow" '.$evnts.' /> </div>';
				if ( wppa_switch('wppa_dislike_show_count') ) $wppa['out'] .= '<span id="wppa-discount-'.$wppa['mocc'].'" style="cursor:default" title="'.__a('Number of people who marked this photo as inapprpriate').'"></span>';
			}
			// Filler
//			$wppa['out'] .= '<span id="wppa-filler-'.$wppa['mocc'].'" > -</span>';

			//
			$wppa['out'] .= ' '.__a('My rating:', 'wppa_theme');
			$wppa['out'] .= '<span id="wppa-numrate-mine-'.$wppa['mocc'].'"></span>';
		}
		else {
			if ( wppa_switch( 'wppa_login_links' ) ) {
				$wppa['out'] .= sprintf(__a( 'You must <a href="%s">login</a> to vote' ), site_url('wp-login.php', 'login'));
			}
			else {
				$wppa['out'] .= __a( 'You must login to vote' );
			}
		}
	}

	// Close rating box
	$wppa['out'] .= '
	</div><!-- wppa-rating-'.$wppa['mocc'].' -->';
}

function wppa_slide_filmstrip($opt = '') {
global $wppa;
global $wppa_opt;

	// A single image slideshow needs no navigation
	if ( $wppa['is_single'] ) return;

	$do_it = false;												// Init
	if ( is_feed() ) $do_it = true;								// feed -> do it to indicate that there is a slideshow
	else {														// Not a feed
		if ( $opt != 'optional' ) $do_it = true;				// not optional -> do it
		else {													// optional
			if ( wppa_switch('wppa_filmstrip') ) {				// optional and option on
				if ( ! $wppa['is_slideonly'] ) $do_it = true;	// always except slideonly
			}
			if ( $wppa['film_on'] ) $do_it = true;				// explicitly turned on
		}
	}
	if ( ! $do_it ) return;										// Don't do it

	$t = -microtime(true);

	$alb = wppa_get_get('album');	// To be tested: // Album id is in $wppa['start_album']

	$thumbs = wppa_get_thumbs($alb);
	if (!$thumbs || count($thumbs) < 1) return;

	$preambule = wppa_get_preambule();

	$width = ($wppa_opt['wppa_tf_width'] + $wppa_opt['wppa_tn_margin']) * (count($thumbs) + 2 * $preambule);
	$width += $wppa_opt['wppa_tn_margin'] + 2;
	$topmarg = $wppa_opt['wppa_thumbsize'] / 2 - 16;
	$height = $wppa_opt['wppa_thumbsize']+$wppa_opt['wppa_tn_margin'];
	$height1 = $wppa_opt['wppa_thumbsize'];
	$marg = '42';	// 32
	$fs = '24';
	$fw = '42';
	if ($wppa['in_widget']) {
		$width /= 2;
		$topmarg /= 2;
		$height /= 2;
		$height1 /= 2;
		$marg = '21';
		$fs = '12';
		$fw = '21';
	}

	$conw = wppa_get_container_width();
	if ( $conw < 1 ) $conw *= 640;
	$w = $conw - ( 2*6 + 2*42 + 2*$wppa_opt['wppa_bwidth']); /* 2*padding + 2*arrows + 2*border */
	if ($wppa['in_widget']) $w = $conw - ( 2*6 + 2*21 + 2*$wppa_opt['wppa_bwidth']); /* 2*padding + 2*arrow + 2*border */
	$IE6 = 'width: '.$w.'px;';
	$pagsiz = round($w / ($wppa_opt['wppa_thumbsize'] + $wppa_opt['wppa_tn_margin']));
	if ($wppa['in_widget']) $pagsiz = round($w / ($wppa_opt['wppa_thumbsize']/2 + $wppa_opt['wppa_tn_margin']/2));

	wppa_add_js_page_data( '<script type="text/javascript">' );
//		$wppa['out'] .= wppa_nltab('+').'/* <![CDATA[ */';
			wppa_add_js_page_data( 'wppaFilmPageSize['.$wppa['mocc'].'] = '.$pagsiz.';' );
//		$wppa['out'] .= wppa_nltab('-').'/* ]]> */';
	wppa_add_js_page_data( '</script>' );

	if (is_feed()) {
		$wppa['out'] .= wppa_nltab().'<div style="'.__wcs('wppa-box').__wcs('wppa-nav').'">';
	}
	else {

	$wppa['out'] .= wppa_nltab('+').'<div class="wppa-box wppa-nav" style="text-align:center; '.__wcs('wppa-box').__wcs('wppa-nav').'height:'.$height.'px;">';
		$wppa['out'] .= wppa_nltab().'<div style="float:left; text-align:left; cursor:pointer; margin-top:'.$topmarg.'px; width: '.$fw.'px; font-size: '.$fs.'px;">';
			$wppa['out'] .= wppa_nltab().'<a class="wppa-prev-'.$wppa['mocc'].' wppa-arrow" style="'.__wcs('wppa-arrow').'" id="prev-film-arrow-'.$wppa['mocc'].'" onclick="wppaFirst('.$wppa['mocc'].');" title="'.__a('First', 'wppa_theme').'" >&laquo;</a>';
			$wppa['out'] .= wppa_nltab().'<a class="wppa-prev-'.$wppa['mocc'].' wppa-arrow" style="'.__wcs('wppa-arrow').'" id="prev-film-arrow-1-'.$wppa['mocc'].'" onclick="wppaPrev('.$wppa['mocc'].');" title="'.__a('Previous', 'wppa_theme').'" >&lsaquo;</a>';
		$wppa['out'] .= wppa_nltab().'</div>';
		$wppa['out'] .= wppa_nltab().'<div style="float:right; text-align:right; cursor:pointer; margin-top:'.$topmarg.'px; width: '.$fw.'px; font-size: '.$fs.'px;">';
			$wppa['out'] .= wppa_nltab().'<a class="wppa-next-'.$wppa['mocc'].' wppa-arrow" style="'.__wcs('wppa-arrow').'" id="next-film-arrow-1-'.$wppa['mocc'].'" onclick="wppaNext('.$wppa['mocc'].');" title="'.__a('Next', 'wppa_theme').'" >&rsaquo;</a>';
			$wppa['out'] .= wppa_nltab().'<a class="wppa-next-'.$wppa['mocc'].' wppa-arrow" style="'.__wcs('wppa-arrow').'" id="next-film-arrow-'.$wppa['mocc'].'" onclick="wppaLast('.$wppa['mocc'].');" title="'.__a('Last', 'wppa_theme').'" >&raquo;</a>';
		$wppa['out'] .= wppa_nltab().'</div>';
		$wppa['out'] .= wppa_nltab().'<div id="filmwindow-'.$wppa['mocc'].'" class="filmwindow" style="'.$IE6.' position:absolute; display: block; height:'.$height.'px; margin: 0 0 0 '.$marg.'px; overflow:hidden;">';
			$wppa['out'] .= wppa_nltab('+').'<div id="wppa-filmstrip-'.$wppa['mocc'].'" style="height:'.$height1.'px; width:'.$width.'px; max-width:'.$width.'px;margin-left: -100px;">';
	}

	$cnt = count($thumbs);
	$start = $cnt - $preambule;
	$end = $cnt;
	$idx = $start;
	/* #wppa-container-'.$wppa['mocc'].' */
	$wppa['out'] .= '
			<style type="text/css" scoped >
				 .thumbnail-frame { '.wppa_get_thumb_frame_style(false, 'film').' }
				.wppa-filmthumb-active { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
			</style>';

	while ($idx < $end) {
		$glue = $cnt == ($idx + 1) ? true : false;
		$ix = $idx;
		while ($ix < 0) $ix += $cnt;
		$thumb = $thumbs[$ix];
		wppa_do_filmthumb($thumb['id'], $ix, false, $glue);
		$idx++;
	}
	$idx = 0;
	foreach ($thumbs as $tt) : $thumb = $tt;
		$glue = $cnt == ($idx + 1) ? true : false;
		wppa_do_filmthumb($thumb['id'], $idx, true, $glue);
		$idx++;
	endforeach;
	$start = '0';
	$end = $preambule;
	$idx = $start;
	while ($idx < $end) {
		$ix = $idx;
		while ($ix >= $cnt) $ix -= $cnt;
		$thumb = $thumbs[$ix];
		wppa_do_filmthumb($thumb['id'], $ix, false);
		$idx++;
	}

	if (is_feed()) {
		$wppa['out'] .= wppa_nltab('-').'</div>';
	}
	else {
			$wppa['out'] .= wppa_nltab('-').'</div>';
		$wppa['out'] .= wppa_nltab('-').'</div>';
	$wppa['out'] .= wppa_nltab('-').'</div>';
	}

	$t += microtime(true);
	wppa_dbg_msg('Filmstrip took '.$t.' seconds.');
}

function wppa_numberbar($opt = '') {
global $wppa;
global $wppa_opt;

	// A single image slideshow needs no navigation
	if ( $wppa['is_single'] ) return;

	if (is_feed()) { 		//don't know if it works with feeds, so switch off
		return;
	}

    $do_it = false;
    if( wppa_switch('wppa_show_slideshownumbar') && !$wppa['is_slideonly']) $do_it = true;
	if ($wppa['numbar_on']) $do_it = true;
	if(!$do_it){
		return;
	}

	// get the data
	$thumbs = wppa_get_thumbs();
	if (!$thumbs || count($thumbs) < 1) return;

	// get the sizes
	$size_given = is_numeric($wppa_opt['wppa_fontsize_numbar']);
	if ($size_given) {
		$size = $wppa_opt['wppa_fontsize_numbar'];
		if ($wppa['in_widget']) $size /= 2;
	}
	else {
		$size = $wppa['in_widget'] ? '9' : '12';
	}
	if ($size < '9') $size = '9';
	$size_2 = floor($size / 2);
	$size_4 = floor($size_2 / 2);
	$size_32 = floor($size * 3 / 2);

	// make the numbar style
	$style = 'position:absolute; bottom:'.$size.'px; right:0; margin-right:'.$size_2.'px; ';

	// start the numbar
	$wppa['out'] .= wppa_nltab('+') . '<div class="wppa-numberbar" style="'.$style.'">';
		$numid = 0;

		// make the elementstyles
		$style = 'display:block; float:left; padding:0 '.$size_4.'px; margin-right:'.$size_2.'px; font-weight:'.$wppa_opt['wppa_fontweight_numbar'].'; ';
		if ($wppa_opt['wppa_fontfamily_numbar']) $style .= ' font-family:'.$wppa_opt['wppa_fontfamily_numbar'].';';
		if ($wppa_opt['wppa_fontcolor_numbar']) $style .= ' color:'.$wppa_opt['wppa_fontcolor_numbar'].';';
		if ($size_given) $style .= ' font-size:'.$size.'px; line-height:'.$size_32.'px;';

		$style_active = $style;
		if ($wppa_opt['wppa_bgcolor_numbar']) $style .= ' background-color:'.$wppa_opt['wppa_bgcolor_numbar'].';';
		if ($wppa_opt['wppa_bgcolor_numbar_active']) $style_active .= ' background-color:'.$wppa_opt['wppa_bgcolor_numbar_active'].';';
		if ($wppa_opt['wppa_bcolor_numbar']) $style .= ' border:1px solid '.$wppa_opt['wppa_bcolor_numbar'].';';
		if ($wppa_opt['wppa_bcolor_numbar_active']) $style_active .= 'border:1px solid '.$wppa_opt['wppa_bcolor_numbar_active'].';';

		// if the number of photos is larger than a certain number, only the active ph displays a number, other are dots
		$count = count($thumbs);
		$high = $wppa_opt['wppa_numbar_max'];

		// do the numbers
		foreach ($thumbs as $tt) :
			$title = sprintf(__a('Photo %s of %s', 'wppa_theme'), $numid + '1', $count);
			$wppa['out'] .= wppa_nltab('+') . '<a id="wppa-numbar-'.$wppa['mocc'].'-'.$numid.'" title="'.$title.'" ' . ($numid == 0 ? ' class="wppa-numbar-current" ' : '') . ' style="' . ($numid == 0 ? $style_active : $style) . '" onclick="wppaGotoKeepState('.$wppa['mocc'].',' . $numid . ');return false;">';
			$wppa['out'] .= $count > $high ? wppa_nltab() . '.' : wppa_nltab() . $numid + 1;
			$wppa['out'] .= wppa_nltab('-') . '</a>';
			$numid++;
		endforeach;
	$wppa['out'] .= wppa_nltab('-') . '</div>';
}

function wppa_browsebar($opt = '') {
global $wppa;
global $wppa_opt;

	// A single image slideshow needs no navigation
	if ( $wppa['is_single'] ) return;

	if (is_feed()) {
//		wppa_dummy_bar(__('- - - Browse navigation bar - - -', 'wppa_theme'));
		return;
	}
	$do_it = false;
	if ( $opt != 'optional' ) $do_it = true;
	if ( ! $wppa['is_slideonly'] && wppa_switch('wppa_show_browse_navigation') ) $do_it = true;
	if ( $wppa['is_slideonly'] && $wppa['browse_on'] ) $do_it = true;

	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="prevnext2-'.$wppa['mocc'].'" class="wppa-box wppa-nav wppa-nav-text" style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-nav').__wcs('wppa-nav-text').'">';
//			$wppa['out'] .= wppa_nltab().'<span id="p-a-'.$wppa['mocc'].'" class="wppa-prev-'.$wppa['mocc'].' wppa-nav-text wppa-arrow" style="float:left; text-align:left; '.__wcs('wppa-nav-text').__wcs('wppa-arrow').'">&laquo;&nbsp;</span>';
			$wppa['out'] .= wppa_nltab().'<a id="prev-arrow-'.$wppa['mocc'].'" class="wppa-prev-'.$wppa['mocc'].' wppa-nav-text arrow-'.$wppa['mocc'].'" style="float:left; text-align:left; cursor:pointer; '.__wcs('wppa-nav-text').'" onclick="wppaPrev('.$wppa['mocc'].')" ></a>';
//			$wppa['out'] .= wppa_nltab().'<span id="n-a-'.$wppa['mocc'].'" class="wppa-next-'.$wppa['mocc'].' wppa-nav-text wppa-arrow" style="float:right; text-align:right; '.__wcs('wppa-nav-text').__wcs('wppa-arrow').'">&nbsp;&raquo;</span>';
			$wppa['out'] .= wppa_nltab().'<a id="next-arrow-'.$wppa['mocc'].'" class="wppa-next-'.$wppa['mocc'].' wppa-nav-text arrow-'.$wppa['mocc'].'" style="float:right; text-align:right; cursor:pointer; '.__wcs('wppa-nav-text').'" onclick="wppaNext('.$wppa['mocc'].')"></a>';
			$wppa['out'] .= wppa_nltab().'<span id="counter-'.$wppa['mocc'].'" class="wppa-nav-text wppa-black" style="text-align:center; '.__wcs('wppa-nav-text').'; cursor:pointer;" onclick="wppaStartStop('.$wppa['mocc'].', -1);" title="'.__a('Click to start/stop', 'wppa_theme').'"></span>';
		$wppa['out'] .= wppa_nltab('-').'</div><!-- #prevnext2 -->';
	}
}


// Comments box
function wppa_comments($opt = '') {
global $wppa;
global $wppa_opt;

	if (is_feed()) {
		if ( wppa_switch('wppa_show_comments') ) wppa_dummy_bar(__a('- - - Comments box activated - - -', 'wppa_theme'));
		return;
	}
	$do_it = false;
	if ( $opt != 'optional' ) $do_it = true;
	if ( !$wppa['is_slideonly'] && wppa_switch('wppa_show_comments') && !$wppa['in_widget'] ) $do_it = true;

	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="wppa-comments-'.$wppa['mocc'].'" class="wppa-box wppa-comments " style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-comments').'">';

		$wppa['out'] .= wppa_nltab('-').'</div><!-- #comments -->';
	}

}

// The IPTC box
function wppa_iptc($opt = '') {
global $wppa;
global $wppa_opt;

	if (is_feed()) {
		if ( wppa_switch('wppa_show_iptc') ) wppa_dummy_bar(__a('- - - IPTC box activated - - -', 'wppa_theme'));
		return;
	}
	$do_it = false;
	if ($opt != 'optional') $do_it = true;
	if (!$wppa['is_slideonly'] && wppa_switch('wppa_show_iptc')) $do_it = true;

	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="iptc-'.$wppa['mocc'].'" class="wppa-box wppa-box-text wppa-iptc " style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-box-text').__wcs('wppa-iptc').'">';

		$wppa['out'] .= wppa_nltab('-').'</div><!-- #iptc -->';
	}
}

// The EXIF box
function wppa_exif($opt = '') {
global $wppa;
global $wppa_opt;

	if (is_feed()) {
		if ( wppa_switch('wppa_show_exif') ) wppa_dummy_bar(__a('- - - EXIF box activated - - -', 'wppa_theme'));
		return;
	}
	$do_it = false;
	if ($opt != 'optional') $do_it = true;
	if (!$wppa['is_slideonly'] && wppa_switch('wppa_show_exif')) $do_it = true;

	if ($do_it) {
		$wppa['out'] .= wppa_nltab('+').'<div id="exif-'.$wppa['mocc'].'" class="wppa-box wppa-box-text wppa-exif " style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-box-text').__wcs('wppa-exif').'">';

		$wppa['out'] .= wppa_nltab('-').'</div><!-- #exif -->';
	}
}

// The Sharebox
function wppa_share($opt = '') {
global $wppa;
global $wppa_opt;

	if ( is_feed() ) {
		return;
	}
	$do_it = false;
	if ( $opt != 'optional' ) $do_it = true;
	if ( ! $wppa['is_slideonly'] ) {
		if ( wppa_switch('wppa_share_on') && ! $wppa['in_widget'] ) $do_it = true;
		if ( wppa_switch('wppa_share_on_widget') && $wppa['in_widget'] ) $do_it = true;
	}

	if ( $do_it ) {
		$wppa['out'] .= wppa_nltab('+').'<div id="wppa-share-'.$wppa['mocc'].'" class="wppa-box wppa-box-text wppa-share " style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-box-text').__wcs('wppa-share').'">';

		$wppa['out'] .= wppa_nltab('-').'</div><!-- #share -->';
	}
}

// Errorbox
function wppa_errorbox($text) {
global $wppa;

	$wppa['out'] .= wppa_nltab('+').'<div id="error-'.$wppa['mocc'].'" class="wppa-box wppa-box-text wppa-nav wppa-errorbox " style="text-align: center; '.__wcs('wppa-box').__wcs('wppa-box-text').__wcs('wppa-nav').'">';
	$wppa['out'] .= wppa_nltab().$text;
	$wppa['out'] .= wppa_nltab('-').'</div><!-- #error -->';
}