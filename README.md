SessionStorer
=============

[![Tests](https://github.com/atk14/SessionStorer/actions/workflows/tests.yml/badge.svg)](https://github.com/atk14/SessionStorer/actions/workflows/tests.yml)

A library for storing sessions in a database or in cookies, used in the [ATK14 Framework](https://github.com/atk14).

Installation
------------

```bash
composer require atk14/session-storer
```

Basic usage
-----------

```php
$session = new SessionStorer();

$session->writeValue("user_id", 42);
$user_id = $session->readValue("user_id"); // 42
```

Cookie-only mode
----------------

When a database is not available or not desired, values can be stored exclusively in cookies by passing `cookie_only => true`. The data never touches the database.

```php
$session = new SessionStorer([
    "session_name" => "cart",
    "cookie_only" => true,
]);

$session->writeValue("step", 2);
$step = $session->readValue("step"); // 2
```

Values are packed into one or more numbered cookies (`cart0`, `cart1`, …) with a length prefix in the first cookie. The packed data is encrypted and signed via `Packer::Pack()`, making it resistant to tampering by the client. Expired values are automatically removed from cookies on the next read.

Sessions cleanup (cron job)
---------------------------

Old sessions can be cleaned up by calling the static method `DeleteOldSessions()`.
It is suitable for use in a cron job (e.g. `sessions_cleanup` running once a day):

```php
$deleted = SessionStorer::DeleteOldSessions([
    "session_name" => "session",
    "max_lifetime" => 60 * 60 * 24, // 1 day
]);
```

Available options:

| Option         | Default | Description |
|----------------|---------|-------------|
| `dbmole`       | auto    | dbmole instance; auto-detected from globals or singleton if not provided |
| `current_time` | `time()` | Unix timestamp to use as "now" |
| `session_name` | `null`  | if set together with `max_lifetime`, deletes expired sessions by name |
| `max_lifetime` | `null`  | session lifetime in seconds |
| `deep_clean`   | `true`  | if true, also deletes all sessions older than 2 years |

The method returns the total count of deleted records.

License
-------

MIT
