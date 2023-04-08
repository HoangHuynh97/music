<div class="mm-container-bot">
	<div class="sc-container-left">
		<div class="c-img-song">
			<img id="img-song" src="<?=$dataRow->image?>" alt="">
		</div>
		<div class="c-content-song">
			<div class="c-title-song">
				<span id="name-song"><?=$dataRow->name?></span>
			</div>
			<div class="c-title-singer">
				<span id="name-singer"><?=$dataRow->id_singer?></span>
			</div>
		</div>
	</div>
	<div class="sc-container-center">
		<div class="sc-action-music">
			<div class="c-i-action-m">
				<i class="fa-solid fa-shuffle"></i>
			</div>
			<div class="c-i-action-m">
				<i class="fa-solid fa-backward-step"></i>
			</div>
			<div class="c-i-action-m play">
				<i id="play-song" class="fa-solid fa-caret-right" onclick="onPlay();"></i>
				<i id="pause-song" class="fa-solid fa-pause hidden" onclick="onPause();"></i>
			</div>
			<div class="c-i-action-m">
				<i class="fa-solid fa-forward-step"></i>
			</div>
			<div class="c-i-action-m">
				<i class="fa-solid fa-arrows-rotate"></i>
			</div>
		</div>
		<div class="sc-time-m">
			<div class="sc-curent-time" id="set_time">00:00</div>
			<input id="point_timeline" class="sc-time-line" type="range" min="0" max="10000" value="0" oninput="changeTime()">
			<div class="sc-end-time">04:14</div>
		</div>
	</div>
	<div class="sc-container-right">
		<div class="c-icon-action">
			<i class="fa-regular fa-heart"></i>
			<!-- <i class="fa-solid fa-heart"></i> -->
		</div>
		<div class="c-icon-action">
			<span>mv</span>
		</div>
		<div class="c-icon-action">
			<i class="fa-solid fa-volume-high"></i>
			<!-- <i class="fa-solid fa-volume-low"></i>
			<i class="fa-solid fa-volume-xmark"></i> -->
		</div>
		<div class="c-volume-setting" id="volume">
			<input class="sc-point-volume" type="range" min="0" max="100" value="100">
		</div>
		<div class="line-sp"></div>
		<div class="c-icon-action action-bar">
			<i class="fa-solid fa-bars"></i>
		</div>
	</div>

	<!-- set audio -->
	<div id="clear_audio" class="clear-audio">
		<div data-video="<?=$dataRow->id_youtube?>"  
	        data-autoplay="0"
	        id="youtube-audio">
		</div>
		<script src="https://www.youtube.com/iframe_api"></script>
		<script src="https://cdn.rawgit.com/labnol/files/master/yt.js"></script>
	</div>
	<!-- end -->
</div>
<script type="text/javascript">
	var point = '04:14';
	var a = point.split(':');

	function changeTime() {
  		if(a[2]) {
  			var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
  		} else {
  			var seconds = (+a[0]) * 60 + (+a[1]);
  		}
  		var secondToPoint = seconds/10000;
  		var getTimeOnPoint = $("#point_timeline").val()*secondToPoint; //Số giây đã chạy

  		if(a[2]) {
  			var coverStr = new Date(getTimeOnPoint * 1000).toISOString().substring(11, 19);
  		} else {
  			var coverStr = new Date(getTimeOnPoint * 1000).toISOString().substring(14, 19);
  		}
  		
  		$('#set_time').html(coverStr);
	}

	var timeOut = 0;
	var pointOut = 0;
	function checkPlayMusic() {
		timeOut++;

		if(a[2]) {
  			var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
  		} else {
  			var seconds = (+a[0]) * 60 + (+a[1]);
  		}

		if(timeOut <= seconds) {
			if(a[2]) {
	  			var coverStr = new Date(timeOut * 1000).toISOString().substring(11, 19);
	  		} else {
	  			var coverStr = new Date(timeOut * 1000).toISOString().substring(14, 19);
	  		}
	  		$('#set_time').html(coverStr);

	  		var secondToPoint = 10000/seconds;
	  		pointOut += secondToPoint;
	  		$("#point_timeline").val(pointOut);
		}
	}

	var refreshIntervalId;
	function onPlay() {
		refreshIntervalId = setInterval(() => checkPlayMusic(), 1000);
		$('#youtube-audio').click();
		$('#play-song').addClass('hidden');
		$('#pause-song').removeClass('hidden');
	}

	function onPause() {
		clearInterval(refreshIntervalId);
		$('#youtube-audio').click();
		$('#play-song').removeClass('hidden');
		$('#pause-song').addClass('hidden');
	}

	function change(id, image, name, singer) {
		onPause();

		$('#img-song').attr('src', image);
		$('#name-song').html(name);
		$('#name-singer').html(singer);
		$('#youtube-player').attr('src', 'https://www.youtube.com/embed/'+id+'?autoplay=1');
		
		$("#point_timeline").val(0);
		$('#set_time').html('00:00');
		timeOut = 0;
		pointOut = 0;
		onPlay();
	}

	$("#point_timeline").change(function() {
  		changeTime();
	});
</script>