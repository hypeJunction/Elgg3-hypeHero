<?php

return [
	'actions' => [
		'cover/upload' => [
			'controller' => \hypeJunction\Hero\CoverUploadAction::class,
		],
	],
	'routes' => [
		'cover:upload' => [
			'path' => '/cover/upload/{guid}',
			'resource' => 'hero/cover/upload',
		],
	],
];
