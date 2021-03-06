<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Mail;
use App\Libraries\SuperGlobal;

class MainController extends Controller
{
    private $global;

    public function __construct()
    {
        $this->global = new SuperGlobal();
    }

    public function index()
    {
        $form = new Form();
        $form->startForm('POST', 'main/send')
            ->startDiv(['class' => 'row'])
            ->startDiv(['class' => 'col-md-6 mb-2'])
            ->addInput('text', 'firstname', ['class' => 'form-control shadow-box', 'id' => 'firstname', 'placeholder' => 'Firstname'])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6 mb-2'])
            ->addInput('text', 'lastname', ['class' => 'form-control shadow-box', 'id' => 'lastname', 'placeholder' => 'Lastname'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'row mt-1'])
            ->startDiv(['class' => 'col-md-12 mb-2'])
            ->addInput('email', 'email', ['class' => 'form-control shadow-box', 'id' => 'email', 'placeholder' => 'Email'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'row mt-1'])
            ->startDiv(['class' => 'col-md-12 mb-2'])
            ->addTextarea('message', 'message', ['class' => 'form-control shadow-box', 'id' => 'message', 'placeholder' => 'Enter your message'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'col-12 mt-3'])
            ->addBouton('Send', ['class' => 'bnt btn-outline-success btn-sm'])
            ->endDiv()
            ->endForm();
        $this->render('main/index', ['visitorForm' => $form->create()], 'default');
    }

    public function send()
    {
        if (Form::validate($this->global->get_POST(), ['firstname', 'lastname', 'message', 'email'])) {
            $firstname = strip_tags($this->global->get_POST('firstname'));
            $lastname = strip_tags($this->global->get_POST('lastname'));
            $email = strip_tags($this->global->get_POST('email'));
            $message = strip_tags($this->global->get_POST('message'));

            $body = '
      <p>Vous avez une nouvelle demande d\'information</p>
       <p>Nom: ' . $firstname . ' ' . $lastname . '</p>
       <p>Email : ' . $email . '</p>
       <p>Message : ' . $message . '</p>
     ';

            $mail = new Mail();
            $mail->send($body);
        }
    }
}
