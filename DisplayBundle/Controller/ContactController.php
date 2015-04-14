<?php

namespace OpenOrchestra\DisplayBundle\Controller;

use OpenOrchestra\DisplayBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;

/**
 * Class ContactController
 */
class ContactController extends Controller
{
    /**
     * Function send a email
     *
     * @param Request $request
     *
     * @Config\Route("/contact/send", name="open_orchestra_display_contact_send")
     * @Config\Method({"POST"})
     *
     * @return RedirectResponse
     */
    public function contactMailSendAction(Request $request)
    {
        var_dump($request->getMethod());
        var_dump($_POST);
        var_dump($_GET);
        var_dump($request->get('Contact'));
        $messageSendEmail = "tot"; 
        // $form = $this->createForm(new ContactType());

        // $form->handleRequest($request);
        // if ($form->isValid()) {
        //     $formData = $form->getData();
        //     //send alert message to webmaster
        //     $messageToAdmin = \Swift_Message::newInstance()
        //         ->setSubject($formData['subject'])
        //         ->setFrom($formData['email'])
        //         ->setTo($formData['recipient'])
        //         ->setBody(
        //             $this->renderView(
        //                 'OpenOrchestraDisplayBundle:Block/Email:show_admin.txt.twig',
        //                 array(
        //                     'name' => $formData['name'],
        //                     'message' => $formData['message'],
        //                     'mail' => $formData['email'],
        //                 )
        //             )
        //         );
        //     $this->get('mailer')->send($messageToAdmin);

        //     //send confirm e-mail for the user
        //     $messageToUser = \Swift_Message::newInstance()
        //         ->setSubject($this->get('translator')->trans('open_orchestra_display.contact.contact_received'))
        //         ->setFrom($formData['recipient'])
        //         ->setTo($formData['email'])
        //         ->setBody(
        //             $this->renderView(
        //                 'OpenOrchestraDisplayBundle:Block/Email:show_user.txt.twig',
        //                 array('signature' => $formData['signature'])
        //             )
        //         );
        //     $this->get('mailer')->send($messageToUser);

        //     $messageSendEmail = $this->get('translator')->trans('open_orchestra_display.contact.send_message_ok');
        // } else {
        //     $messageSendEmail = $this->get('translator')->trans('open_orchestra_display.contact.send_message_ko');
        // }

        return $this->render('OpenOrchestraDisplayBundle:Block/Email:sendEmailMessage.html.twig', array('messageSendEmail' => $messageSendEmail));
    }
}
