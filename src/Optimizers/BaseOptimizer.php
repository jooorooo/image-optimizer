<?php

namespace Simexis\ImageOptimizer\Optimizers;

use Simexis\ImageOptimizer\Optimizer;

abstract class BaseOptimizer implements Optimizer
{
    public $binaryName;

    public $options = [];

    public $imagePath = '';

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    public function binaryName(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return dirname(dirname(__DIR__)) . '/bin/' . $this->binaryName . '.exe';
        } else {
            return $this->binaryName;
        }
    }

    public function setImagePath(string $imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function setOptions(array $options = [])
    {
        $this->options = $options;

        return $this;
    }

    public function getCommand(): string
    {
        $optionString = implode(' ', $this->options);

        return "\"".$this->binaryName()."\" {$optionString} ".escapeshellarg($this->imagePath);
    }

    public function afterOptimize() {
        return;
    }
}
