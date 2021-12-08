<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Services\ImapService;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public $imap;

    public function __construct(ImapService $imap)
    {

        $this->imap = $imap;
    }

    public function index()
    {
        $lastUid = Email::first();

        $generator = $this->imap->dataImap();
        foreach ($generator as $key => $value) {

            if ($lastUid && $lastUid == $value['uid']) {

                $new = new Email();
                $new->uid = $value['uid'];
                $new->save();
                break;

            }


        }


    }
}
