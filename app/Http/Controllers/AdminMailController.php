<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\MailHistory;

class AdminMailController extends Controller
{

    public function index()
    {
        $mails = MailHistory::orderBy('id', 'desc')->paginate(10);
        return view('admin.mail.index',compact('mails',),[
            'title' => 'Lịch sử gửi mail'
        ]);
    }
}
