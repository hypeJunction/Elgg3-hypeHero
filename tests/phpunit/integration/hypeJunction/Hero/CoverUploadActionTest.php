<?php

namespace hypeJunction\Hero;

use Elgg\Exceptions\Http\EntityPermissionsException;
use Elgg\IntegrationTestCase;
use Elgg\Request;

class CoverUploadActionTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypehero';
	}

	public function up(): void {
	}

	public function down(): void {
	}

	public function testThrowsPermissionsExceptionWhenEntityMissing(): void {
		$request = $this->getMockBuilder(Request::class)
			->disableOriginalConstructor()
			->getMock();
		$request->method('getEntityParam')->willReturn(null);

		$action = new CoverUploadAction();

		$this->expectException(EntityPermissionsException::class);
		$action($request);
	}

	public function testThrowsPermissionsExceptionWhenCallerCannotEdit(): void {
		$owner = $this->createUser();
		$other = $this->createUser();

		$entity = $this->createObject([
			'subtype' => 'page',
			'owner_guid' => $owner->guid,
			'access_id' => ACCESS_PUBLIC,
		]);

		elgg_get_session()->setLoggedInUser($other);

		try {
			$request = $this->getMockBuilder(Request::class)
				->disableOriginalConstructor()
				->getMock();
			$request->method('getEntityParam')->willReturn($entity);

			$action = new CoverUploadAction();

			$this->expectException(EntityPermissionsException::class);
			$action($request);
		} finally {
			elgg_get_session()->removeLoggedInUser();
		}
	}
}
