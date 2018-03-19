<?php

namespace hypeJunction\Hero;

/**
 * @property string $uid
 * @property string $file_url
 * @property string $author
 * @property string $author_url
 * @property string $provider
 * @property string $provider_url
 * @property string $license
 * @property string $copyright
 * @property string $disclaimer
 */
class CoverImage extends \ArrayObject {

	/**
	 * {@inheritdoc}
	 */
	public function __construct($input = [], int $flags = self::ARRAY_AS_PROPS, string $iterator_class = "ArrayIterator") {
		parent::__construct($input, $flags, $iterator_class);
	}

	/**
	 * Get URL of the image
	 *
	 * @param int $width  Width
	 * @param int $height Height
	 *
	 * @return string
	 */
	public function getURL($width = 2000, $height = 400) {
		$url = $this->file_url;
		$url = str_replace('{width}', $width, $url);
		$url = str_replace('{height}', $height, $url);

		return $url;
	}
}