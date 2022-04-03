<?php

namespace Reaimagine\LaravelCek;

use Exception;
use Illuminate\Support\Facades\Http;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class TelegramHandler
 * @package App\Logging
 */
class LogHandler extends AbstractProcessingHandler
{
    /**
     * Logger config
     * 
     * @var array
     */
    private $config;

    /**
     * Laravel cek port
     *
     * @var string
     */
    private $laravelCekPort;

    /**
     * Laravel cek host
     *
     * @var string
     */
    private $laravelCekHost;

    /**
     * Application name
     *
     * @string
     */
    private $appName;

    /**
     * Application environment
     *
     * @string
     */
    private $appEnv;

    /**
     * TelegramHandler constructor.
     * @param int $level
     */
    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level, true);

        // define variables for making Telegram request
        $this->config = $config;
        $this->laravelCekHost = $this->getConfigValue('host');
        $this->laravelCekPort = $this->getConfigValue('port');

        // define variables for text message
        $this->appName = config('app.name');
        $this->appEnv  = config('app.env');
    }

    /**
     * @param array $record
     */
    public function write(array $record): void
    {
        if ($this->laravelCekPort == null) {
            throw new \InvalidArgumentException('Laravel cek port is not defined');
        }

        // trying to make request and send notification
        try {

            $textChunks = str_split($this->formatText($record), 4096);
            foreach ($textChunks as $textChunk) {
                $this->sendMessage($textChunk);
            }
        } catch (Exception $exception) {
            \Log::channel('single')->error($exception->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter("%message% %context% %extra%\n", null, false, true);
    }

    /**
     * @param array $record
     * @return string
     */
    private function formatText(array $record): string
    {
        // if ($template = config('laravel-cek.template')) {
        //     return view(
        //         $template,
        //         array_merge($record, [
        //             'appName' => $this->appName,
        //             'appEnv'  => $this->appEnv,
        //         ])
        //     );
        // }

        return sprintf("<b>%s</b> (%s)\n%s", $this->appName, $record['level_name'], $record['formatted']);
    }

    /**
     * @param  string  $text
     */
    private function sendMessage(string $text): void
    {
        Http::post($this->laravelCekHost . ':' . $this->laravelCekPort, [
            'data' => $text
        ]);
    }

    /**
     * @param string $key
     * @param string $defaultConfigKey
     * @return string
     */
    private function getConfigValue($key, $defaultConfigKey = null): string
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return config($defaultConfigKey ?: "laravel-cek.$key");
    }
}
