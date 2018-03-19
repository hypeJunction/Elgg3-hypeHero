<?php

namespace hypeJunction\Hero;

class CoverLibrary {

	/**
	 * @var array
	 */
	private $images;

	/**
	 * Get a list of cover images
	 * @return CoverImage[]
	 */
	public function getImages() {

		if (!$this->images) {
			$root = dirname(dirname(dirname(dirname(__FILE__))));
			$file = "$root/images.json";

			$json = file_get_contents($file);
			$images = json_decode($json, true);

			$data = [];

			foreach ($images as $image) {
				$data[] = new CoverImage($image);
			}
			$this->images = $data;
		} else {
			$data = $this->images;
		}

		$data = elgg_trigger_plugin_hook('library', 'cover:images', null, $data);

		return array_filter($data, function ($e) {
			return $e instanceof CoverImage && $e->uid;
		});
	}

	/**
	 * Get cover image from its uid
	 *
	 * @param string $uid UID
	 *
	 * @return CoverImage|false
	 */
	public function getImageFromUid($uid) {
		foreach ($this->getImages() as $image) {
			if ($image->uid === $uid) {
				return $image;
			}
		}

		return false;
	}

}