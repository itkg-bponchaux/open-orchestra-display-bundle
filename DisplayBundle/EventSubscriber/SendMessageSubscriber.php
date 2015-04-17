<?php

namespace OpenOrchestra\DisplayBundle\EventSubscriber;

use OpenOrchestra\DisplayBundle\Event\MailerEvent;
use OpenOrchestra\DisplayBundle\MailerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class SendMessageSubscriber
 */
class SendMessageSubscriber implements EventSubscriberInterface
{
    protected $messages;
    protected $mailer;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->messages = array();
        $this->mailer = $mailer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            MailerEvents::SEND_MAIL => 'addMessage',
            KernelEvents::TERMINATE => 'sendMessages',
        );
    }

    /**
     * @param MailerEvent $event
     */
    public function addMessage(MailerEvent $event)
    {
        $this->messages[] = $event->getMessage();
    }

    public function sendMessages()
    {
        foreach($this->messages as $message) {
            $this->mailer->send($message);
        }
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

}
