<?php

namespace App\Services;

use Ddeboer\Imap\Server;
use Ddeboer\Imap\Search\Date\Since;

class ImapService
{


    public function dataImap()
    {
        $server = new Server(env('IMAP_HOST'));
        $connection = $server->authenticate(env('IMAP_USERNAME'), env('IMAP_PASSWORD'));
        $mailbox = $connection->getMailbox('INBOX');
        $messages = $messages = $mailbox->getMessages(
            null, \ SORTDATE,
            true
        );

        foreach ($messages as $message) {
            if ($message->getSubject() == "New Message") {
                $bodyMessage = str_replace('&nbsp;', '', strip_tags($message->getBodyHtml()));
                preg_match("/Message:(.*?)Date, time：(.*?)Name：(.*?)Title:(.*?)Mobile phone:(.*?)Fix Phone:(.*?)Email:(.*)/", $bodyMessage, $matches);
                $values['uid'] = $message->getId();
                $values['name'] = trim($matches[3]);
                $values['phone'] = trim($matches[5]);
                $values['email'] = trim($matches[7]);

                yield $values;
            }
        }

    }

}
