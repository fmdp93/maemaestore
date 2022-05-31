<?php

namespace App\Http\Controllers;

use App\Http\Requests\PINRequest;
use App\Http\Traits\UserTrait;
use App\Models\ConfigModel;
use Illuminate\Http\Request;

class PINController extends Controller
{
    use UserTrait;
    public function validatePin(Request $request){
        $input_pin = $request->input('pin');
        $real_pin = ConfigModel::where('name', 'pin')->first()->value;
        $response = [];
        if($input_pin == $real_pin){
            $response['valid'] = 1;
        }

        return Response()->json(json_encode($response));
    }

    public function setPinFlash(){
        $data = [];
        $this->setData($data);
        $this->setUserContent($data);
        $data['content'] = $data['user'] . '_content';
        $data['include_content'] = 'components.' . $data['user'] . '.content';
        return view('pages.pin', $data);
    }

    // public function setPinFlashCashier(){
    //     $data = [];
    //     $this->setData($data);
    //     $data['content'] = 'cashier_content';
    //     $data['include_content'] = 'components.cashier.content';
    //     return view('pages.pin', $data);
    // }

    // public function setPinFlashAdmin(){
    //     $data = [];
    //     $this->setData($data);
    //     $data['content'] = 'admin_content';
    //     $data['include_content'] = 'components.admin.content';
    //     return view('pages.pin', $data);
    // }

    private function setData(&$data){   
        $data['heading'] = 'Enter PIN';
        $data['title'] = 'Enter PIN';
        $data['initial_message'] = session('initial_message');
    }

    public function submitPin(PINRequest $request){
        $referrer = $request->input('referrer');
        $validated = $request->validated();

        return redirect(urldecode($referrer));
    }
}
