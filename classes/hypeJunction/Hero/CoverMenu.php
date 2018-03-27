<?php

namespace hypeJunction\Hero;

use Elgg\Hook;

class CoverMenu {

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

		if ($entity->canEdit()) {
			$menu[] = \ElggMenuItem::factory([
				'name' => 'edit',
				'href' => '#',
				'text' => '',
				'title' => elgg_echo('hero:cover:edit'),
				'icon' => 'pencil',
				'child_menu' => [
					'display' => 'dropdown',
					'class' => 'elgg-menu-hover',
					'data-position' => json_encode([
						'at' => 'right bottom',
						'my' => 'right top+8px',
						'collision' => 'fit fit',
					]),
					'id' => 'cover-edit-menu',
				],
			]);

			$menu[] = \ElggMenuItem::factory([
				'name' => 'cover',
				'href' => '#',
				'text' => '',
				'title' => elgg_echo('hero:cover:edit'),
				'icon' => 'camera',
				'child_menu' => [
					'display' => 'dropdown',
					'class' => 'elgg-menu-hover',
					'data-position' => json_encode([
						'at' => 'right bottom',
						'my' => 'right top+8px',
						'collision' => 'fit fit',
					]),
					'id' => 'cover-edit-menu',
				],
			]);

			$menu[] = \ElggMenuItem::factory([
				'name' => 'cover:upload',
				'parent_name' => 'cover',
				'text' => elgg_echo('hero:cover:upload'),
				'icon' => 'upload',
				'href' => elgg_generate_url('cover:upload', [
					'guid' => $entity->guid,
				]),
				'class' => 'elgg-lightbox',
				'data-colorbox-opts' => json_encode([
					'width' => '600px',
					'className' => 'hero-cover-lightbox',
				])
			]);

			if ($entity instanceof \ElggUser) {
				$menu[] = \ElggMenuItem::factory([
					'name' => 'profile:edit',
					'parent_name' => 'edit',
					'text' => elgg_echo('profile:edit'),
					'icon' => 'pencil',
					'href' => elgg_generate_url('edit:user', [
						'username' => $entity->username,
					]),
				]);

				$menu[] = \ElggMenuItem::factory([
					'name' => 'avatar:edit',
					'parent_name' => 'edit',
					'text' => elgg_echo('avatar:edit'),
					'icon' => 'user-circle',
					'href' => elgg_generate_url('edit:user:avatar', [
						'username' => $entity->username,
					]),
				]);

				$user_hover = elgg()->menus->getMenu('user_hover', [
					'entity' => $entity,
					'username' => $entity->username,
				]);

				$admin = $user_hover->getSection('admin', []);

				foreach ($admin as $item) {
					$item->setSection('default');
					$item->setParentName('edit');

					$menu[] = $item;
				}
			} else if ($entity instanceof \ElggGroup) {
				$menu[] = \ElggMenuItem::factory([
					'name' => 'groups:edit',
					'parent_name' => 'edit',
					'href' => elgg_generate_entity_url($entity, 'edit'),
					'text' => elgg_echo('groups:edit'),
					'icon' => 'pencil',
				]);
			}
		}

		$entity_menu = elgg()->menus->getUnpreparedMenu('entity', [
			'entity' => $entity,
		]);

		$entity_menu_items = $entity_menu->getItems();

		if (!empty($entity_menu_items)) {

			$parent = $entity->canEdit() ? 'edit' : 'entity';

			foreach ($entity_menu_items as $item) {
				$item->setParentName($parent);
				$menu[] = $item;
			}

			if ($parent === 'entity') {
				$menu[] = \ElggMenuItem::factory([
					'name' => 'entity',
					'href' => '#',
					'text' => '',
					'icon' => 'hand-pointer-o',
					'child_menu' => [
						'display' => 'dropdown',
						'class' => 'elgg-menu-hover',
						'data-position' => json_encode([
							'at' => 'right bottom',
							'my' => 'right top+8px',
							'collision' => 'fit fit',
						]),
						'id' => 'hero-entity-menu',
					],
				]);
			}

		}

		return $menu;

	}
}