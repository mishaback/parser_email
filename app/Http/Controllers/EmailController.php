<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Services\ImapService;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $imapService;

    public function __construct(ImapService $imapService)
    {
        $this->imapService = $imapService;
    }

    public function index()
    {
        $lastSaveUid = Email::first();
        $generator = $this->imapService->dataImap();
        $EmailList = array();
        foreach ($generator as $value) {
            if ($generator->key() === 0) {
                if ($lastSaveUid != null) {
                    $firstUid = Email::first();
                    $firstUid->uid = $value['uid'];
                    $firstUid->update();
                } else {
                    $newEmail = new Email();
                    $newEmail->uid = $value['uid'];
                    $newEmail->save();
                }

                if ($lastSaveUid && $lastSaveUid->uid == $value['uid']) {
                    break;
                }
            }
            $EmailList[$generator->key()] = $value;


        }
        dd($EmailList);
    }
}
