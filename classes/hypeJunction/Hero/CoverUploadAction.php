<?php

namespace hypeJunction\Hero;

use Elgg\EntityPermissionsException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class CoverUploadAction {

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

		if (!$entity->saveIconFromUploadedFile('cover', 'cover')) {
			$error = $request->elgg()->echo('hero:cover:upload:error');

			return elgg_error_response($error);
		}

		unset($entity->{'cover:uid'});

		$fields = [
			'file_url',
			'author',
			'author_url',
			'provider',
			'provider_url',
			'license',
			'copyright',
			'disclaimer',
		];

		$has_attribution = false;
		foreach ($fields as $field) {
			$value =$request->getParam($field);
			$entity->{"cover:$field"} = $value;
			if ($value) {
				$has_attribution = true;
			}
		}

		$entity->{"cover:attribution"} = $has_attribution;

		$request->elgg()->events->trigger('update', 'object:cover', $entity);

		$msg = $request->elgg()->echo('hero:cover:upload:success');
		$url = $entity->getURL();

		return elgg_ok_response([
			'cover_url' => $entity->getIconURL(['type' => 'cover', 'size' => 'hero']),
		], $msg, $url);

	}
}