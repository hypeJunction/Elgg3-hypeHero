<?php

$entity = elgg_extract('entity', $vars);

if ($entity instanceof ElggObject) {
	if (!$entity->hasIcon('medium')) {
		$entity = $entity->getOwnerEntity();
	}
}

if ($entity instanceof ElggEntity && $entity->hasIcon('medium')) {
	echo elgg_view_entity_icon($entity, 'medium', [
		'use_hover' => false,
		'img_class' => 'cover-owner-icon',
	]);
}