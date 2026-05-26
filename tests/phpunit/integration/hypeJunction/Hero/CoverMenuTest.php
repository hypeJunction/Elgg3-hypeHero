<?php

namespace hypeJunction\Hero;

use Elgg\Hook;
use Elgg\IntegrationTestCase;

class CoverMenuTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypehero';
	}

	public function up(): void {
	}

	public function down(): void {
	}

	public function testReturnsNullWhenEntityParamMissing(): void {
		$hook = $this->getMockBuilder(Hook::class)->getMock();
		$hook->method('getValue')->willReturn([]);
		$hook->method('getEntityParam')->willReturn(null);

		$handler = new CoverMenu();
		$result = $handler($hook);

		$this->assertNull($result);
	}

	public function testAddsCoverUploadMenuItemWhenOwnerCanEdit(): void {
		$user = $this->createUser();

		// Logged-in user is the entity owner — canEdit() returns true.
		\elgg_get_session()->setLoggedInUser($user);

		try {
			$hook = $this->getMockBuilder(Hook::class)->getMock();
			$hook->method('getValue')->willReturn([]);
			$hook->method('getEntityParam')->willReturn($user);

			$handler = new CoverMenu();
			$result = $handler($hook);

			$this->assertIsArray($result);
			$names = array_map(fn(\ElggMenuItem $i) => $i->getName(), $result);
			$this->assertContains('cover:upload', $names);
		} finally {
			\elgg_get_session()->removeLoggedInUser();
		}
	}

	public function testCoverUploadHrefMatchesGeneratedRoute(): void {
		$user = $this->createUser();
		\elgg_get_session()->setLoggedInUser($user);

		try {
			$hook = $this->getMockBuilder(Hook::class)->getMock();
			$hook->method('getValue')->willReturn([]);
			$hook->method('getEntityParam')->willReturn($user);

			$handler = new CoverMenu();
			$result = $handler($hook);

			$upload = null;
			foreach ($result as $item) {
				if ($item->getName() === 'cover:upload') {
					$upload = $item;
					break;
				}
			}

			$this->assertInstanceOf(\ElggMenuItem::class, $upload);
			$expected = \elgg_generate_url('cover:upload', ['guid' => $user->guid]);
			$this->assertSame($expected, $upload->getHref());
		} finally {
			\elgg_get_session()->removeLoggedInUser();
		}
	}
}
