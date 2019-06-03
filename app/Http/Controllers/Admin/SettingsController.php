<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller {

    /**
     * Show the notification settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications() {
        return view('admin.settings.notification');
    }

    public function sociality() {
        return view('admin.settings.sociality');
    }

    public function billing() {
        return view('admin.settings.billing');
    }
    
    public function pagination() {
        return view('admin.settings.pagination');
    }

    public function firewall() {
        return view('admin.settings.firewall');
    }

    public function store(Request $request) {
        $data = $request->all();
        foreach ($data as $key => $value) {
            if ($key == '_token') {
                continue;
            }
            $key = str_replace('_', '.', $key);
            \Setting::set($key, $value);
        }
        \Setting::save();
        return $this->redirectSuccess('Your changes has been updated successfully.');
    }

    public function email(Request $request) {
        \Illuminate\Support\Facades\Mail::raw($request->message, function ($message) use ($request) {
            $message->subject($request->subject);
            $message->to($request->to);
        });
        if (empty(\Illuminate\Support\Facades\Mail::failures())) {
            return $this->redirectSuccess('Your email has been sended successfully.');
        } else {
            return $this->redirectWithError('Email letter was not sent');
        }
    }

    protected function redirectSuccess($message) {
        return redirect()->back()->with('message', [
                    'type' => 'success',
                    'message' => $message
        ]);
    }

    protected function redirectWithError($message) {
        return redirect()->back()->with('message', [
                    'type' => 'danger',
                    'message' => $message
        ]);
    }

}
