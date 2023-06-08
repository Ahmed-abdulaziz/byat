//jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $(document).on('click', 'a.page-scroll', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});


$( document ).ready(function() {


  $(".boxdana").hide(); //Hide all content
$("ul.tabs li:first").addClass("active").show(); //Activate first tab
$(".boxdana:first").show(); //Show first tab content
//On Click Event
$("ul.tabs li").click(function() {
$("ul.tabs li").removeClass("active"); //Remove any "active" class
$(this).addClass("active"); //Add "active" class to selected tab
$(".boxdana").hide(); //Hide all tab content
var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
$(activeTab).fadeIn(); //Fade in the active content
return false;
});
  });