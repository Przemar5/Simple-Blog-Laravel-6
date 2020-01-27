<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'verified'
        ]);
    }

    /**
     * Get validation rules.
     *
     * @param string $id
     * @return array
     */
    private function getValidationRules($id = '')
    {
        return [
            'name' => [
                'required',
                'max:255',
                'string',
                'unique:users,name,'.$id,
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/'
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                'unique:users,email,'.$id,
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \@]+$/'
            ],
            'password' => [
                'required',
                'min:8',
                'string',
                'confirmed',
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \-\:\/\|\[\]\{\}]+$/'
            ]
        ];
    }

    /**
     * Display single user's profile.
     *
     * @return redirect to profile view
     */
    public function show()
    {
        $title = 'My Profile';
        $user = auth()->user();

        $data = [
            'title' => $title,
            'user' => $user
        ];

        return view('profiles.index')->with('data', $data);
    }

    /**
     * Display form for editing profile.
     *
     * @return redirect to profile view
     */
    public function edit()
    {
        $user = auth()->user();

        return view('profiles.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to profile view
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, $this->getValidationRules($user->id));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profiles.index')->with('success', 'Your profile had been updated successfully.');
    }
}
