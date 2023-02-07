<?php

namespace App\UseCases;

use App\Mail\SendOrder;
use App\Models\Admin\Cart\Order\Contact;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use GuzzleHttp\Client;

class SendOrderService
{
    private $mailer;
    private $client;

    public function __construct(MailerInterface $mailer, Client $client)
    {
        $this->mailer = $mailer;
        $this->client = $client;
    }

    public function send(Contact $contact)
    {
        try {
            $this->mailer->to([config('mail.to')])->send(new SendOrder($contact));
        } catch (TransportExceptionInterface $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }

    public function sendTelegramm(Contact $contact)
    {
        $sum = $contact->orders->sum(fn($item) => $item->item->price * $item->cnt);
        $url = route('admin.orders.show', $contact);
        $message = 'Новый заказ с сайта ' . config('app.site_short') .  ' на общую сумму ' . $sum . ' руб. ' . $url;

        $chatId = config('app.telegram_chat_id');
        $botToken = config('app.telegram_bot_token');
        $url = "https://api.telegram.org/bot$botToken/sendMessage";
        $query = [
            'chat_id' => $chatId,
            'text'    => $message,
        ];

        try {
            $response = $this->client->request('GET', $url, [
                'delay' => 1000,
                'query' => $query,
            ])->getBody()->getContents();
            //$json = json_decode($response, true);
            //dd($json);
        } catch (GuzzleException $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            throw new HttpResponseException(response($errorMsg, 500));
        }
    }
}
