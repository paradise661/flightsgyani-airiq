<?php

namespace App\Http\Requests;

use App\Models\InternationalFlight\SearchFlight;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BookingFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        return [
            'confullname' => 'required',
            // 'confirstname' => 'required',
            // 'conlastname' => 'required',
            'conphone' => 'required',
            'conemail' => 'required|email',
            'adttitle.*' => 'required_if:adult,1',
            'adtfirstname.*' => 'required_if:adult,1',
            'adtlastname.*' => 'required_if:adult,1',
            'adtgender.*' => 'required_if:adult,1',
            'adtdob.*' => 'required_if:adult,1',
            'adtnation.*' => 'required_if:adult,1',
            'adtpassport.*' => 'required_if:adult,1',
            'adtpassportexpiry.*' => 'required_if:adult,1|date',
            'adtpassportcountry.*' => 'required_if:adult,1',
            'chdtitle.*' => 'required_if:child,1',
            'chdfirstname.*' => 'required_if:child,1',
            'chdlastname.*' => 'required_if:child,1',
            'chdgender.*' => 'required_if:child,1',
            'chddob.*' => 'required_if:child,1',
            'chdnationality.*' => 'required_if:child,1',
            'chdpassport.*' => 'required_if:child,1',
            'chdpassexpire.*' => 'required_if:child,1',
            'chdpassnation.*' => 'required_if:child,1',
            'inftitle.*' => 'required_if:infant,1',
            'inffirstname.*' => 'required_if:infant,1',
            'inflastname.*' => 'required_if:infant,1',
            'infgender.*' => 'required_if:infant,1',
            'infdob.*' => 'required_if:infant,1',
            'infnation.*' => 'required_if:infant,1',
            'infpassport.*' => 'required_if:infant,1',
            'infpassexpire.*' => 'required_if:infant,1',
            'infpassnation.*' => 'required_if:infant,1'
        ];
    }

    public function messages()
    {
        return [
            'confullname.required' => 'Provide Contact Full Name.',
            // 'confirstname.required' => 'Provide Contact First Name.',
            // 'conlastname.required' => 'Provide Contact Last Name.',
            'conphone.required' => 'Provide Contact Number.',
            'conemail.required' => 'Provide Contact Email.',
            'adttitle.*.required_if' => 'Provide Passenger Title.',
            'adtfirstname.*.required_if' => 'Provide Passenger First Name.',
            'adtlastname.*.required_if' => 'Provide Passenger Last Name.',
            'adtgender.*.required_if' => 'Provide Passenger Gender.',
            'adtdob.*.required_if' => 'Provide Passenger DOB.',
            'adtnation.*.required_if' => 'Select Passenger Nationality.',
            'adtpassport.*.required_if' => 'Provide Passenger Passport.',
            'adtpassportexpiry.*.required_if' => 'Provide Passenger Passport Expiry Date.',
            'adtpassportexpiry.*.after' => 'Passport validity must be after six months of flight date.',
            'adtpassportcountry.*.required_if' => 'Provide Passenger Passport Issuing Country.',
            'chdtitle.*.required_if' => 'Provide Passenger Title.',
            'chdfirstname.*.required_if' => 'Provide Passenger First Name.',
            'chdlastname.*.required_if' => 'Provide Passenger Last Name.',
            'chdgender.*.required_if' => 'Provide Passenger Gender.',
            'chddob.*.required_if' => 'Provide Passenger DOB.',
            'chdnationality.*.required_if' => 'Provide Passenger Nationality.',
            'chdpassport.*.required_if' => 'Provide Passenger Passport.',
            'chdpassexpire.*.required_if' => 'Provide Passenger Passport Expiry Date.',
            'chdpassnation.*.required_if' => 'Provide Passenger Passport Issuing Country.',
            'inftitle.*.required_if' => 'Provide Passenger Title.',
            'inffirstname.*.required_if' => 'Provide Passenger First Name.',
            'inflastname.*.required_if' => 'Provide Passenger Last Name.',
            'infgender.*.required_if' => 'Provide Passenger Gender.',
            'infdob.*.required_if' => 'Provide Passenger DOB.',
            'infnation.*.required_if' => 'Provide Passenger Nationality.',
            'infpassport.*.required_if' => 'Provide Passenger Passport.',
            'infpassexpire.*.required_if' => 'Provide Passenger Passport Expiry Date.',
            'infpassnation.*.required_if' => 'Provide Passenger Passport Issuing Country.'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $search = SearchFlight::findorfail(session()->get('flight_search'));
            if ($search->adults > 0) {
                $c = 0;
                if (is_array($this->input('adtdob'))) {
                    $adtdob = $this->input('adtdob');
                    foreach ($adtdob as $dob) {
                        if (Carbon::parse($dob)->diffInYears(Carbon::parse(Carbon::parse($search->flight_date))) < 12) {
                            $validator->errors()->add('adtdob.' . $c, 'Adult must be 12 years older.');
                        }
                        $c++;
                    }
                }
                $adtdoctype = array_values($this->input('adtdoctype'));
                $adtdocexpiry = array_values($this->input('adtpassportexpiry'));
                $c = 0;
                foreach ($adtdoctype as $key => $value) {
                    if ($value == 'Passport') {
                        if (Carbon::parse($adtdocexpiry[$key])->diffInMonths(Carbon::parse($search->flight_date)) < 6) {
                            $validator->errors()->add('adtpassportexpiry.' . $c, 'Passport expiry date must be after six months of flight date.');
                        }
                    }
                    $c++;
                }
            }

            if ($search->childs > 0) {
                if (is_array($this->input('chddob'))) {
                    $chddob = $this->input('chddob');
                    $c = 0;
                    foreach ($chddob as $dob) {
                        if (Carbon::parse($dob)->diffInYears(Carbon::parse($search->flight_date)) > 12) {
                            $validator->errors()->add('chddob.' . $c, 'Child must be less than 12 years.');
                        }
                        $c++;
                    }
                }
                $chddoctype = array_values($this->input('chddoctype'));
                $chddocexpiry = array_values($this->input('chdpassportexpiry'));
                $c = 0;
                foreach ($chddoctype as $key => $value) {
                    if ($value == 'Passport') {
                        if (Carbon::parse($chddocexpiry[$key])->diffInMonths(Carbon::parse($search->flight_date)) < 6) {
                            $validator->errors()->add('chdpassportexpiry.' . $c, 'Passport must be valid for 6 months after flight date.');
                        }
                    }
                    $c++;
                }
            }
            if ($search->infants > 0) {
                if (is_array($this->input('infdob'))) {
                    $infdob = $this->input('infdob');
                    $c = 0;
                    foreach ($infdob as $dob) {
                        if (Carbon::parse($dob)->diffInMonths(Carbon::parse($search->flight_date)) > 24) {
                            $validator->errors()->add('infdob.' . $c, 'Infant must be younger than 24 months.');
                        }
                        $c++;
                    }
                }
                $infdoctype = array_values($this->input('infdoctype'));
                $infdocexpiry = array_values($this->input('infpassportexpiry'));
                $c = 0;
                foreach ($infdoctype as $key => $value) {
                    if ($value == 'Passport') {
                        if (Carbon::parse($infdocexpiry[$key])->diffInMonths(Carbon::parse($search->flight_date)) < 6) {
                            $validator->errors()->add('infpassportexpiry.' . $c, 'Passport must be valid for 6 months after flight date.');
                        }
                    }
                    $c++;
                }
            }
        });
    }

    protected function prepareForValidation()
    {
        if ($this->has('adttitle')) {
            $adttitle = $this->input('adttitle');
            $adtgender = [];
            foreach ($adttitle as $title) {
                $adtgender[] = ($title == 'Mr.' || $title == 'Master.') ? 'M' : 'F';
            }
            $this->merge(['adtgender' => $adtgender]);
        }

        if ($this->has('chdtitle')) {
            $chdtitle = $this->input('chdtitle');
            $chdgender = [];
            foreach ($chdtitle as $title) {
                $chdgender[] = ($title == 'Mr.' || $title == 'Master') ? 'M' : 'F';
            }
            $this->merge(['chdgender' => $chdgender]);
        }

        if ($this->has('inftitle')) {
            $inftitle = $this->input('inftitle');
            $infgender = [];
            foreach ($inftitle as $title) {
                $infgender[] = ($title == 'Mr.' || $title == 'Master') ? 'M' : 'F';
            }
            $this->merge(['infgender' => $infgender]);
        }
    }
}
