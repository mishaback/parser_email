<?php

namespace App\Http\Controllers;

use App\Services\ImapService;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public $imap;

    public function __construct(ImapService $imap){

        $this->imap = $imap;
    }

    public function index() {

        $generator = $this->imap->dataImap();
        dd($generator);
        foreach ($generator as $value) {


        }

    }
}
