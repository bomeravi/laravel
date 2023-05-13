<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessage;
use App\Models\MessageHistory;
use Illuminate\Http\Request;
use App\Mail\Message as MessageMail;
use Illuminate\Support\Facades\Mail;

class MessagesController extends Controller
{
    //
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $messages = MessageHistory::where('title', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $messages = MessageHistory::latest()->paginate($perPage);
        }


        return view('admin.messages.index', compact('messages'));
    }


    public function create(){
        return view('admin.messages.create');
    }

    public function store(Request $request) {
        $this->validate($request,  [
            'title' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'subject' => 'required|string|max:200',
            'message' => 'required|string'
            ]);
        $requestData = $request->all();
        $message = MessageHistory::create($requestData);

        dispatch(new SendMessage($message));

        return redirect('admin/messages')->with('flash_message', 'Message added to Queue');
    }

}
