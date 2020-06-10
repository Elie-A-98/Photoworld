window.onscroll = function () {StickyHeader ()};
// window.onresize = function () {OnResize ()}

var header = document.getElementById ("header_id");
var stickyHeader = document.getElementById ("stickyheader_id");
var bars = document.getElementById ("bars");
var overlay = document.getElementById ("overlay");
var pageContent = document.getElementById ("pageContent");
var content = document.getElementById ("content");

var modal;

var stickyHeaderOffsetTop = stickyHeader.offsetTop ;

function FixContentPosition (offset) {
    content.style.paddingTop = offset+"px";
}


function StickyHeader () {
   
    if (window.pageYOffset > stickyHeaderOffsetTop ){
		stickyHeader.classList.add ("stickynavbar", "w3-card-4");
		FixContentPosition (stickyHeader.offsetHeight);
    }else {
		stickyHeader.classList.remove  ("stickynavbar", "w3-card-4");
		FixContentPosition (0);
    }
}

function OpenBars () {
    
    if (bars.className.indexOf ("w3-show") == -1){
        bars.classList.add ("w3-show");
        overlay.classList.add ("w3-show");
    }else {
        bars.classList.remove ("w3-show");
        overlay.classList.remove ("w3-show");
    }

}

function CloseBars () {
    bars.classList.remove ("w3-show");
    overlay.classList.remove ("w3-show");
}

