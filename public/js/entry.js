$(function() {

	$('.btn-danger').on('click', function(event) {
		if(!confirm('Weet je zeker dat je dit wilt verwijderen?')) {
			event.preventDefault();
		}
	});

});
