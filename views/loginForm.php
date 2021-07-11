<?php if(isset($message)) { ?>
	<div class="alert alert-danger"><?php echo $message ?></div>
<?php } ?>
<h2 class="text-center my-3">Вход</h2>

<div class="row justify-content-center">
	<div class="col-md-3">
		<form action="/login/login" method="POST">
			<input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]/task" ?>">
			<div class="form-group">
				<label>Логин</label>
				<input class="form-control" type="text" name="login" required>
			</div>
			<div class="form-group">
				<label>Пароль</label>
				<input class="form-control" type="password" name="password" required>
			</div>
			<p class="text-center my-3">
				<button class="btn btn-success">Войти</button>
			</p>
		</form>
	</div>
</div>