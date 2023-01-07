<?php

namespace App\Mail;

use App\Models\Admin\Cart\Order\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOrder extends Mailable
{
    use SerializesModels;

    public $contact;
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        //$siteShortName = config('app.name');
        $siteShortName = parse_url(config('app.url'))['host'];
        return $this->view('emails.send_orders', [
            'contact' => $this->contact
        ])->from('admin@10013.ru')->subject("Заказ с сайта $siteShortName");
    }
}
