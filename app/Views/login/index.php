<?php echo loadHeader(); ?>
<body>
	<div class="m-container-login">
		<div class="sc-box-bg"></div>
		<div class="sc-box-bg"></div>
		<div class="sc-box-bg"></div>
		<div class="sc-container-form">
			<div class="sc-title-form">
				<span>Login</span>
			</div>
			<div class="sc-text-form">
				<span>Username</span>
			</div>
			<div class="sc-content-input">
				<i class="fa-solid fa-user"></i>
				<input id="username" type="text" name="" class="sc-login-input" placeholder="Username">
			</div>
			<div class="sc-text-form">
				<span>Password</span>
			</div>
			<div class="sc-content-input">
				<i class="fa-solid fa-lock"></i>
				<input id="password" type="password" name="" class="sc-login-input" placeholder="Password">
			</div>
			<div class="sc-forgot-password">
				<span>Forgot password?</span>
			</div>
			<div class="sc-btn-login" onclick="onLogin(); return false;">
				<span>Login</span>
			</div>
			<div class="sc-login-more">
				<span>Or Sign Up Using</span>
			</div>
			<div class="sc-box-brands">
				<div class="sc-icon-brands">
					<i class="fa-brands fa-facebook-f"></i>
				</div>
				<div class="sc-icon-brands">
					<i class="fa-brands fa-google"></i>
				</div>
			</div>
			<div class="sc-login-more">
				<span>Or Sign Up Using</span>
			</div>
			<div class="sc-sign-up">
				<span>SIGN UP >>></span>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	$("#password, #username").on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	        onLogin();
	    }
	});
	function onLogin() {
		$.ajax({
		  	method: "POST",
		  	url: "<?=base_url()?>" + "/login/check-login",
		  	data: { user: $('#username').val(), pw: $('#password').val() }
		}).done(function(msg) {
			msg = JSON.parse(msg);
		    if(msg.message == 'fail') {
		    	Swal.fire({
				  	icon: 'error',
				  	title: 'Oops...',
				  	text: 'Sai tài khoản/mật khẩu, vui lòng kiểm tra lại!'
				})
		    } else {
		    	window.location.href = "<?=base_url()?>";
		    }
		});
	}
</script>
<?php echo loadFooter(); ?>