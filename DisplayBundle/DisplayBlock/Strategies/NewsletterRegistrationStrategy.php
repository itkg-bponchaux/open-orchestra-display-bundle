<?php

namespace OpenOrchestra\DisplayBundle\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\Event\MailerEvent;
use OpenOrchestra\DisplayBundle\Form\Type\ContactType;
use OpenOrchestra\DisplayBundle\MailerEvents;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class NewsletterRegistrationStrategy
 */
class NewsletterRegistrationStrategy extends AbstractStrategy
{
    const NEWSLETTER_REGISTRATION = 'newsletter_registration';

    protected $formFactory;
    protected $request;
    protected $dispatcher;

    /**
     * @param FormFactory              $formFactory
     * @param RequestStack             $requestStack
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        FormFactory $formFactory,
        RequestStack $requestStack,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getMasterRequest();
        $this->dispatcher = $dispatcher;
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
        return self::NEWSLETTER_REGISTRATION == $block->getComponent();
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
        return $this->render('OpenOrchestraDisplayBundle:Block/NewsletterRegistration:show.html.twig', array(
            'id' => $block->getId(),
            'class' => $block->getClass(),
        ));
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'newsletter_registration';
    }
}
