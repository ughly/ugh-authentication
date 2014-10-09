<?php

namespace UghAuthentication\Controller;

use Zend\Form\FormInterface;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    /** @var FormInterface */
    private $loginForm;

    /** @var string */
    private $loginRedirectRoute = 'login-redirect-route';

    /**
     * 
     * @param FormInterface $loginForm
     */
    public function __construct(FormInterface $loginForm)
    {
        $this->loginForm = $loginForm;
    }

    /**
     * 
     * @return ViewModel|Response
     */
    public function indexAction()
    {
        if (!is_null($this->identity())) {
            return $this->redirect()->toRoute($this->loginRedirectRoute);
        }

        if ($this->getRequest()->isPost()) {
            if ($this->loginForm->isValid()) {
                return $this->redirect()->toRoute($this->loginRedirectRoute);
            }
        }

        return new ViewModel(array('loginForm' => $this->loginForm));
    }

    /**
     * 
     * @param string $loginRedirectRoute
     */
    public function setLoginRedirectRoute($loginRedirectRoute)
    {
        $this->loginRedirectRoute = $loginRedirectRoute;
    }
}
