<?php

namespace hypeJunction\Hero;

use Elgg\Event;

class DefineCoverSizes {

	/**
	 * @elgg_plugin_hook entity:cover:sizes all
	 *
	 * @param Event $event Event
	 *
	 * @return array|null
	 */
	public function __invoke(Event $event) {

		$value = $event->getValue();

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
