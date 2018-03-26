define(function(require) {

	var $ = require('jquery');

	$('.cover-hero').resizable({
		handles: 'sw',
		minHeight: '16rem',
		minWidth: '100%',
		maxHeight: '100vh',
		maxWidth: '100%',
		containment: 'document'
	});
})