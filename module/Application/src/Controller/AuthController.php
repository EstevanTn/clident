<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use Application\Form\LoginForm;
use Application\Model\UsuarioTable;
use Application\Model\Entity\Enviroment;
//use Zend\Authentication\AuthenticationService;
//use Zend\Session\SessionManager;
//use Zend\Form\View\Helper\FormLabel;


class AuthController extends AbstractActionController {
    
    var $table;
    
    public function __construct(UsuarioTable $table){
        $this->table = $table;
    }
        
    public function indexAction(){
        $this->layout('layout/empty');
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }
        $form = new LoginForm();
        $isLoginError = false;
        $message = '';
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $response = $this->table->autenticate($data['username'], $data['password']);
                $isLoginError = !$response['IsSuccess'];
                $message = $response['Message']; 
                if(!$isLoginError){
                    $this->redirect()->toRoute('home');
                }            
            }else{
                $isLoginError = true;
            }
        }
        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl,
            'messageError' => $message,
        ]);
    }

    public function loginAction()
    {
        $this->layout('layout/empty');
        // Retrieve the redirect URL (if passed). We will redirect the user to this
        // URL after successfull login.
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }
        
        // Check if we do not have users in database at all. If so, create 
        // the 'Admin' user.
        //$this->userManager->createAdminUserIfNotExists();
        
        // Create login form
        $form = new LoginForm(); 
        //$form->get('redirect_url')->setValue($redirectUrl);

                
        // Store login status.
        $isLoginError = false;
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            //return new JsonModel(get_object_vars($this->authService));
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                // Perform login attempt.
                $result = $this->login($data['username'], 
                    $data['password'], isset($data['remember_me'])?$data['remember_me']:false);
                
                // Check result.
                if ($result->getCode() == Result::SUCCESS) {
                    
                    // Get redirect URL.
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');
                    
                    if (!empty($redirectUrl)) {
                        // The below check is to prevent possible redirect attack 
                        // (if someone tries to redirect user to another domain).
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || $uri->getHost()!=null)
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                    }

                    // If redirect URL is provided, redirect the user to that URL;
                    // otherwise redirect to Home page.
                    if(empty($redirectUrl)) {
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    $isLoginError = true;
                }                
            } else {
                $isLoginError = true;
            }           
        } 
        
        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function logoutAction() 
    {   
        session_destroy();
        unset($_COOKIE[Enviroment::NAME_COOKIE]);
        setcookie(Enviroment::NAME_COOKIE, '', time()-5000, '/');
        return $this->redirect()->toRoute('auth');
    }
    
    public function login($email, $password, $rememberMe)
    {
        // Check if user has already logged in. If so, do not allow to log in
        // twice.
        if ($this->authService->getIdentity()!=null) {
            throw new \Exception('Already logged in');
        }
        
        // Authenticate with login/password.
        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setUsername($email);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();
        
        // If user wants to "remember him", we will make session to expire in
        // one month. By default session expires in 1 hour (as specified in our
        // config/global.php file).
        if ($result->getCode()==Result::SUCCESS && $rememberMe) {
            // Session cookie will expire in 1 month (30 days).
            $this->sessionManager->rememberMe(60*60*24*30);
        }
        
        return $result;
    }
    
    public function logout()
    {
        // Allow to log out only when user is logged in.
        if ($this->authService->getIdentity()==null) {
            throw new \Exception('The user is not logged in');
        }
        
        // Remove identity from session.
        $this->authService->clearIdentity();
    }

}