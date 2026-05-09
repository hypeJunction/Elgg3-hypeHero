<?php

namespace hypeJunction\Hero;

use Elgg\Event;
use Elgg\IntegrationTestCase;

class DefineCoverSizesTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypehero';
	}

	public function up(): void {
	}

	public function down(): void {
	}

	public function testReturnsFullSizeMapWhenInputIsEmpty(): void {
		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);

		$handler = new DefineCoverSizes();
		$result = $handler($event);

		$this->assertIsArray($result);
		$this->assertArrayHasKey('hero', $result);
		$this->assertArrayHasKey('master', $result);
		$this->assertArrayHasKey('large', $result);
		$this->assertArrayHasKey('medium', $result);
		$this->assertArrayHasKey('small', $result);
		$this->assertArrayHasKey('original', $result);
	}

	public function testHeroSizeIsTwoThousandByFourHundred(): void {
		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([]);

		$handler = new DefineCoverSizes();
		$result = $handler($event);

		$this->assertSame(2000, $result['hero']['w']);
		$this->assertSame(400, $result['hero']['h']);
		$this->assertFalse($result['hero']['square']);
		$this->assertTrue($result['hero']['upscale']);
	}

	public function testInjectsHeroSizeWhenInputAlreadyHasOtherSizes(): void {
		$event = $this->getMockBuilder(Event::class)->disableOriginalConstructor()->getMock();
		$event->method('getValue')->willReturn([
			'thumb' => ['w' => 100, 'h' => 100, 'square' => true, 'upscale' => true],
		]);

		$handler = new DefineCoverSizes();
		$result = $handler($event);

		$this->assertArrayHasKey('thumb', $result);
		$this->assertArrayHasKey('hero', $result);
		$this->assertSame(2000, $result['hero']['w']);
		// existing sizes are preserved untouched
		$this->assertSame(100, $result['thumb']['w']);
	}
}
