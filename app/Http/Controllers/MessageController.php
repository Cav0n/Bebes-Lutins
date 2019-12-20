<?php

namespace App\Http\Controllers;

use App\Message;
use App\Mail\MessageNotificationSender;
use App\Mail\MessageNotificationAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.customers.messages')
                ->withMessages(Message::where('id', '!=', null)->orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.statics.contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $captcha = $request['captcha'];

        if(!$captcha){
            $response['message'] = "Veuillez vérifier que vous n'êtes pas un robot !";
            $response['code'] = '300';

            return response()->json($response, $response['code']);
        } else {
            $secretKey = "6Ldj9p4UAAAAAO-lFqcTg5irY1504Y_NCU2S01js";
            $ip = $_SERVER['REMOTE_ADDR'];

            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
            $response_captcha = file_get_contents($url);
            $responseKeys_captcha = json_decode($response_captcha, true);

            // should return JSON with success as true
            if ($responseKeys_captcha["success"]) {
                $request->validate([
                    'contact-name' => 'required',
                    'contact-email' => 'required',
                    'contact-message' => 'required'
                ]);

                $message = new Message();
                $message->senderName = $request['contact-name'];
                $message->senderEmail = $request['contact-email'];
                $message->message = $request['contact-message'];
                $message->save();

                Mail::to("contact@bebes-lutins.fr")->send(new MessageNotificationAdmin($message));
                Mail::to($message->senderEmail)->send(new MessageNotificationSender($message));

                $response['message'] = "Message envoyé avec succés !";
                $response['code'] = '200';

                return response()->json($response, $response['code']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
