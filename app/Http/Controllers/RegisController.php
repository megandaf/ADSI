<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // validate form
        $this->validate(
            $request,
            [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'tanggal_lahir' => 'required',
                'password' => 'required|confirmed|max:255',
                'no_telepon' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:255'
            ]
        );

        //sign up
        Pelanggan::create([
            'nama_lengkap' => $request->first_name . ' ' . $request->last_name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
        ]);


        //sign In

        auth()->attempt($request->only('email', 'password'));


        //redirect to dashboard

        return redirect()->route('dashboard');
    }
}
