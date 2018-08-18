$(document).ready(function(){
	// demo.initChartist();

	// $.notify({
	// 	icon: 'pe-7s-gift',
	// 	message: "Chào mừng tới admin <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."

	// },{
	// 	type: 'info',
	// 	timer: 800
	// });

	$(".sidebar-wrapper ul.nav li").click(function () {
		$(".sidebar-wrapper ul.nav li").removeClass('active');
		$(this).addClass('active');
	});

	$( function() {
    // run the currently selected effect
    function runEffect(effect) {
      // get effect type from
      var selectedEffect = "blind";
 
      // Most effect types need no options passed by default
      var options = {};
      // some effects have required parameters
      if ( selectedEffect === "scale" ) {
        options = { percent: 50 };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: 200, height: 60 } };
      }
 
      // Run the effect
      effect.toggle( selectedEffect, options, 500 );
      // $( "#effect" ).toggle( selectedEffect, options, 500 );
    };
 
    // Set effect from select menu value
    $( ".clickbutton" ).on( "click", function() {
      runEffect($( ".clickbutton ul.toggler" ));
    });
  } );

});