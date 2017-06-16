$(document).ready(function () {
	//Confirm Delete
	$(document.body).on('submit', '.js-confirm', function () {
		var $el = $(this)
		var text = $el.data('confirm') ? $el.data('confirm') : 'Anda Yakin Melakukan Tindakan ini ?'
		var c = confirm(text);
		return c;

	});
});