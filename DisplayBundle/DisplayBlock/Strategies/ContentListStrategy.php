<?php

namespace PHPOrchestra\DisplayBundle\DisplayBlock\Strategies;

use PHPOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use PHPOrchestra\DisplayBundle\Routing\PhpOrchestraRouter;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use PHPOrchestra\ModelBundle\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContentListStrategy
 */
class ContentListStrategy extends AbstractStrategy
{
    protected $contentRepository;
    protected $router;
    protected $request;

    /**
     * @param ContentRepository  $contentRepository
     * @param PhpOrchestraRouter $router
     */
    public function __construct(ContentRepository $contentRepository, PhpOrchestraRouter $router)
    {
        $this->contentRepository = $contentRepository;
        $this->router = $router;
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
        return DisplayBlockInterface::CONTENT_LIST == $block->getComponent();
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
        $attributes = $block->getAttributes();
        $contents = $this->contentRepository->findByContentType($attributes['contentType']);

        if (array_key_exists('url', $attributes)) {
            return $this->render(
                'PHPOrchestraDisplayBundle:Block/ContentList:show.html.twig',
                array(
                    'contents' => $contents,
                    'class' => array_key_exists('class', $attributes)? $attributes['class']: '',
                    'id' => array_key_exists('id', $attributes)? $attributes['id']: '',
                    'url' => $this->router->generate($attributes['url'])
                )
            );
        } else {
            return $this->render(
                'PHPOrchestraDisplayBundle:Block/ContentList:show.html.twig',
                array(
                    'contents' => $contents,
                    'class' => array_key_exists('class', $attributes)? $attributes['class']: '',
                    'id' => array_key_exists('id', $attributes)? $attributes['id']: '',
                )
            );
        }
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'content_list';
    }
}
