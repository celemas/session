# Celema Sessions

<!-- prettier-ignore-start -->
[![ci](https://codefloe.com/celema/session/badges/workflows/ci.yml/badge.svg?style=flat&logo=forgejo&logoColor=white&label=ci)](https://codefloe.com/celema/session/actions)
[![code coverage](https://img.shields.io/endpoint?url=https%3A%2F%2Fcov.celema.dev%2Fcelema%2Fsession%2Fcode%2Fbadge.json)](https://cov.celema.dev/celema/session/code)
[![type coverage](https://img.shields.io/endpoint?url=https%3A%2F%2Fcov.celema.dev%2Fcelema%2Fsession%2Ftypes%2Fbadge-cover.json)](https://cov.celema.dev/celema/session/types)
[![psalm level](https://img.shields.io/endpoint?url=https%3A%2F%2Fcov.celema.dev%2Fcelema%2Fsession%2Ftypes%2Fbadge-level.json)](https://cov.celema.dev/celema/session/types)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)
<!-- prettier-ignore-end -->

Helper classes for native PHP sessions, flash messages, and CSRF.

## Installation

```bash
composer require celema/session
```

## Documentation

Start here: [docs/index.md](docs/index.md).

## Quick start

```php
use Celema\Session\Session;

$session = new Session();
$session->start();

$session->set('user_id', 123);
$userId = $session->get('user_id');

$session->flash->add('Signed in.');

$token = $session->csrf->token('profile');
```

`Session` merges custom options with secure defaults for Secure and HttpOnly cookies, SameSite=Lax, strict session IDs, cookie-only session IDs, disabled transparent session IDs, and PHP's `nocache` session cache limiter. Set `cookie_secure` to `false` only for intentional plain HTTP environments, such as local development without TLS.

## Mutation testing

Mutation testing with [Infection](https://infection.github.io/) is not part of `composer ci`, but the CI workflow runs it after the coverage step and enforces the minimum mutation score from `infection.json5.dist`. Pushes only mutate the changed lines; a weekly scheduled run covers the whole codebase. Run it locally with:

```console
composer mutation
```

Reports are written to `.infection/`.

## License

This project is licensed under the [MIT license](LICENSE.md).
