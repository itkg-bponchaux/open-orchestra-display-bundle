<?php

namespace OpenOrchestra\DisplayBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The FrameworkBundle router is extended to inject documents service
 * in OpenOrchestraUrlMatcher
 */
class OpenOrchestraRouter extends Router
{
    protected $nodeRepository;
    protected $requestStack;
    protected $siteManager;

    /**
     * Extends parent constructor to get documents service
     * as $container is private in parent class
     *
     * @param ContainerInterface $container
     * @param mixed              $resource
     * @param array              $options
     * @param RequestContext     $context
     */
    public function __construct(
        ContainerInterface $container,
        $resource,
        array $options = array(),
        RequestContext $context = null
    )
    {
        parent::__construct($container, $resource, $options, $context);

        $this->nodeRepository = $container->get('open_orchestra_model.repository.node');
        $this->siteManager = $container->get('open_orchestra.manager.current_site');
        $this->requestStack = $container->get('request_stack');
    }

    /**
     * Get the url generator
     *
     * @return UrlGeneratorInterface|null
     */
    public function getGenerator()
    {
        if (null !== $this->generator) {
            return $this->generator;
        }

        return $this->generator = new $this->options['generator_class'](
            $this->getRouteCollection(),
            $this->context,
            $this->nodeRepository,
            $this->siteManager,
            $this->requestStack,
            $this->logger
        );
    }
}
