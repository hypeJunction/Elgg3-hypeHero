<?php

namespace hypeJunction\Hero;

use Elgg\Hook;

class ActionsMenu {

	/**
	 * Setup cover edit menu
	 *
	 * @elgg_plugin_hook register menu:cover
	 *
	 * @param Hook $hook Hook
	 *
	 * @return \ElggMenuItem[]
	 */
	public function __invoke(Hook $hook) {

		$menu = $hook->getValue();
		$entity = $hook->getEntityParam();

		if (!$entity) {
			return;
		}

		if ($entity instanceof \ElggUser) {
			$user_hover = elgg()->menus->getMenu('user_hover', [
				'entity' => $entity,
				'username' => $entity->username,
			]);

			$admin = $user_hover->getSection('action', []);

			foreach ($admin as $item) {
				if (in_array($item->getName(), ['wall'])) {
					continue;
				}

				$item->setLinkClass('elgg-button elgg-button-action');

				$menu[] = $item;
			}
		}

		$remove = ['groups:edit', 'avatar:edit', 'profile:edit'];
		foreach ($menu as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($menu[$key]);
				continue;
			}
		}

		return $menu;
	}
}