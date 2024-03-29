// wppa-touch.js
//
// Contains swipe modules
// Dependancies: wppa.js and default wp jQuery library
// 
var wppaJsTouchVersion = '6.1.9';

var wppaTriggerElementID 	= null; 
var wppaFingerCount 		= 0;
var wppaStartX 				= 0;
var wppaStartY 				= 0;
var wppaCurX 				= 0;
var wppaCurY 				= 0;
var wppaDeltaX 				= 0;
var wppaDeltaY 				= 0;
var wppaHorzDiff 			= 0;
var wppaVertDiff 			= 0;
var wppaMinLength 			= 72; 
var wppaSwipeLength 		= 0;
var wppaSwipeAngle 			= null;
var wppaSwipeDirection 		= null;
var wppaSwipeOnLightbox 	= false;

function wppaTouchStart( event, id, mocc ) {

	if ( mocc == -1 ) {
		wppaSwipeOnLightbox = true;
		event.preventDefault();
	}
	
	wppaFingerCount = event.touches.length;

	if ( wppaFingerCount == 1 ) {
		wppaStartX = event.touches[0].pageX;
		wppaStartY = event.touches[0].pageY;
		wppaTriggerElementID = id;
	} else {
		wppaTouchCancel();
	}
}

function wppaTouchMove( event ) {

	if ( wppaSwipeOnLightbox ) {
		event.preventDefault();
	}
	
	if ( event.touches.length == 1 ) {
		wppaCurX = event.touches[0].pageX;
		wppaCurY = event.touches[0].pageY;
	} else {
		wppaTouchCancel();
	}
}

function wppaTouchEnd( event ) {

	if ( wppaSwipeOnLightbox ) {
		event.preventDefault();
	}
	
	if ( wppaFingerCount == 1 && wppaCurX != 0 ) {
		wppaSwipeLength = Math.round( Math.sqrt( Math.pow( wppaCurX - wppaStartX,2 ) + Math.pow( wppaCurY - wppaStartY,2 ) ) );
		if ( wppaSwipeLength >= wppaMinLength ) {
			wppaCalculateAngle();
			wppaDetermineSwipeDirection();
			wppaProcessingRoutine();
		} 
	}
	wppaTouchCancel();
}

function wppaTouchCancel() {
	wppaFingerCount 		= 0;
	wppaStartX 				= 0;
	wppaStartY 				= 0;
	wppaCurX 				= 0;
	wppaCurY 				= 0;
	wppaDeltaX 				= 0;
	wppaDeltaY 				= 0;
	wppaHorzDiff 			= 0;
	wppaVertDiff 			= 0;
	wppaSwipeLength 		= 0;
	wppaSwipeAngle 			= null;
	wppaSwipeDirection 		= null;
	wppaTriggerElementID 	= null;
	wppaSwipeOnLightbox 	= false;
}

function wppaCalculateAngle() {

	var X = wppaStartX-wppaCurX;
	var Y = wppaCurY-wppaStartY;
	var Z = Math.round( Math.sqrt( Math.pow( X,2 )+Math.pow( Y,2 ) ) ); //the distance - rounded - in pixels
	var r = Math.atan2( Y,X ); //angle in radians ( Cartesian system )
	
	wppaSwipeAngle = Math.round( r*180/Math.PI ); //angle in degrees
	
	if ( wppaSwipeAngle < 0 ) { 
		wppaSwipeAngle =  360 - Math.abs( wppaSwipeAngle ); 
	}
}

function wppaDetermineSwipeDirection() {

	if ( ( wppaSwipeAngle <= 45 ) && ( wppaSwipeAngle >= 0 ) ) {
		wppaSwipeDirection = 'left';
	} 
	else if ( ( wppaSwipeAngle <= 360 ) && ( wppaSwipeAngle >= 315 ) ) {
		wppaSwipeDirection = 'left';
	} 
	else if ( ( wppaSwipeAngle >= 135 ) && ( wppaSwipeAngle <= 225 ) ) {
		wppaSwipeDirection = 'right';
	} 
	else if ( ( wppaSwipeAngle > 45 ) && ( wppaSwipeAngle < 135 ) ) {
		wppaSwipeDirection = 'down';
	} 
	else {
		wppaSwipeDirection = 'up';
	}
}

function wppaProcessingRoutine() {

	var swipedElement = document.getElementById( wppaTriggerElementID );
	
	// swipe on ligtbox image
	if ( mocc == -1 ) { 
		if ( wppaSwipeDirection == 'left' ) {
			wppaOvlShowNext();
		}
		else if ( wppaSwipeDirection == 'right' ) {
			wppaOvlShowPrev();
		}		
	}
	
	// swipe on slideshow
	else {	
		if ( wppaSwipeDirection == 'right' ) {	
			idx = _wppaCurIdx[mocc] - 1;
			if ( idx < 0 ) {
				if ( ! wppaSlideWrap ) {
					return;
				}
				idx = _wppaSlides[mocc].length - 1;
			}
			wppaGotoKeepState( mocc , idx );
		}
		if ( wppaSwipeDirection == 'left' ) {	
			idx = _wppaCurIdx[mocc] + 1;
			if ( idx == _wppaSlides[mocc].length ) {
				if ( ! wppaSlideWrap ) {
					return;
				}
				idx = 0;
			}
			wppaGotoKeepState( mocc , idx );
		}
		else if ( wppaSwipeDirection == 'up' ) {
		} 
		else if ( wppaSwipeDirection == 'down' ) {
		}
	}
	
	wppaTouchCancel();	// Reset
}

// Say we're in
wppaConsoleLog( 'wppa-touch.js version '+wppaJsTouchVersion+' loaded.', 'force' );