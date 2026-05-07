<?php

namespace hypeJunction\Hero;

use Elgg\IntegrationTestCase;

class BootstrapTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypehero';
	}

	public function up(): void {
	}

	public function down(): void {
	}

	public function testPluginIsActive(): void {
		$plugin = elgg_get_plugin_from_id('hypehero');
		$this->assertInstanceOf(\ElggPlugin::class, $plugin);
		$this->assertTrue($plugin->isActive());
	}

	public function testCoverSizesHookHandlerIsRegistered(): void {
		$this->assertTrue(_elgg_services()->hooks->hasHandler('entity:cover:sizes', 'all'));
	}

	public function testHeroMenuHookHandlerIsRegistered(): void {
		$this->assertTrue(_elgg_services()->hooks->hasHandler('register', 'menu:hero'));
	}

	public function testCoverMenuHookHandlerIsRegistered(): void {
		$this->assertTrue(_elgg_services()->hooks->hasHandler('register', 'menu:cover'));
	}

	public function testActionsMenuHookHandlerIsRegistered(): void {
		$this->assertTrue(_elgg_services()->hooks->hasHandler('register', 'menu:actions'));
	}

	public function testCoverUploadActionIsRegistered(): void {
		$actions = _elgg_services()->actions->getAllActions();
		$this->assertArrayHasKey('cover/upload', $actions);
	}

	public function testCoverUploadRouteIsRegistered(): void {
		$route = _elgg_services()->routes->get('cover:upload');
		$this->assertNotNull($route);
		$this->assertSame('/cover/upload/{guid}', $route->getPath());
	}

	public function testHeroCssViewExists(): void {
		$this->assertTrue(elgg_view_exists('page/elements/hero.css'));
	}
}
