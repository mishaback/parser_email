<?php

namespace App\Services;

use Illuminate\Http\Request;
use GuzzleHttp\TransferStats;

class CrmService
{

    public function justDoIt($EmailList)
    {
        $postData['uuid'] = 'c9a98bfd-8782-42ca-b28c-5619d07f6024';

        if (isset($postData['phone'])) {
            $postData['phone'] = preg_replace('/ |-|_|\(|\)/', '', $postData['phone']);
        }
            $url = 'https://crm.international.onl/api/v1/webform?' . http_build_query($postData);
            $client = new \GuzzleHttp\Client();

            try {
                $client->request('POST', $url, [
                    'verify' => false,
                    'on_stats' => function (TransferStats $stats) use (&$effectiveURL, &$statusCode, &$test) {
                        $effectiveURL = (string)$stats->getEffectiveUri();
                        $test = $stats->getResponse();
                        if ($stats->hasResponse()) {
                            $statusCode = $stats->getResponse()->getStatusCode();
                        }
                    },
                ]);
            } catch (\Exception $exception) {
                $messageCurl = $exception->getMessage();
                $array = explode('response:', $messageCurl);
                $text = 'Помилка відправки форми на сайті ' . env('APP_NAME') . ': ' . PHP_EOL;

                if (isset($array[1])) {
                    $statusCode = $exception->getResponse()->getStatusCode();
                    $json = json_decode($array[1]);
                    $text .= 'Помилка: ' . $json->message . PHP_EOL . "Статус помилки: $statusCode" . PHP_EOL . PHP_EOL;
                } else {
                    $text .= $messageCurl . PHP_EOL;
                }
                $text .= "Дані з форми: " . PHP_EOL . '<i>' . json_encode($postData) . '</i>';
                $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));
                $telegram->setAsyncRequest(true)
                    ->sendMessage([
                        'chat_id' => env('TELEGRAM_CHAT_ID'),
                        'text' => $text,
                        'parse_mode' => 'html'
                    ]);
            }

            return response()->json([
                'status' => true,
                'url' => $effectiveURL
            ]);
        }
}
