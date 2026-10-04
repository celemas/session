<?php

declare(strict_types=1);

namespace Celema\Session\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use SessionHandler;

/**
 * @internal
 *
 * @coversNothing
 */
class TestCase extends BaseTestCase
{
	/** @var array<string, string|false>|null */
	private static ?array $cookieIni = null;

	protected function setUp(): void
	{
		parent::setUp();

		// session_start() options persist as ini settings; restore the cookie
		// settings so tests do not depend on the order they run in.
		if (session_status() === PHP_SESSION_ACTIVE) {
			session_abort();
		}

		self::$cookieIni ??= array_filter(
			ini_get_all('session', false),
			static fn(string $key): bool => str_starts_with($key, 'session.cookie_'),
			ARRAY_FILTER_USE_KEY,
		);

		foreach (self::$cookieIni as $key => $value) {
			// @mago-expect lint:no-ini-set
			ini_set($key, (string) $value);
		}

		session_name('PHPSESSID');
		session_set_save_handler(new SessionHandler(), true);
	}
}
