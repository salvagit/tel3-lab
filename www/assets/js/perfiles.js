// on document ready
$(document).ready(function() {
/*
	// get perfiles
	$.ajax({
		url: '/perfiles',
		method: 'get',
		success: function(response) {
			$.each(response, function(key, value){
				appendProfile(value.id, value.name);
			});
		},
		error: function (response) {
			console.error(response);
		},
		complete: function () {
			hookActions();
		}
	});

	$('#formPerfiles').on('submit', function(e){
		e.preventDefault();
		var form = $(this).serializeArray();
		var nombre = form[0].value;

		$.ajax({
			url: '/perfiles',
			method: 'post',
			data: {name: nombre},
			success: function(response) {
				appendProfile(response.message, nombre);
			},
			complete: function () {
				hookActions();
			}
		});
	});
});
// end on document ready


function appendProfile (id, name) {
	$('#perfiles')
	.append('<li id="' + id + '"> <a class="editar" href="#">' + name + '</a> <a class="borrar" href="#">[borrar]</a> </li>');
}

function hookActions () {

	$('.editar').on('click', function(e) {

		var el = $(e.target);
		var id = el.parent().attr('id');
		var oldName = $(e.target).html();

		var name = prompt('ingrese un nuevo nombre', oldName);
		$.ajax({
			url: '/perfiles/'+id,
			method: 'put',
			data: {name: name},
			success: function(response) {
				el.html(name);
			}
		});

	});

	$('.borrar').on('click', function(e) {
		var el = $(e.target);
		var id = el.parent().attr('id');
		// get html del elemento hermano
		var name = el.siblings().html();
		if (confirm('confirma borrar ' + name + '?')) {
			$.ajax({
				url: '/perfiles/'+id,
				method: 'delete',
				success: function(response) {
					el.parent()
					.fadeOut('fast', function () {
						$(this).remove();
					});
				}
			});
		}
	});
*/

	$.ajax({
	  url: '/get-perfiles',
	  success: function(data){
	  	// var records = JSON.parse(data);
	    $('#my-ajax-table').dynatable({
	      dataset: {
	        records: data
	      }
	    });
	  }
	});

});