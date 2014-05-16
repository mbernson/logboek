$(function() {
	$('.btn-group button').on('click', function(event) {
		var button = $(event.target),
		    otherButton = button.siblings(),
		    buttonGroup = button.parent();

		var tr = buttonGroup.parent().parent(),
	            id = tr.data('id');

		function toggleSelection(button) {
			var klass = button.data('default-class');
			if(button.hasClass(klass))
				button.removeClass(klass);
			else
				button.addClass(klass);
		}

		// TODO: Refactor me
		function toggleRow(row) {
			var status = row.data('status');
			row.data('status', status == 'completed' ? 'pending' : 'completed');

			row.removeClass('success danger');
			if(status == 'completed')
				row.addClass('danger');
			else
				row.addClass('success');
		}

		$.ajax({
			type: 'POST',
			url: '/tasks/'+id+'/toggle',
			success: function() {
				toggleSelection(button);
				toggleSelection(otherButton);
				toggleRow(tr);
			}
		});
	});
});
