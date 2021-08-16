<?php
/**
 * ErrorController - The default error controller class
 *
 * @author
 * @version
 */

/** BaseController */
Zend_Loader::loadClass('BaseController');

class ErrorController extends BaseController
{

    /**
     * This action handles
     *    - Application errors
     *    - Errors in the controller chain arising from missing
     *      controller classes and/or action methods
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        // get our errors configuration
        $errorsConfig = new Zend_Config_Xml(Zend_Registry::get('config')->errorsConfig, 'production');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $errorCode = '404';
                break;
            default:
                // application error; display error page, but don't change
                // status code
                $errorCode = $errors->exception->getCode();
                break;
        }

        $codeTag = 'code' . $errorCode;

        if (!isset($errorsConfig->errors->$codeTag))
            $codeTag = 'default';

        $this->getResponse()->setRawHeader('HTTP/1.1 ' . $errorCode . ' ' . $errorsConfig->errors->$codeTag->title);
        $this->view->errorCode = $errorCode;
        $this->view->errorTitle = $errorCode . ' ' . $errorsConfig->errors->$codeTag->title;
        $this->view->errorMessage = $errorsConfig->errors->$codeTag->description;
        $this->view->errorTrace = str_replace("'", '&apos;', $errors->exception);
    }
}
