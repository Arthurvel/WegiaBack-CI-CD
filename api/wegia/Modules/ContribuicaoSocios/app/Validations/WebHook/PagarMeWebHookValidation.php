<?php

namespace Modules\ContribuicaoSocios\app\Validations\WebHook;

use Illuminate\Foundation\Http\FormRequest;

class PagarMeWebHookValidation extends FormRequest
{

    public function authorize(): bool
    {
        return $this->validarAssinatura();
    }

    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'type' => 'required|string|in:charge.paid,charge.pending,charge.refunded,charge.failed,order.paid,order.canceled',
            'created_at' => 'required|date',
            'data' => 'required|array',
            'data.id' => 'required|string',
            'data.amount' => 'required|integer|min:0',
            'data.status' => 'required|string',
            'data.metadata' => 'sometimes|array',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do evento é obrigatório',
            'type.required' => 'O tipo do evento é obrigatório',
            'type.in' => 'Tipo de evento inválido',
            'data.required' => 'Os dados do evento são obrigatórios',
            'data.id.required' => 'O ID da transação é obrigatório',
            'data.amount.required' => 'O valor é obrigatório',
            'data.amount.min' => 'O valor deve ser maior ou igual a zero',
        ];
    }

    private function validarAssinatura(): bool
    {
        $assinatura = $this->header('X-Hub-Signature');

        if (!$assinatura) {
            return false;
        }

        $secret = config('services.pagarme.webhook_secret');

        if (!$secret) {
            return false;
        }

        $payload = $this->getContent();
        $hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        return hash_equals($hash, $assinatura);
    }
}
