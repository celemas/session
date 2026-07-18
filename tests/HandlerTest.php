<?php

declare(strict_types=1);

namespace Celema\Session {
	function session_set_save_handler($handler, $registerShutdown = true): bool
	{
		return \Celema\Session\Tests\HandlerTest::sessionSetSaveHandlerResult(
			$handler,
			$registerShutdown,
		);
	}
}

namespace Celema\Session\Tests {
	use Celema\Session\RuntimeException;
	use Celema\Session\Session;

	final class HandlerTest extends TestCase
	{
		private static bool $forceHandlerFalse = false;

		public static function sessionSetSaveHandlerResult($handler, $registerShutdown): bool
		{
			if (self::$forceHandlerFalse) {
				return false;
			}

			return \session_set_save_handler($handler, (bool) $registerShutdown);
		}

		protected function tearDown(): void
		{
			self::$forceHandlerFalse = false;

			if (session_status() === PHP_SESSION_ACTIVE) {
				session_unset();
				session_destroy();
			}

			parent::tearDown();
		}

		public function testCustomHandler(): void
		{
			$handler = new TestSessionHandler();
			$session = new Session(name: 'custom', handler: $handler);
			$session->start();
			$session->set('test', 'value');

			self::assertSame('custom', $session->name());
			self::assertSame('value', $session->get('test'));
			self::assertTrue($handler->visited);

			$session->destroy();
		}

		public function testCustomHandlerSetupFailureThrows(): void
		{
			self::$forceHandlerFalse = true;
			$handler = new TestSessionHandler();
			$session = new Session(handler: $handler);

			$this->expectException(RuntimeException::class);
			$this->expectExceptionMessage('Session handler setup failed');

			$session->start();
		}
	}
}
