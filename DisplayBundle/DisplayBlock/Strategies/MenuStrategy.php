<?php

namespace OpenOrchestra\DisplayBundle\DisplayBlock\Strategies;

use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use OpenOrchestra\ModelInterface\Repository\ReadNodeRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use OpenOrchestra\BaseBundle\Manager\TagManager;

/**
 * Class MenuStrategy
 */
class MenuStrategy extends AbstractStrategy
{
    const MENU = 'menu';

    protected $nodeRepository;
    protected $request;
    protected $tagManager;

    /**
     * @param ReadNodeRepositoryInterface $nodeRepository
     * @param RequestStack                $requestStack
     * @param TagManager                  $tagManager
     */
    public function __construct(
        ReadNodeRepositoryInterface $nodeRepository,
        RequestStack $requestStack,
        TagManager $tagManager
    ){
        $this->nodeRepository = $nodeRepository;
        $this->request = $requestStack->getMasterRequest();
        $this->tagManager = $tagManager;
    }

    /**
     * Check if the strategy support this block
     *
     * @param ReadBlockInterface $block
     *
     * @return boolean
     */
    public function support(ReadBlockInterface $block)
    {
        return self::MENU == $block->getComponent();
    }

    /**
     * Indicate if the block is public or private
     *
     * @param ReadBlockInterface $block
     *
     * @return bool
     */
    public function isPublic(ReadBlockInterface $block)
    {
        return true;
    }

    /**
     * Perform the show action for a block
     *
     * @param ReadBlockInterface $block
     *
     * @return Response
     */
    public function show(ReadBlockInterface $block)
    {
        $nodes = $this->getNodes();

        return $this->render(
            'OpenOrchestraDisplayBundle:Block/Menu:tree.html.twig',
            array(
                'tree' => $nodes,
                'id' => $block->getId(),
                'class' => $block->getClass(),
            )
        );
    }

    /**
     * Get Nodes to display
     * 
     * @return array
     */
    protected function getNodes()
    {
        return $this->nodeRepository->getMenuTree($this->request->getLocale());
    }

    /**
     * Return block specific tags
     * 
     * @param ReadBlockInterface $block
     * 
     * @return array
     */
    public function getTags(ReadBlockInterface $block)
    {
        $tags = array();

        $nodes = $this->getNodes();

        if ($nodes) {
            foreach ($nodes as $node) {
                $tags[] = $this->tagManager->formatNodeIdTag($node->getNodeId());
            }
        }

        return $tags;
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'menu';
    }

}
