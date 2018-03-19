<?php

namespace hypeJunction\Hero;

use Elgg\EntityPermissionsException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class CoverPickAction {

	/**
	 * Cover upload action
	 *
	 * @param Request $request Request
	 *
	 * @return ResponseBuilder
	 * @throws EntityPermissionsException
	 */
	public function __invoke(Request $request) {

		$entity = $request->getEntityParam();
		if (!$entity || !$entity->canEdit()) {
			throw new EntityPermissionsException();
		}

		$entity->deleteIcon('cover');

		$library = $request->elgg()->{'cover.library'};
		/* @var $library \hypeJunction\Hero\CoverLibrary */

		$fields = [
			'file_url',
			'thumb_url',
			'author',
			'author_url',
			'provider',
			'provider_url',
			'license',
			'copyright',
			'disclaimer',
			'attribution',
			'gravity',
			'ratio',
			'color',
			'width',
			'height',
		];

		$uid = $request->getParam('uid');

		$image = $library->getImageFromUid($uid);

		$entity->{'cover:uid'} = $uid;

		foreach ($fields as $field) {
			$entity->{"cover:$field"} = $image->$field;
		}

		$request->elgg()->events->trigger('update', 'object:cover', $entity);

		$msg = $request->elgg()->echo('hero:cover:pick:success');
		$url = $entity->getURL();

		return elgg_ok_response([
			'cover_url' => $entity->getIconURL(['type' => 'cover', 'size' => 'hero']),
		], $msg, $url);

	}
}