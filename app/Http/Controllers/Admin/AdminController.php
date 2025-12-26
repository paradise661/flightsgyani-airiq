<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\SabreCredenUpdateRequest;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {

        return view('admin.dashboard.index');
    }

    public function editSabreDetails()
    {
        return view('admin.flights.sabre');
    }

    public function updateSabreDetails(SabreCredenUpdateRequest $request)
    {

        $text = "<?php return ['pcc'=>'" . $request->sabrepcc . "','url'=>'" . $request->sabreurl . "','username'=>'" . $request->sabreuser . "',
        'password'=>'" . $request->sabrepassword . "','lniata'=>'" . $request->sabrelniata . "','citycode'=>'" .
            $request->sabrecitycode . "','addressline'=>'" . $request->sabreaddressline . "','cityname'=>'" . $request->sabrecityname .
            "','countrycode'=>'" . $request->sabrecountrycode . "','postal'=>'" . $request->sabrepostal . "','streetnumber'=>'" .
            $request->sabrestreet . "'];";

        $file = base_path() . '/config/sabre.php';
        file_put_contents($file, $text);
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Sabre Credentials updated successfully.');
    }

    public function filemanager()
    {
        return view('admin.filemanager');
    }

    public function markNotificationRead(Request $request)
    {
//        dd($request->notif);
        $notification = auth()->user()->notifications()->find($request->notif);
        if ($notification) {
            $notification->markAsRead();
            return $notification->data['url'];
        } else {
            return '/admin/dashboard';
        }

    }

    public function deleteNotification(Request $request)
    {
        $notification = auth()->user()->notifications()->find($request->notif);
        if ($notification) {
            $notification->delete();
            return 'True';
        }
        return 'False';

    }

    public function readAllNotifications(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function deleteAllNotifications(Request $request)
    {
        auth()->user()->notifications()->delete();
        return redirect()->back();
    }

    public function siteSettings()
    {
        $site = Site::first();
        if (!$site) {
            $site = new Site();
            $site->save();
        }
        return view('admin.settings', ['site' => $site]);
    }

    public function updateSiteSettings(Request $request)
    {
        $site = Site::first();
        if (!$site) {
            $site = new Site();
            $site->save();
        }
        if ($request->has('popupStatus')) {
            $popupStatus = true;
        } else {
            $popupStatus = false;
        }
        $site->update([
            'name' => $request->name,
            'title' => $request->title,
            'primary_logo' => $request->primaryLogo,
            'secondary_logo' => $request->secondaryLogo,
            'homepage_popup' => $request->homePopup,
            'search_popup_image' => $request->searchPopup,
            'homepage_popup_status' => $popupStatus,
            'primary_office' => $request->primaryOffice,
            'secondary_office' => $request->secondaryOffice,
            'primary_address' => $request->primaryAddress,
            'secondary_address' => $request->SecondaryAddress,
            'hunting_line' => $request->huntingLine,
            'primary_contact' => $request->primaryContact,
            'secondary_contact' => $request->secondaryContact,
            'contact_email' => $request->contactEmail,
            'facebook_link' => $request->facebook,
            'twitter_link' => $request->twitter,
            'instagram_link' => $request->instagram,
            'linkedin_link' => $request->linkedin
        ]);
        return redirect()->back()->with('success', 'Site Setting updated successfully.');
    }
}
