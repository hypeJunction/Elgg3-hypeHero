<?php

return [
	'actions' => [
		'cover/upload' => [
			'controller' => \hypeJunction\Hero\CoverUploadAction::class,
		],
		'cover/pick' => [
			'controller' => \hypeJunction\Hero\CoverPickAction::class,
		],
	],
	'routes' => [
		'cover:upload' => [
			'path' => '/cover/upload/{guid}',
			'resource' => 'hero/cover/upload',
		],
		'cover:pick' => [
			'path' => '/cover/pick/{guid}',
			'resource' => 'hero/cover/pick',
		],
	],
];
