<?php

namespace hypeJunction\Hero;

use Elgg\Hook;

class SetCoverArtwork {

	/**
	 * Use cover artwork
	 *
	 * @param Hook $hook Hook
	 *
	 * @return string
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();
		if (!$entity || !$entity->{'cover:uid'}) {
			return;
		}

		list($prefix, $id) = explode(':', $entity->{'cover:uid'});
		if ($prefix !== 'picsum') {
			return;
		}

		$library = $hook->elgg()->{'cover.library'};
		/* @var $library \hypeJunction\Hero\CoverLibrary */

		$image = $library->getImageFromUid($entity->{'cover:uid'});

		if (!$image) {
			return;
		}

		$size = $hook->getParam('size');

		$sizes = elgg_get_icon_sizes($entity->type, $entity->subtype, 'cover');

		$params = $sizes[$size];

		$width = $params['w'];
		$height = $params['h'];

		return $image->getURL($width, $height);
	}
}