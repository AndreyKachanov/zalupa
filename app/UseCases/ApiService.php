<?php

namespace App\UseCases;

use App\Models\Admin\Cart\Invoice;
use App\Models\Admin\Cart\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiService
{
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
     * @return string
     */
    public function generateNewToken(Request $request): string
    {
        $token = Token::create(['token' => generateToken(), 'ip' => $request->ip()]);
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
