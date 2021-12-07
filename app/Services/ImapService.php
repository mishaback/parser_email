<?php

namespace App\Services;

use Webklex\IMAP\Facades\Client;

class ImapService
{


    public function dataImap()
    {
        $client = Client::account('default');
        $client->connect();
        $folder = $client->getFolderByPath('INBOX');
        $messages = $folder->query()->setFetchBody(false)->all()->get();
        $messages =
            foreach ($messages as $message) {
                $header = $message->getHeader();
                if ($message->getSubject() == 'New Message') {
                    $bodyMessage =  str_replace('&nbsp;',' ', strip_tags($message->getHTMLBody()));

                    preg_match("/Message:(.*?)Date, time：(.*?)Name：(.*?)Title:(.*?)Mobile phone:(.*?)Fix Phone:(.*?)Email:(.*)/", $bodyMessage, $matches);
                        dd($matches);
                        $values['name'] = trim($matches [3]);
                        $values['email'] = trim($matches [7]);
                        $values['email'] = trim($matches [5]);

                    yield $values;

                }
            }
    }

}
