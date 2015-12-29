<?php
	// Setup hero player for non sermon pages
	if ( get_post_type() != 'sermon' ) {

		$args = array(
			'post_type' => 'sermon',
			'posts_per_page' => 1,
		);

		$sermons = get_posts( $args );

	}

	if( $sermons ):
		$sermon_title = $sermons[0]->post_title;
		$sermon_preacher = get_post_meta( $sermons[0]->ID, 'sermon_preacher', true );
		$sermon_date = date("l F d, Y", strtotime( get_post_meta( $sermons[0]->ID, 'sermon_date', true ) ) );
		$sermon_audio = get_post_meta( $sermons[0]->ID, 'sermon_audio', true );
		$sermon_video = get_post_meta( $sermons[0]->ID, 'sermon_video', true );
?>
<div class="sermon-player-hero">
	<div id="sermon" class="jp-jplayer" data-audio-url="<?php echo $sermon_audio; ?>" data-video-url="<?php echo $sermon_video; ?>"></div>
	<div id="sermon-player">
		<h2><?php echo $sermon_title; ?></h2>
		<p><?php if ( get_post_type() != 'sermon' ) { echo "<strong>Featured Sermon</strong> by "; } ?><?php echo $sermon_preacher ?></p>
		<a class="play-button">
			<span class="play"><i class="fa fa-play-circle-o"></i></span>
			<span class="pause"><i class="fa fa-pause"></i></span>
		</a>
		<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0"><i class="fa fa-volume-off"></i></button>
						<button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
						<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<div id="message" class="row">
		<h2>The word brings out the best in us</h2>
		<p>Ephesians 5:25</p>
	</div>
<?php endif; ?>