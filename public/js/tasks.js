$(function() {
	$('.btn-group button').on('click', function(event) {
		var button = $(event.target),
		    buttonGroup = button.parent();

		var id = buttonGroup.parent().parent().data('id');

		function toggleSelection() {
			var newClass = button.hasClass('btn-danger') ? 'btn-success' : 'btn-danger';
			console.log(button, newClass);
			button.removeClass('btn-success btn-danger');
			button.siblings().addClass(newClass);
		}

		$.ajax({
			type: 'POST',
			url: '/tasks/'+id+'/toggle',
			success: toggleSelection
		});
	});
});
