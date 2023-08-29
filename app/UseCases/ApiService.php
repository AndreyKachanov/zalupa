<?php

namespace App\UseCases;

use App\Models\Admin\Cart\Invoice;
use App\Models\Admin\Cart\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class ApiService
{
    private $sendOrderService;

    public function __construct(SendOrderService $sendOrderService)
    {
        $this->sendOrderService = $sendOrderService;
    }
    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return date('Y') . '-' . str_pad(Invoice::max('id') * 33, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isValidToken(string $token): bool
    {
        return ($token === 'null' || (Str::length($token) === 32 && Token::whereToken($token)->exists()));
    }

    /**
     * @param Request $request
     * @param SendOrderService $service
     * @return string
     */
    public function generateNewToken(Request $request): string
    {
        try {
            $agent = new Agent();
            $deviceVersion = $agent->version($agent->device());

            $ipAddress = $request->ip();

            $token = Token::create([
                'token' => generateToken(),
                'ip' => $ipAddress,
                'ip_info' => serialize($this->sendOrderService->getIpAddressInfo($ipAddress)),
                'browser' => (string)$agent->browser(),
                'platform' => (string)$agent->platform(),
                'device' => (string)$agent->device(),
                'device_version' => ($deviceVersion === false) ? null : $deviceVersion, // Получение версии мобильного устройства
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_robot' => $agent->isRobot()
            ]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
        return $token->token;
    }

    /**
     * @param Token $token
     * @return Invoice
     */
    public function getInvoice(Token $token): Invoice
    {
        return !$token->invoice
            ? Invoice::create([
                'bill_number' => $this->getInvoiceNumber(),
                'token_id' => $token->id
            ])
            : $token->invoice;
    }
}
