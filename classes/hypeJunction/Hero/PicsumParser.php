<?php

namespace hypeJunction\Hero;

/**
 * Parser a list of images from https://picsum.photos/
 */
class PicsumParser {

	/**
	 * Returns a list of picsum photos
	 * @return array
	 */
	public function parse() {
		$json = file_get_contents('https://picsum.photos/list');

		$images = json_decode($json);

		$config = [];

		foreach ($images as $image) {
			$config[] = [
				'uid' => "picsum:$image->id",
				'file_url' => "https://picsum.photos/{width}/{height}?image={$image->id}",
				'author' => $image->author,
				'author_url' => $image->author_url,
				'provider' => 'Unsplash',
				'provider_url' => $image->post_url,
				'copyright' => '',
				'license' => 'Unsplash License',
				'disclaimer' => '',
				'width' => $image->width,
				'height' => $image->height,
				'gravity' => 'center',
			];
		}

		return $config;
	}

	/**
	 * Save config a file
	 *
	 * @param array $config Config
	 * @return void
	 */
	public function save($filename, array $config) {
		file_put_contents($filename, json_encode($config), LOCK_EX);
	}

}