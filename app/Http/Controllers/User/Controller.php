<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function banks()
    {
        return $banks = [
            'Nepal Rastra Bank',
            'Siddhartha Bank Limited',
            'Kumari Bank Limited',
            'Rastriya Banijya Bank Limited',
            'Nepal Bank',
            'Agriculture Development Bank Limited',
            'Nabil Bank Limited',
            'Nepal Investment Bank Limited',
            'Standard Chartered Bank Nepal Limited',
            'Himalayan Bank Limited',
            'Nepal SBI Bank Limited',
            'Nepal Bangladesh Bank Limited',
            'Everest Bank Limited',
            'Prabhu Bank Limited',
            'Bank of Kathmandu Limited',
            'Nepal Credit and Commerce Bank Limited',
            'Global IME Bank Limited',
            'Citizens Bank International Limited',
            'Prime Commercial Bank Limited',
            'Sunrise Bank Limited',
            'NMB Bank Limited',
            'NIC Asia Bank Limited',
            'Machhapuchhre Bank Limited',
            'Civil Bank Limited',
            'Century Bank Limited',
            'Sanima Bank Limited',
            'Laxmi Bank Limited',
            'Janata Bank Nepal Limited',
            'Mega Bank Nepal Limited',


        ];
    }

}
