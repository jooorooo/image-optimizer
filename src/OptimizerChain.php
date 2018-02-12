<?php

namespace Simexis\ImageOptimizer;

use Symfony\Component\Process\Process;

class OptimizerChain
{
    /* @var \Simexis\ImageOptimizer\Optimizer[] */
    protected $optimizers = [];

    /** @var int */
    protected $timeout = 60;

    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getOptimizers(): array
    {
        return $this->optimizers;
    }

    /**
     * @param Optimizer $optimizer
     * @return $this
     */
    public function addOptimizer(Optimizer $optimizer)
    {
        $this->optimizers[] = $optimizer;

        return $this;
    }

    /**
     * @param array $optimizers
     * @return $this
     */
    public function setOptimizers(array $optimizers)
    {
        $this->optimizers = [];

        foreach ($optimizers as $optimizer) {
            $this->addOptimizer($optimizer);
        }

        return $this;
    }

    /*
     * Set the amount of seconds each separate optimizer may use.
     */
    public function setTimeout(int $timeoutInSeconds)
    {
        $this->timeout = $timeoutInSeconds;

        return $this;
    }

    /**
     * @param string $pathToImage
     * @param string|null $pathToOutput
     */
    public function optimize(string $pathToImage, string $pathToOutput = null)
    {
        if ($pathToOutput) {
            copy($pathToImage, $pathToOutput);

            $pathToImage = $pathToOutput;
        }

        $image = new Image($pathToImage);

        foreach ($this->optimizers as $optimizer) {
            $this->applyOptimizer($optimizer, $image);
        }
    }

    /**
     * @param Optimizer $optimizer
     * @param Image $image
     *
     * @return int The exit status code
     */
    protected function applyOptimizer(Optimizer $optimizer, Image $image)
    {
        if (! $optimizer->canHandle($image)) {
            return null;
        }

        $optimizer->setImagePath($image->path());

        $command = $optimizer->getCommand();

        $process = new Process($command);

        $status = $process
            ->setTimeout($this->timeout)
            ->run();

        $optimizer->afterOptimize();

        return $status;
    }
}
