<?php

namespace Simexis\ImageOptimizer\Optimizers;

use Simexis\ImageOptimizer\Image;

class Optipng extends BaseOptimizer
{
    public $binaryName = 'optipng';

    public function canHandle(Image $image): bool
    {
        return $image->mime() === 'image/png';
    }
}
