<?php

namespace hypeJunction\Hero;

use Elgg\Hook;

class HeroMenu {

	/**
	 * Setup hero menu
	 *
	 * @elgg_plugin_hook register menu:hero
	 *
	 * @param Hook $hook Hook
	 *
	 * @return void
	 */
	public function __invoke(Hook $hook) {

		$menu = $hook->getValue();

		$get_first_segment = function($url) {
			$site_url = elgg_get_site_url();

			if (strpos($url, $site_url) !== 0) {
				return false;
			}

			$path = substr($url, strlen($site_url));
			$path = parse_url($path, PHP_URL_PATH);

			$segments = explode('/', $path);

			$segment =  array_shift($segments);
			if ($segment == 'groups') {
				$segment = array_shift($segments);
			}

			return $segment;
		};

		$selected_segment = $get_first_segment(current_page_url());

		foreach ($menu as $item) {
			/* @var $item \ElggMenuItem */
			$url = elgg_normalize_url($item->getHref());

			$item_segment = $get_first_segment($url);

			if ($item_segment && $item_segment == $selected_segment) {
				$item->setSelected(true);
			}
		}

		$entity = $hook->getEntityParam();
		if ($entity instanceof \ElggUser || $entity instanceof \ElggGroup) {
			$menu[] = \ElggMenuItem::factory([
				'name' => 'profile',
				'priority' => 50,
				'text' => elgg_echo('profile'),
				'href' => $entity->getURL(),
			]);
		}

		return $menu;
	}
}