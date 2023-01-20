<?php

namespace App\UseCases;

use App\Mail\SendOrder;
use App\Models\Admin\Cart\Order\Contact;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class SendOrderService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Contact $contact)
    {
        try {
            $this->mailer->to(['andreii.kachanov@gmail.com'])->send(new SendOrder($contact));
        } catch (TransportExceptionInterface $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }
}
