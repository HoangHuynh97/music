<?php echo loadHeader(); ?>
<body>
	<?php echo loadMenu(); ?>
	<?php echo loadTop(); ?>
	<?php echo loadBot(); ?>
	<div class="mm-container">
		<div class="mm-slide">
			<div class="mm-move-left" onclick="load_slide('prev'); return false;">
				<i class="fa-solid fa-chevron-left"></i>
			</div>
			<div class="c-box-slide">
				<div class="sc-banner-slide">
					<img src="public/assets/images/banner-template.jpg" alt="">
				</div>
				<div class="sc-banner-slide">
					<img src="public/assets/images/banner-template2.jpg" alt="">
				</div>
				<div class="sc-banner-slide">
					<img src="public/assets/images/banner-template3.jpg" alt="">
				</div>
				<div class="sc-banner-slide">
					<img src="public/assets/images/banner-template4.jpg" alt="">
				</div>
				<div class="sc-banner-slide">
					<img src="public/assets/images/banner-template5.jpg" alt="">
				</div>
			</div>
			<div class="mm-move-right" onclick="load_slide('next'); return false;">
				<i class="fa-solid fa-chevron-right"></i>
			</div>
		</div>
		<div class="mm-new-song block">
			<div class="mm-title-list">
				<h4>Mới Phát Hành</h4>
			</div>
			<div class="mm-block block inblock">
				<div class="mm-category-block inblock">
					<div class="mm-button-category">
						<h4>TẤT CẢ</h4>
					</div>
					<div class="mm-button-category">
						<h4>VIỆT NAM</h4>
					</div>
					<div class="mm-button-category">
						<h4>QUỐC TẾ</h4>
					</div>
				</div>
				<div class="mm-see-all">
					<h4>TẤT CẢ</h4><i class="fa-solid fa-chevron-right"></i>
				</div>
			</div>
			<div class="mm-container-box-song">
				<?php foreach ($dataResult as $key => $value) { ?>
				<div class="sc-container-box-song" onclick="change('<?=$value->id_youtube?>', '<?=$value->image?>', '<?=$value->name?>', '<?=$value->id_singer?>'); return false;">
					<div class="sc-c-img">
						<img src="<?=$value->image?>" alt="">
						<div class="sc-c-img-bg hidden">
							<img src="public/assets/images/play.png" class="play-icon">
						</div>
					</div>
					<div class="sc-c-des">
						<div class="sc-c-des-name">
							<h5><?=$value->name?></h5>
						</div>
						<div class="sc-c-des-singer">
							<h5><?=$value->id_singer?></h5>
						</div>
						<div class="sc-c-des-date">
							<h5><?=$value->date_create?></h5>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="mm-list-random">
			<div class="sc-container-box-list inblock w100">
				<div class="mm-title-list left">
					<h4>Playlist Thịnh Hành</h4>
				</div>
				<div class="mm-see-all">
					<h4>TẤT CẢ</h4><i class="fa-solid fa-chevron-right"></i>
				</div>
			</div>
			<div class="sc-container-box-list-song">
				<?php foreach ($dataResult2 as $key => $value) { ?>
				<div class="sc-box-list">
					<div class="sc-container-img-list">
						<img src="<?=$value->image?>" class="c-img-list" alt="">
						<div class="c-container-img">
							<div class="c-content-img">
								<div class="c-box-icon">
									<i class="far fa-heart"></i>
								</div>
								<div class="c-icon-play" onclick="change('<?=$value->id_youtube?>', '<?=$value->image?>', '<?=$value->name?>', '<?=$value->id_singer?>'); return false;">
									<i class="fas fa-play"></i>
								</div>
								<div class="c-box-icon">
									<i class="fas fa-download"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="sc-c-des-name">
						<h5><?=$value->name?></h5>
					</div>
					<div class="sc-c-des-singer">
						<h5>nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung</h5>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="mm-trend">
			<div class="sc-container-box-list inblock w100">
				<div class="mm-title-list left">
					<h4>Bài Hát Thịnh Hành</h4>
				</div>
				<div class="mm-see-all">
					<h4>TẤT CẢ</h4><i class="fa-solid fa-chevron-right"></i>
				</div>
			</div>
			<div class="sc-container-box-list-song">
				<?php foreach ($dataResult3 as $key => $value) { ?>
				<div class="sc-box-list">
					<div class="sc-container-img-list">
						<img src="<?=$value->image?>" class="c-img-list" alt="">
						<div class="c-container-img">
							<div class="c-content-img">
								<div class="c-box-icon">
									<i class="far fa-heart"></i>
								</div>
								<div class="c-icon-play" onclick="change('<?=$value->id_youtube?>', '<?=$value->image?>', '<?=$value->name?>', '<?=$value->id_singer?>'); return false;">
									<i class="fas fa-play"></i>
								</div>
								<div class="c-box-icon">
									<i class="fas fa-download"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="sc-c-des-name">
						<h5><?=$value->name?></h5>
					</div>
					<div class="sc-c-des-singer">
						<h5>nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung</h5>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="mm-singer">
			<div class="sc-container-box-list inblock w100">
				<div class="mm-title-list left">
					<h4>Nghệ sĩ nổi bật</h4>
				</div>
				<div class="mm-see-all">
					<h4>TẤT CẢ</h4><i class="fa-solid fa-chevron-right"></i>
				</div>
			</div>
			<div class="sc-singer-slide">
				<div class="sc-container-box-singer">
					<div class="mm-move-left" onclick="load_slide_singer('prev'); return false;">
						<i class="fa-solid fa-chevron-left"></i>
					</div>
					<div class="c-box-slide-singer">
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/1.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/2.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/3.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/4.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/jack.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/6.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/7.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/8.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/9.png" alt="">
						</div>
						<div class="sc-banner-slide-singer">
							<img src="public/assets/images/10.png" alt="">
						</div>
					</div>
					<div class="mm-move-right" onclick="load_slide_singer('next'); return false;">
						<i class="fa-solid fa-chevron-right"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="mm-category">
			<div class="sc-container-box-list inblock w100">
				<div class="mm-title-list left">
					<h4>Music Video</h4>
				</div>
				<div class="mm-see-all">
					<h4>TẤT CẢ</h4><i class="fa-solid fa-chevron-right"></i>
				</div>
			</div>
			<div class="sc-container-box-list-song">
				<?php foreach ($dataResult4 as $key => $value) { ?>
				<div class="sc-box-list">
					<div class="sc-container-img-list">
						<img src="<?=$value->image?>" class="c-img-list" alt="">
						<div class="c-container-img">
							<div class="c-content-img">
								<div class="c-box-icon">
									<i class="far fa-heart"></i>
								</div>
								<div class="c-icon-play" onclick="change('<?=$value->id_youtube?>', '<?=$value->image?>', '<?=$value->name?>', '<?=$value->id_singer?>'); return false;">
									<i class="fas fa-play"></i>
								</div>
								<div class="c-box-icon">
									<i class="fas fa-download"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="sc-c-des-name">
						<h5><?=$value->name?></h5>
					</div>
					<div class="sc-c-des-singer">
						<h5>nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung nội dung</h5>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		setInterval(() => checkTimeBanner(), 1000);
		setInterval(() => checkTimeSinger(), 1000);
	});	
	
	var timeOutBanner = 5;
	function checkTimeBanner() {
		timeOutBanner--;
		if(timeOutBanner == 0) {
			load_slide("next");
		}
	}

	function load_slide(type) {
		if(type == "next") {
			$('.sc-banner-slide:nth-child(1)').appendTo($(".c-box-slide"));
			timeOutBanner = 5;
		} else if(type == "prev") {
			$('.sc-banner-slide:nth-child(5)').prependTo($(".c-box-slide"));
			timeOutBanner = 5;
		}
	}

	var timeOutSinger = 5;
	function checkTimeSinger() {
		timeOutSinger--;
		if(timeOutSinger == 0) {
			load_slide_singer("next");
		}
	}
	function load_slide_singer(type) {
		if(type == "next") {
			$('.sc-banner-slide-singer:nth-child(1)').appendTo($(".c-box-slide-singer"));
			timeOutSinger = 5;
		} else if(type == "prev") {
			$('.sc-banner-slide-singer:nth-child(10)').prependTo($(".c-box-slide-singer"));
			timeOutSinger = 5;
		}
	}
	
</script>
<?php echo loadFooter(); ?>