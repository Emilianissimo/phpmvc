<?php if(isset($message)) { ?>
	<div class="alert alert-success"><?php echo $message ?></div>
<?php } ?>
<?php if(isset($messageEdit)) { ?>
	<div class="alert alert-warning"><?php echo $messageEdit ?></div>
<?php } ?>
<?php if(isset($messageDelete)) { ?>
	<div class="alert alert-danger"><?php echo $messageDelete ?></div>
<?php } ?>
<?php if(isset($messageChange)) { ?>
	<div class="alert alert-primary"><?php echo $messageChange ?></div>
<?php } ?>
<div class="row">
	<div class="col-md-6 my-3">
		<h2>Задачи</h2>
	</div>
	<div class="col-md-6 my-3 text-right">
		<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#storeModal">
		  Добавить
		</button>
	</div>
	<div class="col-md-12">
		<form action="/task/order" method="GET">
			<label>Сортировать по: </label>
			<select name="option" class="selectSubmit">
				<option value="0">---</option>
				<option value="name">
					Имени
				</option>
				<option value="email">
					Email
				</option>
				<option value="status">
					Статусу
				</option>
			</select>
		</form>
		<table id="tasksTable" class="table table-bordered table-striped">
			<thead>
				<th>ID</th>
				<th>Имя пользователя</th>
				<th>Email</th>
				<th>Задача</th>
				<th>Статус</th>
				<?php if ($_SESSION['admin'] === 1) {?>
				<th>Действия</th>
				<?php } ?>
			</thead>
			<tbody>
				<?php foreach($tasks as $task){ ?>
					<tr>
						<td><?php echo $task->id ?></td>
						<td><?php echo htmlspecialchars($task->name, ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($task->email, ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($task->text, ENT_QUOTES, 'UTF-8'); ?></td>
						<td>
							<?php if ($_SESSION['admin'] === 1) {?>
							<form action="/task/changestatus" method="POST">
								<input type="hidden" name="id" value="<?php echo $task->id ?>">
					      	  	<input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
								<input type="hidden" name="login" value="<?php echo "http://$_SERVER[HTTP_HOST]/login" ?>">
					      	  	<select name="status"  class="selectSubmit">
					      	  		<option value="0" <?php if ($task->status == 0) { ?> selected <?php } ?>>Не выполнено</option>
					      	  		<option value="1" <?php if ($task->status == 1) { ?> selected <?php } ?>>Выполнено</option>
					      	  	</select>
							</form>
							<?php }else{ 
								if ($task->status == 1) { ?>
							<span class="text-success">Выполнено</span>
							<?php }else{ ?>
							<span class="text-danger">Не выполнено</span>
							<?php }} ?>
						</td>
						<?php if ($_SESSION['admin'] === 1) {?>
						<td class="text-center">
							<button type="button" class="btn btn-warning edit">Изменить</button>
							<form action="task/destroy" method="POST" class="mt-2">
								<input type="hidden" name="id" value="<?php echo $task->id ?>">
					      	  	<input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
								<input type="hidden" name="login" value="<?php echo "http://$_SERVER[HTTP_HOST]/login" ?>">
								<button onclick="return confirm('Вы уверены, что хотите удалить задачу?')" class="btn btn-danger">Удалить</button>
							</form>
						</td>
					<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Store modal -->
<!-- Modal -->
<div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Создать задачу</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/task/store" method="POST">
      	  <div class="modal-body">
      	  	<input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
      	  	<div class="form-group">
      	  		<label>Имя</label>
      	  		<input class="form-control" type="text" name="name" required>
      	  	</div>
      	  	<div class="form-group">
      	  		<label>Email</label>
      	  		<input class="form-control" type="email" name="email" required>
      	  	</div>
  	  		<div class="form-group">
      	  		<label>Текст</label>
      	  		<textarea class="form-control" name="text"></textarea>
      	  	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
	        <button class="btn btn-success">Сохранить</button>
	      </div>
      </form>
    </div>
  </div>
</div>
<?php if ($_SESSION['admin'] === 1) {?>
<!-- Modal Update -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Изменение задачи</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" action="/task/update" method="POST">
      <div class="modal-body">
		<input type="hidden" name="login" value="<?php echo "http://$_SERVER[HTTP_HOST]/login" ?>">
        <input type="hidden" name="location" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
        <input type="hidden" name="id" id="id">
  	  	<div class="form-group">
  	  		<label>Имя</label>
  	  		<input class="form-control" type="text" name="name" required id="name">
  	  	</div>
  	  	<div class="form-group">
  	  		<label>Email</label>
  	  		<input class="form-control" type="email" name="email" required id="email">
  	  	</div>
	  		<div class="form-group">
  	  		<label>Текст</label>
  	  		<textarea class="form-control" name="text" id="text"></textarea>
  	  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-warning">Изменить</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
  $('.selectSubmit').on('change', function(){
  	this.form.submit();
  })
  $(document).ready(function(){
    var table = $('#tasksTable').DataTable({
    	  "paging": false,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": false,
	      "info": false,
	      "autoWidth": false,
	      "responsive": true,
    });

    table.on('click', '.edit', function(){
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')){
        $tr = $tr.prev('.parent')
      }

      var data = table.row($tr).data()
      
      $('#id').val(data[0])
      $('#name').val(data[1])
      $('#email').val(data[2])
      $('#text').val(data[3])

      $('#editModal').modal('show')
    })
  })
</script>
