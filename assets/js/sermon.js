jQuery(document).ready(function($){
	
	var audio_url = $('#sermon').data('audio-url');

	$("#sermon").jPlayer({
		ready: function (event) {
			$(this).jPlayer("setMedia", {
				mp3: audio_url
			});
		},
		swfPath: "../../dist/jplayer",
		supplied: "mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});

	$('.play-button').on('click', function(){
		
		if ( $(this).hasClass('playing') ) {
			
			$(this).removeClass('playing');
			$('#sermon').jPlayer('pause');

		} else {

			$(this).addClass('playing');
			$('#sermon').jPlayer('play');

		}

	});

});