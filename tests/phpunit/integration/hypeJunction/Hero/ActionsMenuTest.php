<?php

namespace hypeJunction\Hero;

use Elgg\Hook;
use Elgg\IntegrationTestCase;

class ActionsMenuTest extends IntegrationTestCase {

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

		$handler = new ActionsMenu();
		$result = $handler($hook);

		$this->assertNull($result);
	}

	public function testStripsBlacklistedItems(): void {
		$user = $this->createUser();

		$incoming = [
			\ElggMenuItem::factory(['name' => 'groups:edit', 'text' => 'edit', 'href' => '#']),
			\ElggMenuItem::factory(['name' => 'avatar:edit', 'text' => 'avatar', 'href' => '#']),
			\ElggMenuItem::factory(['name' => 'profile:edit', 'text' => 'profile', 'href' => '#']),
			\ElggMenuItem::factory(['name' => 'keep_me', 'text' => 'keep', 'href' => '#']),
		];

		$hook = $this->getMockBuilder(Hook::class)->getMock();
		$hook->method('getValue')->willReturn($incoming);
		$hook->method('getEntityParam')->willReturn($user);

		$handler = new ActionsMenu();
		$result = $handler($hook);

		$names = array_map(fn(\ElggMenuItem $i) => $i->getName(), $result);

		$this->assertNotContains('groups:edit', $names);
		$this->assertNotContains('avatar:edit', $names);
		$this->assertNotContains('profile:edit', $names);
		$this->assertContains('keep_me', $names);
	}
}
