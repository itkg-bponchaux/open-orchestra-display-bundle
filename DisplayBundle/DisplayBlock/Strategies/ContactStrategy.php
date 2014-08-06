<?php

namespace PHPOrchestra\DisplayBundle\DisplayBlock\Strategies;

use PHPOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use PHPOrchestra\DisplayBundle\Form\Type\ContactType;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactStrategy
 */
class ContactStrategy extends AbstractStrategy
{
    protected $formFactory;

    /**
     * @param FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
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
        return DisplayBlockInterface::CONTACT == $block->getComponent();
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
        $form = $this->formFactory->create(new ContactType());

        return $this->render(
            'PHPOrchestraDisplayBundle:Block/Contact:show.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }

}
