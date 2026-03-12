<?php

namespace App\Http\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\PayTechService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayTechWebhookController extends Controller
{
    public function __construct(private PayTechService $payTechService) {}

    /**
     * Traite le webhook PayTech (IPN).
     * Route exclue du CSRF — seule source de vérité pour confirmer un paiement.
     */
    public function handle(Request $request): Response
    {
        $this->payTechService->traiterWebhook($request);

        return response('OK', 200);
    }
}
