<?php

namespace App\UseCases;

use App\Mail\SendOrder;
use App\Models\Admin\Cart\Order\Contact;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;

class SendOrderService
{
    private $mailer;
    //private $dispatcher;

    public function __construct(MailerInterface $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function send(Contact $contact)
    {
        //dd($order);
        $this->mailer->to(['andreii.kachanov@gmail.com', '777@8220.ru'])->send(new SendOrder($contact));
        //$this->dispatcher->dispatch(new Registered($user));
    }

}
