<?php

namespace hypeJunction\Hero;

use Elgg\Event;
use Elgg\IntegrationTestCase;

class HeroMenuTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypehero';
	}

	public function up(): void {
	}

	public function down(): void {
	}

	public function testReturnsNullWhenEntityIsNotUserOrGroup(): void {
		$object = $this->createObject(['subtype' => 'page']);

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);
		$event->method('getEntityParam')->willReturn($object);

		$handler = new HeroMenu();
		$result = $handler($event);

		$this->assertSame([], $result);
	}

	public function testAppendsProfileMenuItemForUser(): void {
		$user = $this->createUser();

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);
		$event->method('getEntityParam')->willReturn($user);

		$handler = new HeroMenu();
		$result = $handler($event);

		$this->assertIsArray($result);
		$this->assertNotEmpty($result);

		$names = array_map(fn(\ElggMenuItem $i) => $i->getName(), $result);
		$this->assertContains('profile', $names);
	}

	public function testAppendsProfileMenuItemForGroup(): void {
		$group = $this->createGroup();

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);
		$event->method('getEntityParam')->willReturn($group);

		$handler = new HeroMenu();
		$result = $handler($event);

		$this->assertIsArray($result);

		$names = array_map(fn(\ElggMenuItem $i) => $i->getName(), $result);
		$this->assertContains('profile', $names);
	}

	public function testProfileMenuItemPointsToEntityUrl(): void {
		$user = $this->createUser();

		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);
		$event->method('getEntityParam')->willReturn($user);

		$handler = new HeroMenu();
		$result = $handler($event);

		$profile = null;
		foreach ($result as $item) {
			if ($item->getName() === 'profile') {
				$profile = $item;
				break;
			}
		}

		$this->assertInstanceOf(\ElggMenuItem::class, $profile);
		$this->assertSame($user->getURL(), $profile->getHref());
	}
}
