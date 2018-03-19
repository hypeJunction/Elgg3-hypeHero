<?php

$entity = elgg_extract('entity', $vars);

if ($entity instanceof ElggGroup || $entity instanceof ElggObject) {
	echo elgg_view('object/elements/imprint', $vars);
} else {
	$subtitle = '';
	$location = $entity->location;
	if (is_string($location) && $location !== '') {
		$location = elgg_view_icon('map-marker') . ' ' . $location;
		$subtitle .= elgg_format_element('div', [], $location);
	}

	$subtitle .= elgg_format_element('div', [], $entity->briefdescription);

	echo $subtitle;
}