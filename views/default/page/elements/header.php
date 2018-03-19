<?php

$header = elgg_extract('header', $vars);
if ($header === false) {
	return;
}

if (isset($header)) {
	return;
}

$entity = elgg_extract('entity', $vars, elgg_get_page_owner_entity());

if (!$entity) {
	return;
}

$views = [
	"page/elements/hero/$entity->type/$entity->subtype",
	"page/elements/hero/$entity->type",
	"page/elements/hero",
];

foreach ($views as $view) {
	if (elgg_view_exists($view)) {
		echo elgg_view($view, [
			'entity' => $entity,
		]);
		return;
	}
}