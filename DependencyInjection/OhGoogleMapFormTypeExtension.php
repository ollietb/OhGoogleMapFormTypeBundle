<?php

namespace Oh\GoogleMapFormTypeBundle\DependencyInjection;

use Oh\GoogleMapFormTypeBundle\Form\Type\GoogleMapType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OhGoogleMapFormTypeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->register('form.type.oh_google_maps', GoogleMapType::class)
            ->addArgument($config['api_key'])
            ->addTag('form.type')
        ;
    }
}
