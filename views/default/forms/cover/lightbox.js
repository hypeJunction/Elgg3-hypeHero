import $ from 'jquery';
import Ajax from 'elgg/Ajax';
import lightbox from 'elgg/lightbox';

$(document).on('submit', '.elgg-form-cover-upload,.elgg-form-cover-pick', function(e) {
	e.preventDefault();

	var ajax = new Ajax();
	var $form = $(this);

	ajax.action($form.attr('action'), {
		data: ajax.objectify($form),
		beforeSend: function() {
			$form.find('[type="submit"]').prop('disabled', true);
		}
	}).done(function(data) {
		$('.cover-hero .cover-image').css({
			'background-image': 'url(' + data.cover_url + ')'
		});
		$('.cover-hero .cover-attribution').remove();
		lightbox.close();
	}).fail(function() {
		$form.find('[type="submit"]').prop('disabled', false);
	});
});
