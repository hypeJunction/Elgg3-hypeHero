<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

elgg_push_entity_breadcrumbs($entity);

$title = elgg_echo('hero:cover:pick');

elgg_push_breadcrumb($title);

$content = elgg_view_form('cover/pick', [
	'enctype' => 'multipart/form-data',
], [
	'entity' => $entity,
]);

if (elgg_is_xhr()) {
	elgg_require_js('forms/cover/lightbox');
	echo $content;
	return;
}

$layout = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'filter_id' => 'cover',
]);

echo elgg_view_page($title, $layout);