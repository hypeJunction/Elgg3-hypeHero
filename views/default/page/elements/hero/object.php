<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

$container = $entity->getContainerEntity();
while ($container instanceof ElggObject) {
	$container = $container->getContainerEntity();
}

$params = $vars;
$params['entity'] = $container;

echo elgg_view('page/elements/hero', $params);
