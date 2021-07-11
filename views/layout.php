<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Система задач</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/datatable.css">
	<link rel="stylesheet" type="text/css" href="/css/fa.css">
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">ЗАДАЧИ</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	      	<li class="nav-item">
	          <a class="nav-link" href="/">Главная</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="/task">Задачи</a>
	        </li>
			<?php if ($_SESSION['admin'] === 1) {?>
				<li class="nav-item">
				 <form action="/login/logout" method="POST">
					  <input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]/task" ?>">
			          <button class="nav-link logout">Выход</button>
				 </form>
		        </li>
	    	<?php }else{ ?>  
	    	<li class="nav-item">
	          <a class="nav-link" href="/login">Вход</a>
	        </li>  
	    	<?php } ?>    
	      </ul>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<?php include $contentView; ?>
	</div>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/datatable.js"></script>

</body>
</html>