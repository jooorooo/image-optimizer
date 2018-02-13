<?php

namespace Simexis\ImageOptimizer;

use Simexis\ImageOptimizer\Optimizers\Jpegoptim;
use Simexis\ImageOptimizer\Optimizers\JpegRecompress;
use Simexis\ImageOptimizer\Optimizers\Svgo;
use Simexis\ImageOptimizer\Optimizers\Optipng;
use Simexis\ImageOptimizer\Optimizers\Gifsicle;
use Simexis\ImageOptimizer\Optimizers\Pngquant;
use Simexis\ImageOptimizer\Optimizers\Jpegtran;

class OptimizerChainFactory
{
    public static function create(): OptimizerChain
    {
        return (new OptimizerChain())
//            ->addOptimizer(new Jpegtran([
//                '-optimize'
//            ]))

//            ->addOptimizer(new Jpegoptim([
//                '-p',
//                '-m 60'
//            ]))

            ->addOptimizer(new JpegRecompress([
                '--quality high',
//                '--method ms-ssim',
//                '--min 100'
            ]))

            ->addOptimizer(new Pngquant([
                '--force',
                '--quality=60-90'
            ]))

            ->addOptimizer(new Optipng([
                '-i0',
                '-o2',
                '-quiet',
            ]))

            ->addOptimizer(new Svgo([
                '--disable=cleanupIDs',
            ]))

            ->addOptimizer(new Gifsicle([
                '-b',
                '-O3',
            ]));
    }
}
