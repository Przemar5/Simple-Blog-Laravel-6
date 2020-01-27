<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMailController extends Controller
{
    private $emailReciever = 'YOUR MAIL HERE';

    /**
     * Send email from user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => [
                'required',
                'email',
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,()\@ ]+$/'
            ],
            'subject' => [
                'required',
                'between:3,511',
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,()\"\ \:\;\+\=\/\#\<\>@\[\]\{\}\-\`\+\#]+$/',
            ],
            'message' => [
                'required',
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,()\"\ \:\;\+\=\/\#\<\>@\[\]\{\}\-\`\+\#]+$/'
            ]
        ]);

        $data = [
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message')
        ];

        Mail::to($this->emailReciever)->send(new \App\Mail\ContactMail($data));

        return redirect()->route('pages.index')->with('success', 'Your email has been send succesfully.');
    }
}
