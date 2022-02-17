<?php

namespace Evotodi\WaveBundle;

// use KnpU\LoremIpsumBundle\DependencyInjection\Compiler\WordProviderCompilerPass;
use Evotodi\WaveBundle\DependencyInjection\EvotodiWaveExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvotodiWaveBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        // $container->addCompilerPass(new WordProviderCompilerPass());
    }

    /**
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new EvotodiWaveExtension();
        }

        return $this->extension;
    }
}
