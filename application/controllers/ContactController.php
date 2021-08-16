<?php
/** BaseController */
Zend_Loader::loadClass('BaseController');

class ContactController extends BaseController
{

    public function indexAction()
    {
        Zend_Loader::loadClass('Zend_Form');
        Zend_Loader::loadClass('Zend_Mail');

        // we use this a lot here, so assign it to a variable
        $config = Zend_Registry::get('config');

        // get our forms configuration
        $formsConfig = new Zend_Config_Xml($config->formsConfig, 'production');

        $form = new Zend_Form($formsConfig->contact);

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $values = $form->getValues();

                $datetime   = date('M d Y H:i:s');
                $ipAddress  = getenv('REMOTE_ADDR');
                $browser    = getenv('HTTP_USER_AGENT');

                $this->view->name       = $values['name'];
                $this->view->email      = $values['email'];
                $this->view->url        = $values['url'];
                $this->view->comment    = $values['comment'];
                $this->view->datetime   = $datetime;
                $this->view->ipAddress  = $ipAddress;
                $this->view->browser    = $browser;

                $message = $this->view->render('contact/emailMessage.xsl');

                $mail = new Zend_Mail();
                $mail->setFrom($config->email->from->address, $config->email->from->name)
                     ->addTo($config->email->contact->address, $config->email->contact->name)
                     ->setSubject('NEW WEB CONTACT')
                     ->setBodyText($message)
                     ->send();

                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->goto('sent', 'contact', null);
            } else {
                echo "Invalid!";
            }
        }

        $domForm        = $this->view->dom->createElement('contactForm');
        $domFormCdata   = $this->view->dom->createCDATASection($form->render($this->view));
        $domForm->appendChild($domFormCdata);
        
        $this->view->dom->appendChild($domForm);
    }

    public function sentAction()
    {
    }
}
