<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

echo elgg_view_field([
	'#type' => 'file',
	'#label' => elgg_echo('hero:cover:file'),
	'required' => true,
	'name' => 'cover',
	'value' => $entity->hasIcon('original', 'cover'),
]);

echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('hero:cover:attribution'),
	'fields' => [
		[
			'#type' => 'url',
			'#label' => elgg_echo('hero:cover:file_url'),
			'name' => 'file_url',
			//'value' => $entity->{'cover:file_url'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:author'),
			'name' => 'author',
			//'value' => $entity->{'cover:author'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:author_url'),
			'name' => 'author',
			//'value' => $entity->{'cover:author_url'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:provider'),
			'name' => 'provider',
			//'value' => $entity->{'cover:provider'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:provider_url'),
			'name' => 'provider',
			//'value' => $entity->{'cover:provider_url'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:license'),
			'name' => 'license',
			//'value' => $entity->{'cover:license'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:copyright'),
			'name' => 'copyright',
			//'value' => $entity->{'cover:copyright'},
		],
		[
			'#type' => 'text',
			'#label' => elgg_echo('hero:cover:disclaimer'),
			'name' => 'disclaimer',
			//'value' => $entity->{'cover:disclaimer'},
		],
	],
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('upload'),
]);

elgg_set_form_footer($footer);