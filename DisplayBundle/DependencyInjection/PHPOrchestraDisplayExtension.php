<?php

namespace PHPOrchestra\DisplayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PHPOrchestraDisplayExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('display.yml');
        $loader->load('manager.yml');
        $loader->load('twig.yml');

        if (array_key_exists('administrator_email', $config)) {
            $container->setParameter('php_orchestra_display.administrator_contact_email', $config['administrator_email']);
        } else {
            $container->setParameter('php_orchestra_display.administrator_contact_email', 'nicolas.thal@businessdecision.com');
        }

        if (array_key_exists('contact_signature', $config)) {
            $container->setParameter('php_orchestra_display.contact_signature_email', $config['contact_signature']);
        } else {
            $container->setParameter('php_orchestra_display.contact_signature_email', 'Orchestra');
        }
    }
}
