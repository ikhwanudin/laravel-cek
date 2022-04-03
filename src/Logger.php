<?php

namespace Reaimagine\LaravelCek;

use Monolog\Logger as Monologger;

/**
 * Class TelegramLogger
 * @package App\Logging
 */
class Logger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return new Monologger(
            config('app.name'),
            [
                new LogHandler($config),
            ]
        );
    }
}
