var isEdit = false;
var id = '';
// on document ready
$(document).ready(function() {

	var dynatable = $('#usuarios-table');
	
	dynatable.bind('dynatable:afterUpdate', function(e, dynatable){
		// hookActions();
		console.log("Fired") ;
	});

	$.ajax({
	  url: '/getusuarios',
	  success: function(data) {
	    dynatable.dynatable({
	      dataset: {
	        records: data
	      }
	    }).data('dynatable');
	  },
	  complete: onGetUsuariosComplete
	});

});

function onGetUsuariosComplete() {
	hookActions();
}

function hookActions() {
	$('.edit').on('click', function(e) {
		// editAction(e);
	});

	$('.delete').on('click', function(e) {
		deleteAction(e);
	});

	$('#save_user').on('click', function(e){
		console.log($(e.target).prop("tagName"));
		$('#formSaveUser').trigger('submit');
	});

	/**
	 * Post
	 */
	$('#formSaveUser').on('submit', function(e){
		saveAction(e)
	});

	// create user
	$('#createUser').on('click', function(e){
		e.preventDefault();
		$('#usuariosForm').modal();

		$('#usuariosForm').on('shown.bs.modal', function(e) {
			$.ajax({
			  url: '/get-perfiles',
			  success: function(data) {
			  	$('#perfil_id').html('');
			  	$.each(data, function() {
			    	$('#perfil_id').append('<option value="'+this.id+'" >'+this.name+'</option>');
			  	})
			  },
			  error: function(resp){
			  	console.error(resp)
			  }
			});
		});
	});
}

function saveAction (e) {
	e.preventDefault();
	console.log(this);
	console.log(isEdit);

	var $form = $(this);
	var $name = $form.find('#user_name');
	var $mail = $form.find('#user_email');
	var $perfil_id = $form.find('#perfil_id');

	if(!isEdit){
		$.ajax({
			url: '/usuario',
			method:'post',
			data: {
				name: $name.val(),
				mail: $mail.val(),
				perfil_id: $perfil_id.val()
			},
			success: function(response){
				console.log(response);
				$('button.close').trigger('click');
			}
		});
	}
}

function editAction(e) {
	isEdit = true;
	// var id = '';
	if( "SPAN" === $(e.target).prop("tagName")) {
		id = $(e.target).parent().attr('id');
	} else {
		id = $(e.target).attr('id');
	}
	// disparamos el modal.
	$('#usuariosForm').modal();
/*
	// nos hookeamos al evento shown.bs.modal del modal.
	$('#usuariosForm').on('shown.bs.modal', function(e) {

		var $modal = $(this);

		var $name = $modal.find('#user_name');
		var $mail = $modal.find('#user_email');
		var $save_user = $modal.find('#save_user');

		$.ajax({
			url: '/getusuario/'+id,
			success: function(response){
				// console.log(response);
				$name.val(response[0].name);
				$mail.val(response[0].mail);
			}
		});
		
		// update
		$save_user.on('click', function() {	
			$.ajax({
				url: '/usuario/'+id,
				method:'put',
				data: {
					name: $name.val(),
					mail: $mail.val()
				},
				success: function(response){
					console.log(response);
					$('button.close').trigger('click');
					// dynatable.process();
				}
			});
		});
	});
*/
}

function deleteAction(e) {
	if( "SPAN" === $(e.target).prop("tagName")) {
		id = $(e.target).parent().attr('id');
	} else {
		id = $(e.target).attr('id');
	}

	if (confirm('desea borrar el user ?')) {
		/**
		 * delete
		 */
		$.ajax({
			url: '/usuario/'+id,
			method:'delete',
			success: function(response){
				console.log(response);
			}
		});
	}

}