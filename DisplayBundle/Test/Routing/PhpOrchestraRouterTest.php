<?php

namespace PHPOrchestra\DisplayBundle\Test\Routing;

use Phake;
use PHPOrchestra\DisplayBundle\Routing\PhpOrchestraRouter;
use Symfony\Component\Routing\RouteCollection;

/**
 * Tests of PhpOrchestraUrlRouter
 */
class PhpOrchestraRouterTest extends \PHPUnit_Framework_TestCase
{
    protected $router;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $cacheService = Phake::mock('PHPOrchestra\BaseBundle\Cache\CacheManagerInterface');
        $nodeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\NodeRepository');

        $mockRoutingLoader = Phake::mock('Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader');
        Phake::when($mockRoutingLoader)->load(Phake::anyParameters())->thenReturn(new RouteCollection());

        $container = Phake::mock('Symfony\Component\DependencyInjection\ContainerInterface');
        Phake::when($container)->get('routing.loader')->thenReturn($mockRoutingLoader);
        Phake::when($container)->get('php_orchestra_model.repository.node')->thenReturn($nodeRepository);
        Phake::when($container)->get('php_orchestra_base.cache_manager')->thenReturn($cacheService);

        $this->router = new PhpOrchestraRouter(
            $container,
            null,
            array(
                'generator_class' => 'PHPOrchestra\DisplayBundle\Routing\PhpOrchestraUrlGenerator',
                'generator_base_class' => 'PHPOrchestra\DisplayBundle\Routing\PhpOrchestraUrlGenerator',
            )
        );
    }

    /**
     * Test get matcher
     */
    public function testGetMatcher()
    {
        $this->assertNotInstanceOf(
            'PHPOrchestra\\DisplayBundle\\Routing\\PhpOrchestraUrlMatcher',
            $this->router->getMatcher()
        );
    }

    /**
     * test get generator
     */
    public function testGetGenerator()
    {
        $this->assertInstanceOf(
            'PHPOrchestra\\DisplayBundle\\Routing\\PhpOrchestraUrlGenerator',
            $this->router->getGenerator()
        );
    }
}
