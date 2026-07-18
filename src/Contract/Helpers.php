<?php

declare(strict_types=1);

namespace Celema\Session\Contract;

use Celema\Session\Csrf;
use Celema\Session\Flash;
use Celema\Session\Session;
use Celema\Session\Uri;

/** @api */
interface Helpers
{
	public function flash(Session $session): Flash;

	public function csrf(Session $session): Csrf;

	public function uri(Session $session): Uri;
}
