<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();
          
        $this->setAttribute('method', 'post');
         
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Usuario',
            ),
            'attributes' => array(
                'class' =>  'form-control',
                'placeholder'   =>  'Ingrese usuario',
                'required' => 'required'
            )
        ));
         
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'class' =>  'form-control',
                'placeholder'   =>  'Ingrese contraseña',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Button',
            'options' => array(
                'label' => '<i class=\'fa fa-external-link\'></i> Entrar',
                'label_options' => array(
                    'disable_html_escape' => true,
                )
            ),
            'attributes' => array(
                'class' => 'btn btn-block bg-navy btn-flat',
                'type'  => 'submit'
            )
        ));
          
        $this->setInputFilter($this->createInputFilter());
    }
     
    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
 
        //username
        $username = new InputFilter\Input('username');
        $username->setRequired(true);
        $inputFilter->add($username);
         
        //password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        $inputFilter->add($password);
 
        return $inputFilter;
    }
}