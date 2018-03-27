<?php

require_once __DIR__ . '/autoloader.php';

return function () {

	elgg_register_event_handler('init', 'system', function () {

		elgg_extend_view('elgg.css', 'page/elements/hero.css');

		elgg_register_plugin_hook_handler('entity:cover:sizes', 'all', \hypeJunction\Hero\DefineCoverSizes::class);

		elgg_register_plugin_hook_handler('register', 'menu:hero', \hypeJunction\Hero\HeroMenu::class, 900);
		elgg_register_plugin_hook_handler('register', 'menu:cover', \hypeJunction\Hero\CoverMenu::class, 900);
		elgg_register_plugin_hook_handler('register', 'menu:actions', \hypeJunction\Hero\ActionsMenu::class, 900);

		elgg_unregister_plugin_hook_handler('register', 'menu:title', '_groups_title_menu');
		elgg_register_plugin_hook_handler('register', 'menu:actions', '_groups_title_menu', 400);

		elgg_unregister_plugin_hook_handler('register', 'menu:title', '_profile_title_menu');
		elgg_unregister_plugin_hook_handler('register', 'menu:title', '_elgg_user_title_menu');
	});
};
