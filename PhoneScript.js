var x1 = null ;
var y1 = null ;

function AddTouchHandlers () {
	document.addEventListener('touchstart', TouchStartHandler, false);        
	document.addEventListener('touchmove', TouchMoveHandler, false);
}

function RemoveTouchHandlers () {
	document.removeEventListener ("touchstart", TouchStartHandler, false);
	document.removeEventListener ("touchstart", TouchMoveHandler, false);
}

function getTouches (evt){
	return evt.touches ;
}


function TouchStartHandler (evt) {
	const firstTouch = getTouches (evt)[0];
	x1 = firstTouch.clientX;
	y1 = firstTouch.clientY ;
}

function TouchMoveHandler (evt) {
	
	if (!x1 || !y1){
		return ;
	}
	
	const secondTouch = getTouches (evt)[0];

	var x2 = secondTouch.clientX;
	var y2 = secondTouch.clientY;

	var xDiff = x2 - x1 ;
	var yDiff = y2 - y1 ;

	if (Math.abs (xDiff) < 300 && Math.abs (yDiff) < 200) return ;

	if (Math.abs (xDiff) > Math.abs(yDiff)) {
		if (xDiff > 0 ){
			SwipeRight () ;
		}else {
			SwipeLeft () ;
		}
	}else {
		if ( yDiff > 0){
			SwipeDown () ;
		}else {
			SwipeUp () ;
		}
	}

}