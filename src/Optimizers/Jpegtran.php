<?php

namespace Simexis\ImageOptimizer\Optimizers;

use Simexis\ImageOptimizer\Image;

class Jpegtran extends BaseOptimizer
{
    public $binaryName = 'jpegtran';

    public $temp;

    public function binaryName(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return dirname(dirname(__DIR__)) . '/bin/cjpeg.exe';
        } else {
            return $this->binaryName;
        }
    }

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/jpeg';
    }

    public function getCommand(): string
    {
        $optionString = implode(' ', $this->options);
        $temp = $this->getTempFileName();

        return "\"" . $this->binaryName() . "\" {$optionString} " . escapeshellarg($this->imagePath) . " > " . escapeshellarg($temp);
    }

    public function afterOptimize() {
        rename($this->getTempFileName(), $this->imagePath);
    }

    protected function getTempFileName() {
        if(is_null($this->temp)) {
            $this->temp = tempnam(sys_get_temp_dir(), 'Tux');
        }
        return $this->temp;
    }
}
