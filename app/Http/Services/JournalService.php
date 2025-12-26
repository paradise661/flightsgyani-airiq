<?php

namespace App\Http\Services;

use App\Models\Journal;

class JournalService
{

    public function DrCrCheck($request): bool
    {
        // dd($request->toArray());
        $arrCount = count($request->account_head);

        $sum_dr = 0.00;
        $sum_cr = 0.00;

        for ($i = 0; $i < $arrCount; $i++) {
            if ($request->type[$i] == 'dr') $sum_dr += $request->amount[$i];

        }
        for ($i = 0; $i < $arrCount; $i++) {
            if ($request->type[$i] == 'cr') $sum_cr += $request->amount[$i];
        }
        if ($sum_dr != $sum_cr) return false;
        else return true;
    }

}
