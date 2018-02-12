<?php

namespace Simexis\ImageOptimizer\Optimizers;

use Simexis\ImageOptimizer\Image;

class Svgo extends BaseOptimizer
{
    public $binaryName = 'svgo';

    public function canHandle(Image $image): bool
    {
        if ($image->extension() !== 'svg') {
            return false;
        }

        return in_array($image->mime(), ['text/html', 'image/svg', 'image/svg+xml']);
    }

    public function binaryName(): string
    {
        return $this->binaryName;
    }

    public function getCommand(): string
    {
        $optionString = implode(' ', $this->options);

        return "".$this->binaryName()." {$optionString}"
            .' --input='.escapeshellarg($this->imagePath)
            .' --output='.escapeshellarg($this->imagePath);
    }
}
