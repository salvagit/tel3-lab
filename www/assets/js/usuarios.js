var isEdit = false;

// on document ready
$(document).ready(function() {

	$.ajax({
	  url: '/getusuarios',
	  success: function(data) {
	    $('#usuarios-table').dynatable({
	      dataset: {
	        records: data
	      }
	    });
	  },
	  complete: onGetUsuariosComplete
	});

});

function onGetUsuariosComplete() {

	$('.edit').on('click', function(e){
		isEdit = true;
		var id = '';
		if( "SPAN" === $(e.target).prop("tagName")) {
			id = $(e.target).parent().attr('id');
		} else {
			id = $(e.target).attr('id');
		}
		console.log(id);
		$('#usuariosForm').modal();
	});

	$('#save_user').on('click', function(e){
		console.log($(e.target).prop("tagName"));
		$('#formSaveUser').trigger('submit');
	});

	$('#formSaveUser').on('submit', function(e){
		e.preventDefault();
		console.log(this);
		console.log(isEdit);
	});

}