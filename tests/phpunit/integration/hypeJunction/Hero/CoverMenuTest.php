<?php

namespace hypeJunction\Hero;

use Elgg\Event;
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
		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);
		$event->method('getEntityParam')->willReturn(null);

		$handler = new CoverMenu();
		$result = $handler($event);

		$this->assertNull($result);
	}

	public function testAddsCoverUploadMenuItemWhenOwnerCanEdit(): void {
		$user = $this->createUser();

		// Logged-in user is the entity owner — canEdit() returns true.
		\_elgg_services()->session_manager->setLoggedInUser($user);

		try {
			$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
			$event->method('getValue')->willReturn([]);
			$event->method('getEntityParam')->willReturn($user);

			$handler = new CoverMenu();
			$result = $handler($event);

			$this->assertIsArray($result);
			$names = array_map(fn(\ElggMenuItem $i) => $i->getName(), $result);
			$this->assertContains('cover:upload', $names);
		} finally {
			\_elgg_services()->session_manager->removeLoggedInUser();
		}
	}

	public function testCoverUploadHrefMatchesGeneratedRoute(): void {
		$user = $this->createUser();
		\_elgg_services()->session_manager->setLoggedInUser($user);

		try {
			$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
			$event->method('getValue')->willReturn([]);
			$event->method('getEntityParam')->willReturn($user);

			$handler = new CoverMenu();
			$result = $handler($event);

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
			\_elgg_services()->session_manager->removeLoggedInUser();
		}
	}
}
