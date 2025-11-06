<?php

namespace App\Modules;

use App\Models\Modules\WhatsappRecord;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Whapify
{
    public function __construct() {

    }
    /**
     * Get All Whapify Account
     * 
     * @param limit = limit per page
     * @param page = current page
     * 
     * @return object
     */
    public static function getAccounts($limit = 10, $page = 1)
    {
        $client = new Client();

        $response = $client->get(config('whapify.base_url') . 'get/wa.accounts?secret=' . config('whapify.secret') . '&limit=' . $limit . '&page=' . $page);
        $body = json_decode($response->getBody(), true);

        if ($body['status'] == "404") {
            return collect([
                "status" => "backup_sent"
            ]);
        }

        return collect($body['data']);
    }

    /**
     * Send a single chat to a number
     * 
     * @param recipient = number phone of recipient (6285356789333)
     * @param message = your message
     * @param type = text, media, or document default text
     * 
     * @return object
     */
    public static function sendSingleChat($recipient, $message, $type = null)
    {
        $client = new Client();

        $params = [];
        $params['form_params'] = [
            "secret" => config('whapify.secret'),
            "account" => config('whapify.account'),
            "recipient" => $recipient,
            "type" => $type ?? config('whapify.type'),
            "message" => $message
        ];

        $response = $client->post(config('whapify.base_url') . 'send/whatsapp', $params);
        $body = json_decode($response->getBody(), true);

        if(config('whapify.save_to_database')){
            $data = collect($body['data']);

            WhatsappRecord::create([
                "message_id" => $data['messageId'],
                "penerima" => $recipient,
                "pesan" => $message
            ]);
        }

        if ($body['data'] == false)
            return null;

        return collect($body['data']);
    }

    /**
     * Send a single chat to a number
     * 
     * @param recipient = number phone of recipient (6285356789333)
     * @param message = your message
     * @param expired = time this otp expired on second
     * 
     * @return object
     */
    public static function sendOtp($recipient, $message = "Your OTP is {{otp}}", $expired = 300000)
    {
        $client = new Client();

        $params = [];
        $params['form_params'] = [
            "secret" => config('whapify.secret'),
            "account" => config('whapify.account'),
            "phone" => $recipient,
            "type" => "whatsapp",
            "message" => $message,
            "expire" => $expired
        ];

        $response = $client->post(config('whapify.base_url') . 'send/otp', $params);
        $body = json_decode($response->getBody(), true);

        if ($body['data'] == false)
            return null;

        return collect($body['data']);
    }

    /**
     * Get a single chat to a number
     * 
     * @param id = whapify messageId
     * @param type = sent or recieved default sent
     * 
     * @return object
     */
    public static function verifyOtp($otp)
    {
        $client = new Client();

        $response = $client->get(config('whapify.base_url') . 'get/otp?secret=' . config('whapify.secret') . '&otp=' . $otp);
        $body = json_decode($response->getBody(), true);

        if ($body['status'] == "404") {
            return collect([
                "status" => "backup_sent"
            ]);
        }

        return collect($body['data']);
    }

    /**
     * Get a single chat to a number
     * 
     * @param id = whapify messageId
     * @param type = sent or recieved default sent
     * 
     * @return object
     */
    public static function getSingleChat($id, $type = 'sent')
    {
        $client = new Client();

        $response = $client->get(config('whapify.base_url') . 'get/wa.message?secret=' . config('whapify.secret') . '&type=' . $type . '&id=' . $id);
        $body = json_decode($response->getBody(), true);

        if ($body['status'] == "404") {
            return collect([
                "status" => "backup_sent"
            ]);
        }

        return collect($body['data']);
    }
}
