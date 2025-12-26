<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\SabreCredenUpdateRequest;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function editSabreDetails()
    {
        abort_unless(Gate::allows('view sabre'), 403);
        activityLog('viewed sabre details');
        return view('admin.v2.intlflights.sabre');
    }

    public function updateSabreDetails(SabreCredenUpdateRequest $request)
    {
        abort_unless(Gate::allows('view sabre'), 403);

        $text = "<?php return ['pcc'=>'" . $request->sabrepcc . "','url'=>'" . $request->sabreurl . "','username'=>'" . $request->sabreuser . "',
        'password'=>'" . $request->sabrepassword . "','lniata'=>'" . $request->sabrelniata . "','citycode'=>'" .
            $request->sabrecitycode . "','addressline'=>'" . $request->sabreaddressline . "','cityname'=>'" . $request->sabrecityname .
            "','countrycode'=>'" . $request->sabrecountrycode . "','postal'=>'" . $request->sabrepostal . "','streetnumber'=>'" .
            $request->sabrestreet . "'];";

        $file = base_path() . '/config/sabre.php';
        file_put_contents($file, $text);
        Artisan::call('config:clear');
        activityLog('updated sabre details');

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
        abort_unless(Gate::allows('view sitesetting'), 403);

        $site = Site::first();
        if (!$site) {
            $site = new Site();
            $site->save();
        }
        activityLog('viewed site setting');

        return view('admin.v2.settings', compact('site'));
    }

    public function updateSiteSettings(Request $request)
    {
        abort_unless(Gate::allows('update sitesetting'), 403);

        $site = Site::first();
        if (!$site) {
            $site = new Site();
            $site->save();
        }

        $input = $request->all();
        if ($request->file('primary_logo')) {
            $input['primary_logo'] = $this->fileUpload($request, 'primary_logo');
        }
        if ($request->file('secondary_logo')) {
            $input['secondary_logo'] = $this->fileUpload($request, 'secondary_logo');
        }
        if ($request->file('homepage_popup')) {
            $input['homepage_popup'] = $this->fileUpload($request, 'homepage_popup');
        }
        if ($request->file('payment_partners_image')) {
            $input['payment_partners_image'] = $this->fileUpload($request, 'payment_partners_image');
        }
        if ($request->file('affiliated_partners_image')) {
            $input['affiliated_partners_image'] = $this->fileUpload($request, 'affiliated_partners_image');
        }
        if ($request->file('homepage_mobile_ad')) {
            $input['homepage_mobile_ad'] = $this->fileUpload($request, 'homepage_mobile_ad');
        }
        if ($request->file('loader_ad')) {
            $input['loader_ad'] = $this->fileUpload($request, 'loader_ad');
        }
        if ($request->file('desktop_modify_ad')) {
            $input['desktop_modify_ad'] = $this->fileUpload($request, 'desktop_modify_ad');
        }

        $site->update($input);
        activityLog('updated site setting');

        return redirect()->back()->with('success', 'Site Setting updated successfully.');
    }

    public function fileUpload(Request $request, $name)
    {
        $imageName = '';
        if ($image = $request->file($name)) {
            $destinationPath = public_path() . '/uploads/site';
            $imageName = date('YmdHis') . $name . "-" . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
        }
        return $imageName;
    }

    public function removefileFromSite($filename, $type)
    {
        abort_unless(Gate::allows('update sitesetting'), 403);

        $site = Site::first();
        $this->removeFile($filename);
        $site->update([$type => null]);
        activityLog('removed image of ' . $type);

        return redirect()->back()->with('success', 'File removed successfully.');
    }

    public function removeFile($file)
    {
        if ($file) {
            $path = public_path() . '/uploads/site/' . $file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    public function changePassword()
    {
        return view('admin.v2.changepassword');
    }

    public function changePasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        activityLog('changed password');

        // Redirect with a success message
        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
