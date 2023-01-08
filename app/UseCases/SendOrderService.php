<?php

namespace App\UseCases;

use App\Mail\SendOrder;
use App\Models\Admin\Cart\Order\Contact;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;

class SendOrderService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Contact $contact)
    {
        $this->mailer->to(['andreii.kachanov@gmail.com', '777@8220.ru'])->send(new SendOrder($contact));
    }
}
