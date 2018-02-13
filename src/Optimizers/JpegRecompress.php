<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 13.2.2018 г.
 * Time: 11:36 ч.
 */

namespace Simexis\ImageOptimizer\Optimizers;

use Simexis\ImageOptimizer\Image;


class JpegRecompress extends BaseOptimizer
{
    public $binaryName = 'jpeg-recompress';

    public function binaryName(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return dirname(dirname(__DIR__)) . '/bin/' . $this->binaryName . '.exe';
        } else {
            return dirname(dirname(__DIR__)) . '/bin/' . $this->binaryName;
        }
    }

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/jpeg';
    }

    public function getCommand(): string
    {
        $optionString = implode(' ', $this->options);

        return "\"".$this->binaryName()."\" {$optionString} " . escapeshellarg($this->imagePath) . " " . escapeshellarg($this->imagePath);
    }
}