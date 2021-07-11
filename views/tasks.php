
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
		<table id="tasksTable" class="table table-bordered table-striped">
			<thead>
				<th>ID</th>
				<th>Имя пользователя</th>
				<th>Email</th>
				<th>Задача</th>
				<th>Статус</th>
				<th>Действия</th>
			</thead>
			<tbody>
				<?php foreach($tasks as $task){ ?>
					<tr>
						<td><?php echo $task->id ?></td>
						<td><?php echo $task->name; ?></td>
						<td><?php echo $task->email; ?></td>
						<td><?php echo $task->text; ?></td>
						<td>
							<?php if ($task->status == 1) { ?>
							<span class="text-success">Выполнено</span>
							<?php }else{ ?>
							<span class="text-danger">Не выполнено</span>
							<?php } ?>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-warning edit">Изменить</button>
							<form action="task/destroy" method="POST" class="mt-2">
								<input type="hidden" name="id" value="<?php echo $task->id ?>">
								<button class="btn btn-danger">Удалить</button>
							</form>
						</td>
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
<!-- Modal Update -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Изменение задачи</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST">
      <div class="modal-body">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-warning">Изменить</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#tasksTable').DataTable();

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

      $('#editForm').attr('action', '/tasks/update/')
      $('#editModal').modal('show')
    })
  })
</script>
