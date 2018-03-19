<?php

namespace hypeJunction\Hero;

use Elgg\Hook;

class DefineCoverSizes {

	/**
	 * @elgg_plugin_hook entity:cover:sizes all
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array|null
	 */
	public function __invoke(Hook $hook) {

		$value = $hook->getValue();

		$hero = [
			'w' => 2000,
			'h' => 400,
			'square' => false,
			'upscale' => true,
		];

		if (!empty($value)) {
			$value['hero'] = $hero;
			return $value;
		}

		return [
			'original' => [],
			'hero' => $hero,
			'master' => [
				'w' => 1280,
				'h' => 720,
				'square' => false,
				'upscale' => true,
			],
			'large' => [
				'w' => 800,
				'h' => 450,
				'square' => false,
				'upscale' => false,
			],
			'medium' => [
				'w' => 480,
				'h' => 270,
				'square' => false,
				'upscale' => false,
			],
			'small' => [
				'w' => 240,
				'h' => 135,
				'square' => false,
				'upscale' => false,
			],
		];
	}
}
