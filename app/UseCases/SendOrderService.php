<?php

namespace App\UseCases;

use App\Mail\SendOrder;
use App\Models\Admin\Cart\Order\Contact;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Exception;

class SendOrderService
{
    private $mailer;
    private $client;

    public function __construct(MailerInterface $mailer, Client $client)
    {
        $this->mailer = $mailer;
        $this->client = $client;
    }

    /**
     * @param Contact $contact
     * @return void
     */
    public function sendEmail(Contact $contact): void
    {
        try {
            $this->mailer->to([config('mail.to')])->send(new SendOrder($contact));
            Log::info('Order email successfully sent to ' . config('mail.to'));
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            Log::error($errorMsg);
        }
    }

    /**
     * @param Contact $contact
     * @return void
     * @throws GuzzleException
     */
    public function sendTelegram(Contact $contact): void
    {
        $sum = $contact->orders->sum(fn($item) => $item->item->price * $item->cnt);
        $url = route('admin.orders.show', $contact);
        $message = 'Заказ № ' . $contact->token->invoice->bill_number . ' с сайта ' . config('app.site_short') . ' на общую сумму ' . $sum . ' руб. ' . $url;
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
            ]);
            $responseData = json_decode($response->getBody(), true);
            if ($responseData && isset($responseData['ok']) && $responseData['ok'] === true) {
                Log::info('Message "' . $message . '" sent to telegram');
            } else {
                Log::error('Message not sent to telegram');
                //dd($responseData);
            }
        } catch (Exception $e) {
            $errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            Log::error($errorMsg);
        }
    }

    /**
     * @param string $ip
     * @return false[]
     * @throws GuzzleException
     */
    public function getIpAddressInfo(string $ipAddress): array
    {
        //$ipAddress = '82.144.223.30';
        $url = "https://ipwho.is/$ipAddress";
        try {
            $response = $this->client->request('GET', $url, [
                'objects' => 'type,city,flag,region,country,country_code',
                'output' => 'json'
            ]);
            $responseData = json_decode($response->getBody(), true);
            if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
                return [
                    'type' => $responseData['type'],
                    'city' => $responseData['city'],
                    'flag' => $responseData['flag'],
                    'region' => $responseData['region'],
                    'country' => $responseData['country'],
                    'country_code' => $responseData['country_code'],
                ];
                //Log::info('Message "' . $message . '" sent to telegram');
            } else {
                return ['success' => false];
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            //$errorMsg = sprintf("Error in %s, line %d. %s", __METHOD__, __LINE__, $e->getMessage());
            //Log::error($errorMsg);
        }
    }
}
