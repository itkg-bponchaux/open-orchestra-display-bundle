<?php

namespace OpenOrchestra\DisplayBundle\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use OpenOrchestra\DisplayBundle\Exception\ContentNotFoundException;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConfigurableContentStrategy
 */
class ConfigurableContentStrategy extends AbstractStrategy
{
    protected $contentRepository;

    /**
     * @param ContentRepositoryInterface $contentRepository
     */
    public function __construct(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
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
        return DisplayBlockInterface::CONFIGURABLE_CONTENT == $block->getComponent();
    }

    /**
     * Indicate if the block is public or private
     * 
     * @return boolean
     */
    public function isPublic(BlockInterface $block = null)
    {
        return true;
    }

    /**
     * Perform the show action for a block
     *
     * @param BlockInterface $block
     *
     * @return Response
     *
     * @throw ContentNotFoundException
     */
    public function show(BlockInterface $block)
    {
        $contentId = $block->getAttribute('contentId');
        $content = $this->contentRepository->findOneByContentId($contentId);

        if ($content) {
            $contentAttributes = $content->getAttributes();

            return $this->render(
                'OpenOrchestraDisplayBundle:Block/ConfigurableContent:show.html.twig',
                array('contentAttributes' => $contentAttributes)
            );
        }

        throw new ContentNotFoundException($contentId);
    }

    /**
     * Return block specific tags
     * 
     * @param BlockInterface $block
     * 
     * @return array
     */
    public function getTags(BlockInterface $block)
    {
        return array(
            'contentType-' . $block->getAttribute('contentTypeId'),
            'contentId-' . $block->getAttribute('contentId')
        );
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'configurable_content';
    }
}
