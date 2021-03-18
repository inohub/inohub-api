<?php

namespace App\Components\Logger;

use App\Components\Exceptions\BaseException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class FileLog
 * @property $fileName
 * @property $filePath
 * @property $path
 * @property $log
 * @package App\Components\Logger
 */
class FileLog
{
    private $fileName;
    private $filePath;
    private $path;
    private $log;

    public function __construct($channel, $file = 'custom')
    {
        $this->log = \Log::channel($channel);
        $this->path = storage_path('logs/' . $this->getData());
        $this->setFile($file);
    }

    public function getLogger()
    {
        return $this->log;
    }

    private function refreshLogger()
    {
        $this->filePath = $this->path . DIRECTORY_SEPARATOR . $this->fileName . '.log';
        $stream = new LogHandler($this->filePath);
        $stream->setFormatter(new CustomLogFormatter(
            "******START*[%datetime%]******\n%message%\n%context%\n%extra%\n******END*[%datetime%]******\n\n"
        ));

        $stream->fileName = $this->fileName;
        $stream->path = $this->path;
        $this->log->getLogger()->setHandlers([$stream]);
        $stream->close();
    }

    public function setFile($file)
    {
        $this->fileName = $file;
        $this->refreshLogger();

        return $this;
    }

    private function getData()
    {
        return (new Carbon())->now()->format('d.m.Y');
    }

    public function exceptionLog(\Throwable $exception)
    {
        $data = [
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'message' => $exception->getMessage(),
            'code'    => $exception->getCode(),
            'trace'   => array_slice(explode("\n", $exception->getTraceAsString()), 0, 5),
            'user'    => Auth::id()
        ];

        if ($exception instanceof BaseException) {
            $data['data'] = $exception->getData();
        }

        $this->getLogger()->error($data);

        return true;
    }
}
