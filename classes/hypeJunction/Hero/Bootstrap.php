<?php

namespace hypeJunction\Hero;

use Elgg\PluginBootstrap;

class Bootstrap extends PluginBootstrap {

	public function load() {
		\Elgg\Includer::requireFileOnce($this->plugin->getPath() . '/autoloader.php');
	}

	public function boot() {
	}

	public function init() {
		\elgg_extend_view('elgg.css', 'page/elements/hero.css');

		\elgg_register_event_handler('entity:cover:sizes', 'all', DefineCoverSizes::class);

		\elgg_register_event_handler('register', 'menu:hero', HeroMenu::class, 900);
		\elgg_register_event_handler('register', 'menu:cover', CoverMenu::class, 900);
		\elgg_register_event_handler('register', 'menu:actions', ActionsMenu::class, 900);

		\elgg_unregister_event_handler('register', 'menu:title', '_groups_title_menu');
		\elgg_register_event_handler('register', 'menu:actions', '_groups_title_menu', 400);

		\elgg_unregister_event_handler('register', 'menu:title', '_profile_title_menu');
		\elgg_unregister_event_handler('register', 'menu:title', '_elgg_user_title_menu');
	}

	public function ready() {
	}

	public function shutdown() {
	}

	public function activate() {
	}

	public function deactivate() {
	}

	public function upgrade() {
	}
}
