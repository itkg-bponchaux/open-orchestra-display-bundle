<?php

namespace PHPOrchestra\DisplayBundle\DisplayBlock\Strategies;

use PHPOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use PHPOrchestra\ModelBundle\Repository\NodeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class FooterStrategy
 */
class FooterStrategy extends AbstractStrategy
{
    protected $nodeRepository;
    protected $router;
<<<<<<< Updated upstream
=======
    protected $sitManager;
>>>>>>> Stashed changes

    /**
     * @param NodeRepository        $nodeRepository
     * @param UrlGeneratorInterface $router
<<<<<<< Updated upstream
     */
    public function __construct(NodeRepository $nodeRepository, UrlGeneratorInterface $router)
    {
        $this->nodeRepository = $nodeRepository;
        $this->router = $router;
=======
     * @param SiteManager           $sitManager
     */
    public function __construct(NodeRepository $nodeRepository, UrlGeneratorInterface $router, SiteManager $sitManager)
    {
        $this->nodeRepository = $nodeRepository;
        $this->router = $router;
        $this->sitManager = $sitManager;
>>>>>>> Stashed changes
    }

    /**
     * Check if the strategy support this block
     *
     * @param BlockInterface $block
     *
     * @return boolean
     */
    public function support(BlockInterface $block)
    {
        return DisplayBlockInterface::FOOTER == $block->getComponent();
    }

    /**
     * Perform the show action for a block
     *
     * @param BlockInterface $block
     *
     * @return Response
     */
    public function show(BlockInterface $block)
    {
<<<<<<< Updated upstream
        $nodes = $this->nodeRepository->getFooterTree();
=======
        $nodes = $this->nodeRepository->getFooterTree($this->sitManager->getSiteId());
>>>>>>> Stashed changes
        $attributes = $block->getAttributes();

        return $this->render(
            'PHPOrchestraDisplayBundle:Block/Footer:show.html.twig',
            array(
                'tree' => $nodes->toArray(),
                'id' => $attributes['id'],
                'class' => $attributes['class'],
            )
        );
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'footer';
    }
}
