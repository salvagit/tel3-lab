
var isEdit = false;
var id = '';
var firstLoad = true;

// on document ready
$(document).ready(function() {

	var dynatable = $('#usuarios-table');
	
	// bind dynatable event
	dynatable.bind('dynatable:afterUpdate', function(e, dynatable){
		hookActions();
	});

	// fill Table
	$.ajax({
	  url: '/getusuarios', // Call getusuarios service on services/controllers/usuarios.php
		success: function(data) {
			dynatable.dynatable({
				dataset: {
					records: data
				}
			}).data('dynatable');
		},
		complete: function() {
			hookActions();
		}
	});

	// on create user button click
	$('#createUser').on('click', function(e) {
		e.preventDefault();
		isEdit = false;
		$('#usuariosForm').modal();
	});

/**
 * Modal Events
 */
	// after show modal
	$('#usuariosForm').on('shown.bs.modal', function() {
		onshownBsModal(this);
	});
	// on save user button click.
	$('#save_user').on('click', function(e) {
		$('#formSaveUser').trigger('submit');
	});
	// on user form submit.
	$('#formSaveUser').on('submit', function(e) {
		e.preventDefault();
		onSubmit(this);
	});

});

/**
 * [hookActions description]
 * @return {[type]} [description]
 */
function hookActions() {

	$('.edit').on('click', function(e) {
		editAction(e);
	});

	$('.delete').on('click', function(e) {
		deleteAction(e);
	});

}

/**
 * [ON AFTER SHOWN MODAL]
 * @return {[type]} [description]
 */
function onshownBsModal(modal) {
	// get DOM objects
	var $modal = $(modal),
		$form = $modal.find('#formSaveUser'),
		$name = $form.find('#user_name'),
		$mail = $form.find('#user_email');
		$perfil = $form.find('#perfil_id');

	// reset form.
	$form.trigger("reset");

	// firs time only.
	if (firstLoad) {
		// get perfiles dropdown 
		$.ajax({
			url: '/get-perfiles',
			success: function(data) {
				$.each(data, function() {
					$('#perfil_id').append('<option value="'+this.id+'" >'+this.name+'</option>');
				})
			},
			error: function(resp) {
				console.error(resp)
			}
		});
		firstLoad = false;
	}

	// Edit User ?
	if (isEdit) {
		$.ajax({
			url: '/getusuario/'+id,
			success: function(response) {
				console.log(response);
				$name.val(response[0].name);
				$mail.val(response[0].mail);
				$perfil.val(response[0].perfil);
				/* 
				// set select option
				$perfil.filter(function() {
console.log($(this).text());
				    //may want to use $.trim in here
				    return $(this).text() == response[0].perfiles; 
				}).prop('selected', true);
				*/
			}
		});
	}
}

function onSubmit (form) {
	var $form = $(form);
	var $name = $form.find('#user_name');
	var $mail = $form.find('#user_email');
	var $perfil_id = $form.find('#perfil_id');

	var url = '/usuario';

	if (isEdit) {
		url += '/' + id;
	}

	$.ajax({
		url: url,
		method: (isEdit) ? 'put' : 'post',
		data: {
			name: $name.val(),
			mail: $mail.val(),
			perfil_id: $perfil_id.val()
		},
		success: function(response){
			$('button.close').trigger('click');
		},
		error: function (resp) {
			console.error(resp);
		}
	});
}

function editAction(e) {
	isEdit = true;
	// get id
	id = getId(e);
	// disparamos el modal.
	$('#usuariosForm').modal();
}

function deleteAction(e) {
	// get id
	id = getId(e);

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

function getId (e) {
	if( "SPAN" === $(e.target).prop("tagName")) {
		return $(e.target).parent().attr('id');
	} else {
		return $(e.target).attr('id');
	}
}