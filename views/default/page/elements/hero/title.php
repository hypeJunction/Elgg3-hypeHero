<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggEntity) {
	return;
}

echo elgg_view('output/url', [
	'href' => $entity->getURL(),
	'text' => $entity->getDisplayName(),
]);
