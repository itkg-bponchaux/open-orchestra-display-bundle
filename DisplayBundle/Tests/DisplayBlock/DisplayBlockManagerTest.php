<?php

namespace OpenOrchestra\DisplayBundle\Tests\DisplayBlock;

use OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockManager;
use Phake;

/**
 * Test DisplayBlockManagerTest
 */
class DisplayBlockManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DisplayBlockManager
     */
    protected $manager;

    protected $block;
    protected $strategy;
    protected $templating;
    protected $wrongStrategy;
    protected $cacheableManager;
    protected $tagManager;
    protected $blockComponentTag = 'block-component';

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->block = Phake::mock('OpenOrchestra\ModelInterface\Model\ReadBlockInterface');
        Phake::when($this->block)->getComponent()->thenReturn('component');

        $this->cacheableManager = Phake::mock('OpenOrchestra\DisplayBundle\Manager\CacheableManager');
        $this->templating = Phake::mock('Symfony\Component\Templating\EngineInterface');

        $this->tagManager = Phake::mock('OpenOrchestra\BaseBundle\Manager\TagManager');
        Phake::when($this->tagManager)->formatBlockTypeTag(Phake::anyParameters())->thenReturn($this->blockComponentTag);

        $this->wrongStrategy = Phake::mock('OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface');
        Phake::when($this->wrongStrategy)->support(Phake::anyParameters())->thenReturn(false);
        Phake::when($this->wrongStrategy)->getName()->thenReturn('wrong');
        $this->strategy = Phake::mock('OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface');
        Phake::when($this->strategy)->support(Phake::anyParameters())->thenReturn(true);
        Phake::when($this->strategy)->getName()->thenReturn('right');

        $currentSiteManager = Phake::mock('OpenOrchestra\DisplayBundle\Manager\SiteManager');

        $this->manager = new DisplayBlockManager($this->templating, $this->cacheableManager, $this->tagManager, $currentSiteManager);
        $this->manager->addStrategy($this->wrongStrategy);
        $this->manager->addStrategy($this->strategy);
    }

    /**
     * Test get templating
     */
    public function testGetTemplating()
    {
        $this->assertSame($this->templating, $this->manager->getTemplating());
    }

    /**
     * Test show
     *
     * @param int    $blockMaxAge
     * @param string $status
     *
     * @dataProvider provideMaxAge
     */
    public function testShow($blockMaxAge, $status)
    {
        Phake::when($this->block)->getMaxAge()->thenReturn($blockMaxAge);

        $response = Phake::mock('Symfony\Component\HttpFoundation\Response');

        Phake::when($this->strategy)->show($this->block)->thenReturn($response);
        Phake::when($this->strategy)->isPublic($this->block)->thenReturn($status == 'public');

        Phake::when($this->cacheableManager)->setResponseCacheParameters(Phake::anyParameters())->thenReturn($response);

        $newResponse = $this->manager->show($this->block);

        $this->assertSame($response, $newResponse);
        Phake::verify($this->wrongStrategy, Phake::never())->show(Phake::anyParameters());
        Phake::verify($this->strategy)->show(Phake::anyParameters());
        Phake::verify($this->cacheableManager)->setResponseCacheParameters($response, $blockMaxAge, $status);
    }

    /**
     * @return array
     */
    public function provideMaxAge()
    {
        return array(
            array(0, 'public', ),
            array(1000, 'public'),
            array(-1, 'public'),
            array(0, 'private'),
            array(1000, 'private'),
            array(-1, 'private'),
        );
    }

    /**
     * test getTags
     * 
     * @param array  $strategyTags
     * @param array  $expectedTags
     * 
     * @dataProvider provideTags
     */
    public function testGetTags($strategyTags, $expectedTags)
    {
        Phake::when($this->strategy)->getTags($this->block)->thenReturn($strategyTags);

        $tags = $this->manager->getTags($this->block);
        $this->assertSame($tags, $expectedTags);
    }

    /**
     * @return array
     */
    public function provideTags()
    {
        return array(
            array(array('tag1'), array('tag1', $this->blockComponentTag)),
            array(array('tag1', 'tag2'), array('tag1', 'tag2', $this->blockComponentTag)),
        );
    }

    /**
     * @param string $method
     *
     * @dataProvider provideMethodName
     */
    public function testWithNoGoodStrategy($method)
    {
        Phake::when($this->strategy)->support(Phake::anyParameters())->thenReturn(false);

        $this->setExpectedException('OpenOrchestra\DisplayBundle\Exception\DisplayBlockStrategyNotFoundException');
        $this->manager->$method($this->block);
    }

    /**
     * @return array
     */
    public function provideMethodName()
    {
        return array(
            array('show'),
            array('getTags'),
        );
    }
}
