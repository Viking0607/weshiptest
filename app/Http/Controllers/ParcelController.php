<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Parcel;
use App\User;

class ParcelController extends Controller
{
    /*
        Check prihibited items
    */
    public function checkProhibited()
    {
        return view('prohibitions/check');
    }

    /*
        Check tracking number
    */
    public function checkTracking(Request $request)
    {
        $trackNumber = trim($request->input('tracking'));
        $countTrackNumber =  Parcel::where('track', $trackNumber)->count();
        if ($countTrackNumber == 1) {
              return redirect('/register_prohibited/'.$trackNumber);
        }
        else {
            $request->session()->flash('message.level', "danger");
            $request->session()->flash('message.content', "Данный идентификатор не найден!");

            return back()->withInput();
        }
    }

    /*
        Registration prihibited items
    */
    public function registerProhibited($trackNumber)
    {
        try {
            $parcel = Parcel::where('track', $trackNumber)->get()->first();
            $user = $parcel->user()->get()->first();

            return view('prohibitions/registration', ['parcel' => $parcel, 'user'=>$user]);
        } catch (Exception $e) {

        }
    }
    /*
        Save prohibited items
    */

    public function registerProhibitedForm(Request $request)
    {
        $inputData = $request->only('user', 'weight', 'parcel');
        $firstLetterParcel = $inputData['parcel'][0];
        var_dump($firstLetterParcel);exit;
        $parcel = new Parcel();
        $parcel->user_id = $inputData['user'];
        $parcel->weight = $inputData['weight'];
        $parcel->track = "N/a";
        $parcel->shop = "See detail parcel";
        // Проверяем тип посылки и на основе этого формируем комментарий

    }

}
