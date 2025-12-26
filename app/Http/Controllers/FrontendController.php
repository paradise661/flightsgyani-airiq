<?php

namespace App\Http\Controllers;

use App\Http\Requests\DownloadRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Mail\B2b\AdminNotify;
use App\Mail\B2b\AgentRegister;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CompanyTicketDetail;
use App\Models\ContactUs;
use App\Models\Domestic\DomesticAirline;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\Domestic\DomesticSector;
use App\Models\FAQ;
use App\Models\Inquery;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\Package;
use App\Models\Partner;
use App\Models\PrivacyPolicy;
use App\Models\Site;
use App\Models\Slider;
use App\Models\Team;
use App\Models\TermCondition;
use App\Models\TravelAgency;
use App\Models\User;
use App\Models\Whatwedo;
use App\Service\Sabre\Request\SessionCloseRQ;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Rules\ReCaptcha;
use App\Service\AirIq\AirIqFlight;
use App\Service\AirIq\AirIqHelper;
use App\Service\AirIq\AirIqService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function index()
    {
        $data = [];
        if (session()->has('sabre_token')) {
            $close_session = new SessionCloseRQ();
            $close_session->doRequest();
        }
        session()->forget('flight_search');
        session()->forget('conversation_id');
        session()->forget('sabre_token');
        session()->forget('token_time');
        session()->forget('flight');
        session()->forget('flight_result');
        session()->forget('flight_airline');
        session()->forget('flight_book');

        $data['sliders'] = Slider::limit(6)->where('status', 1)->orderBy('order', 'ASC')->get();
        $data['sectors'] = DomesticSector::oldest('order')->get();
        return view('welcome', $data);
    }

    public function detail($slug)
    {
        $data = [];
        $data['package'] = Package::where('slug', $slug)->first();
        if (!$data['package']) abort(404);
        $type = $data['package']->category->type;

        //        $data['categories'] = Category::where('type',$type)->get();
        return view('front.view-package', $data);
    }

    public function list($categorySlug, $slug)
    {
        $data['category'] = Category::where('slug', $slug)->first();
        if (!$data['category']) abort(404);

        $data['packages'] = Package::where('category_id', $data['category']->id)->where('status', 1)->paginate(10);
        $data['categoriesType'] = Category::whereParentId($data['category']->parent_id)->get();

        $data['categorySlug'] = $categorySlug;

        return view('front.category-list', $data);
    }

    public function callMeBack(DownloadRequest $request)
    {
        $attr = $request->all();

        try {
            try {
                Inquery::create($attr);
                // Mail::send('mail.back.callmeback', ['data' => $attr], function ($m) use ($request) {
                //     $m->to('info@flightsgyani.com', $request->name)->subject('Itinerary');
                // });
                // Mail::send('mail.back.inquiry', ['data' => $attr], function ($m) use ($request) {
                //     $m->to($request->email, $request->name)->subject('Itinerary');
                // });
            } catch (\Exception $e) {
                Inquery::create($attr);
                return response()->json(['status' => $e->getMessage(), 'message' => 'Something went wrong on sending mail. But we recieve your inqury and contact you as soon as possible', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (request()->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'Your request has sent successfully. Please check email for detail.', 'code' => Response::HTTP_OK], Response::HTTP_OK);
            }
            return redirect()->back()->with('success', 'You!!!Inquiry has been successful We will contact you as soon as possible.');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Something went wrong. Please try again',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

            //            return redirect()->back()->with('error',$e->getMessage());
        }
        //email to admin
    }

    public function mail()
    {
        try {
            $package = Package::find(13);
            $data['name'] = 'name';
            $data['email'] = 'name';
            $data['phone'] = 'phone';
            $data['inq_date'] = 'phone';
            $data['message'] = 'phone';
            $data['city'] = 'phone';
            //            $user['email_message'] = $message;
            Mail::send('frontend.inquery', ['data' => $data], function ($m) {
                $m->to('dilkrishnapila@gmail.com', 'dil')->subject('Itinerary');
            });
            return 'hello';
        } catch (\Exception $e) {
            // Never reached
        }
    }

    public function getchildrenCategory(Request $request)
    {
        $childrenCategory = Category::whereParentId($request->parent_id)->get();
        return response()->json($childrenCategory);
    }

    public function search(Request $request)
    {
        //        dd($request->toArray());
        $categorySlug = 'domestic';
        $data['category'] = Category::find($request->category_id);
        $data['categoriesType'] = Category::whereParentId($data['category']->parent_id)->get();

        if ($request->category_id)
            $categorySlug = Category::find($request->category_id);
        else $categorySlug = Category::find($request->parent_id);

        $data['packages'] = Package::whereCategoryId($request->category_id)->orWhere('category_id', $request->parent_id)->where('status', 1)->paginate(10);
        $data['categories'] = Category::whereNull('parent_id')->get();
        $data['categorySlug'] = $categorySlug;


        return view('frontend.list', $data);
    }

    public function cv()
    {
        //        dd('test');
        return view('cv');
        $pdf = PDF::loadView('cv');
        return $pdf->download('itinerary.pdf');
    }

    public function download(DownloadRequest $request, $id)
    {
        $attr = $request->all();
        $package = Package::findOrFail($id);
        if (!$package) return abort(404);
        if ($request->type == 'booking') {
            $attr['package_id'] = $id;
        }
        Inquery::create($attr);


        if ($request->type == 'download') {
            $pdf = PDF::loadView('front.downloads.download', ['package' => $package]);
            return $pdf->download('itinerary_' . $package->title . '.pdf');
        }
        if ($request->type == 'booking') {
            //            return view('frontend.download',['package'=>$package]);
            Mail::send('front.downloads.download', ['package' => $package], function ($m) use ($request) {
                $m->to($request->email, $request->name)->subject('Itinerary');
            });
            Mail::send('front.downloads.download', ['package' => $package], function ($m) use ($request) {
                $m->to('info@flightsgyani.com', $request->name)->subject('Itinerary');
            });
        }
        if ($request->type == 'email') {
            //emailed
            Mail::send('front.downloads.download', ['package' => $package], function ($m) use ($request) {
                $m->to($request->email, $request->name)->subject('Itinerary');
            });
            Mail::send('front.downloads.download', ['package' => $package], function ($m) use ($request) {
                $m->to('info@flightsgyani.com', $request->name)->subject('Itinerary');
            });
        }
        try {
            return redirect()->back()->withSuccess('Your request has been sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'something went wrong.Please try again.');
        }
        //
    }

    public function about()
    {
        $data['about'] = AboutUs::get();
        $data['contact'] = ContactUs::get();
        $data['whatwedos'] = Whatwedo::get();
        $data['teams'] = Team::get();
        //        $data['categories']= Category::whereNull('parent_id')->get();
        return view('front.about', $data);
    }

    public function contact()
    {
        $data['about'] = AboutUs::get();
        $data['contact'] = ContactUs::get();
        $data['site_setting'] = Site::first();
        //        $data['categories']= Category::whereNull('parent_id')->get();
        return view('front.contact', $data);
    }

    public function commentStore(Request $request)
    {
        $attr = $request->except('_token');
        try {
            Comment::create($attr);
            return redirect()->back()->with('success', 'Thanks for comment');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again later');
        }
    }

    public function delete(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if ($comment->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }

    public function termsConditions()
    {
        $tc = TermCondition::first();
        if (!$tc) {
            abort(404);
        }
        return view('front.tc', ['tc' => $tc]);
    }

    public function privacyPolicy()
    {
        $pp = PrivacyPolicy::first();
        if (!$pp) {
            abort(404);
        }
        return view('front.pp', ['pp' => $pp]);
    }

    public function faq()
    {
        $faq = FAQ::first();
        if (!$faq) {
            abort(404);
        }
        return view('front.faq', ['faq' => $faq]);
    }

    public function inquirySubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        try {
            $attr = $request->all();
            Inquery::create($attr);
            // Mail::send('mail.back.callmeback', ['data' => $attr], function ($m) use ($request) {
            //     $m->to('info@flightsgyani.com', $request->name)->subject('Inquiry');
            // });
            return redirect()->back()->with('success', 'Contact form submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again later');
        }
    }

    public function insertPermission()
    {
        $permissions = [
            //start left sidebar permission
            [
                'name' => 'view dashboard',
                'guard_name' => 'web',
                'parent' => 'Dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view sabre',
                'guard_name' => 'web',
                'parent' => 'Sabre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view airport',
                'guard_name' => 'web',
                'parent' => 'Airport',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create airport',
                'guard_name' => 'web',
                'parent' => 'Airport',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit airport',
                'guard_name' => 'web',
                'parent' => 'Airport',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete airport',
                'guard_name' => 'web',
                'parent' => 'Airport',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view airline',
                'guard_name' => 'web',
                'parent' => 'Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create airline',
                'guard_name' => 'web',
                'parent' => 'Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit airline',
                'guard_name' => 'web',
                'parent' => 'Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete airline',
                'guard_name' => 'web',
                'parent' => 'Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view bspcommission',
                'guard_name' => 'web',
                'parent' => 'Bsp_Commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create bspcommission',
                'guard_name' => 'web',
                'parent' => 'Bsp_Commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit bspcommission',
                'guard_name' => 'web',
                'parent' => 'Bsp_Commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete bspcommission',
                'guard_name' => 'web',
                'parent' => 'Bsp_Commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view markup',
                'guard_name' => 'web',
                'parent' => 'Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create markup',
                'guard_name' => 'web',
                'parent' => 'Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit markup',
                'guard_name' => 'web',
                'parent' => 'Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete markup',
                'guard_name' => 'web',
                'parent' => 'Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view searchlog',
                'guard_name' => 'web',
                'parent' => 'Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'clear searchlog',
                'guard_name' => 'web',
                'parent' => 'Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'delete searchlog',
                'guard_name' => 'web',
                'parent' => 'Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view booking',
                'guard_name' => 'web',
                'parent' => 'Booking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete booking',
                'guard_name' => 'web',
                'parent' => 'Booking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view plasma',
                'guard_name' => 'web',
                'parent' => 'Plasma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view sector',
                'guard_name' => 'web',
                'parent' => 'Sector',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'create sector',
                'guard_name' => 'web',
                'parent' => 'Sector',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit sector',
                'guard_name' => 'web',
                'parent' => 'Sector',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete sector',
                'guard_name' => 'web',
                'parent' => 'Sector',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view domesticairline',
                'guard_name' => 'web',
                'parent' => 'Domestic_Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'create domesticairline',
                'guard_name' => 'web',
                'parent' => 'Domestic_Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit domesticairline',
                'guard_name' => 'web',
                'parent' => 'Domestic_Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete domesticairline',
                'guard_name' => 'web',
                'parent' => 'Domestic_Airline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view domesticbooking',
                'guard_name' => 'web',
                'parent' => 'Domestic_Booking',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'delete domesticbooking',
                'guard_name' => 'web',
                'parent' => 'Domestic_Booking',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view domesticsearchlog',
                'guard_name' => 'web',
                'parent' => 'Domestic_Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'deleteall domesticsearchlog',
                'guard_name' => 'web',
                'parent' => 'Domestic_Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete domesticsearchlog',
                'guard_name' => 'web',
                'parent' => 'Domestic_Searchlog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view domesticmarkup',
                'guard_name' => 'web',
                'parent' => 'Domestic_Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'create domesticmarkup',
                'guard_name' => 'web',
                'parent' => 'Domestic_Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit domesticmarkup',
                'guard_name' => 'web',
                'parent' => 'Domestic_Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete domesticmarkup',
                'guard_name' => 'web',
                'parent' => 'Domestic_Markup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view branch',
                'guard_name' => 'web',
                'parent' => 'Branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create branch',
                'guard_name' => 'web',
                'parent' => 'Branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'edit branch',
                'guard_name' => 'web',
                'parent' => 'Branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete branch',
                'guard_name' => 'web',
                'parent' => 'Branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view about',
                'guard_name' => 'web',
                'parent' => 'About',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit about',
                'guard_name' => 'web',
                'parent' => 'About',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete about',
                'guard_name' => 'web',
                'parent' => 'About',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view page',
                'guard_name' => 'web',
                'parent' => 'Page',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create page',
                'guard_name' => 'web',
                'parent' => 'Page',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit page',
                'guard_name' => 'web',
                'parent' => 'Page',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete page',
                'guard_name' => 'web',
                'parent' => 'Page',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view faq',
                'guard_name' => 'web',
                'parent' => 'Faq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create faq',
                'guard_name' => 'web',
                'parent' => 'Faq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit faq',
                'guard_name' => 'web',
                'parent' => 'Faq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete faq',
                'guard_name' => 'web',
                'parent' => 'Faq',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view team',
                'guard_name' => 'web',
                'parent' => 'Team',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create team',
                'guard_name' => 'web',
                'parent' => 'Team',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit team',
                'guard_name' => 'web',
                'parent' => 'Team',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete team',
                'guard_name' => 'web',
                'parent' => 'Team',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view blog',
                'guard_name' => 'web',
                'parent' => 'Blog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create blog',
                'guard_name' => 'web',
                'parent' => 'Blog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit blog',
                'guard_name' => 'web',
                'parent' => 'Blog',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete blog',
                'guard_name' => 'web',
                'parent' => 'Blog',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view whatwedo',
                'guard_name' => 'web',
                'parent' => 'Whatwedo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'create whatwedo',
                'guard_name' => 'web',
                'parent' => 'Whatwedo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'edit whatwedo',
                'guard_name' => 'web',
                'parent' => 'Whatwedo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'delete whatwedo',
                'guard_name' => 'web',
                'parent' => 'Whatwedo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view slider',
                'guard_name' => 'web',
                'parent' => 'Slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create slider',
                'guard_name' => 'web',
                'parent' => 'Slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit slider',
                'guard_name' => 'web',
                'parent' => 'Slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete slider',
                'guard_name' => 'web',
                'parent' => 'Slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view sitesetting',
                'guard_name' => 'web',
                'parent' => 'Site_Setting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'update sitesetting',
                'guard_name' => 'web',
                'parent' => 'Site_Setting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view user',
                'guard_name' => 'web',
                'parent' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create user',
                'guard_name' => 'web',
                'parent' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'update user',
                'guard_name' => 'web',
                'parent' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'parent' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'view role',
                'guard_name' => 'web',
                'parent' => 'Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create role',
                'guard_name' => 'web',
                'parent' => 'Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'edit role',
                'guard_name' => 'web',
                'parent' => 'Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'parent' => 'Role',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view permission',
                'guard_name' => 'web',
                'parent' => 'Permission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'create permission',
                'guard_name' => 'web',
                'parent' => 'Permission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit permission',
                'guard_name' => 'web',
                'parent' => 'Permission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete permission',
                'guard_name' => 'web',
                'parent' => 'Permission',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view khalti',
                'guard_name' => 'web',
                'parent' => 'Khalti',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view inquiry',
                'guard_name' => 'web',
                'parent' => 'Inquiry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'deleteall inquiry',
                'guard_name' => 'web',
                'parent' => 'Inquiry',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'view registeruser',
                'guard_name' => 'web',
                'parent' => 'Register_User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete registeruser',
                'guard_name' => 'web',
                'parent' => 'Register_User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'status registeruser',
                'guard_name' => 'web',
                'parent' => 'Register_User',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        Permission::insert($permissions);
    }

    public function insertRole()
    {
        $role_admin = Role::create(['name' => 'SUPER-ADMIN']);
        $role_user = Role::create(['name' => 'ADMIN']);

        $user = User::find(1);
        $user->assignRole($role_admin);
        $role_admin->givePermissionTo(Permission::all());
    }

    public function findYourTicket()
    {
        return view('front.domestic.findyourticket');
    }

    public function viewTicket($booking_code, $email, $type)
    {
        $ticketDetails = null;

        if ($type == 'domestic') {
            $booking = DomesticFlightBooking::where('booking_code', $booking_code)->where('emergency_contact_email', $email)->first();
            if ($booking->user_id) {
                $ticketDetails = CompanyTicketDetail::where('user_id', $booking->user_id)->first();
            }
            $airlinesData = DomesticAirline::oldest('order')->get();
            $airData = [];
            $airDataName = [];
            foreach ($airlinesData as $key => $air) {
                $airData[$air->code] = $air->image;
                $airDataName[$air->code] = $air->name;
            }

            if ($booking) {
                $pdf = Pdf::loadView('front.domestic.ticket', compact('booking', 'airData', 'ticketDetails'));
                return $pdf->stream('flightsgyani-ticket.pdf');
            } else {
                return redirect()->route('findyourticket')->with('error', 'Invalid Booking Code/Email');
            }
        }
        if ($type == 'international') {
            $booking = FlightBooking::where('booking_code', $booking_code)->where('contact_details->email', $email)->first();
            if (!$booking) {
                return redirect()->route('findyourticket')->with('error', 'Invalid Booking Code/Email');
            }
            if ($booking->user_id) {
                $ticketDetails = CompanyTicketDetail::where('user_id', $booking->user_id)->first();
            }
            if ($booking->api_provider == 'airiq') {
                $flights = json_decode($booking->flights, true)['flight'];
                if (!isset($booking->airiq_ticket_details)) {
                    $tickets = false;
                } else {
                    $tickets = json_decode($booking->airiq_ticket_details);
                }

                $baggage = json_decode($booking->flights, true)['baggage'];
                $pdf = Pdf::loadView('flights.airiqticket', compact('ticketDetails', 'tickets', 'flights', 'booking', 'baggage'));
                return $pdf->stream('flightsgyani-ticket.pdf');
            } else {

                $flights = json_decode($booking->flights, true)['flight'];
                if (!isset($booking->ticket_details)) {
                    $tickets = false;
                } else {
                    $tickets = $booking->getTickets()->get();
                }

                $baggage = json_decode($booking->flights, true)['baggage'];
                $ticket_itineraries = json_decode($booking->ticket_itineraries, true);
                $pdf = Pdf::loadView('flights.international-ticket', compact('tickets', 'flights', 'booking', 'baggage', 'ticket_itineraries', 'ticketDetails'));
                return $pdf->stream('flightsgyani-ticket.pdf');
            }
        }
    }

    public function agentLogin()
    {
        return view('auth.agentlogin');
    }

    public function agentLoginCheck(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Check if the user is active
            $user = Auth::user();

            if ($user->user_type !== 'AGENT') {
                Auth::logout();
                return redirect()->back()->with('error', 'Invalid Access');
            }
            if ($user->status != 'Active') {
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is inactive');
            }

            // Proceed with login
            return redirect()->route('frontend.index');
        }

        // If authentication fails
        return redirect()->back()->with('error', 'Invalid Email/Password');
    }

    public function agentRegister()
    {
        return view('auth.agentregister');
    }

    public function agentRegisterStore(StoreAgentRequest $request)
    {
        $input = $request->all();
        $generatePassword = strtolower(Str::random(6));
        $input['password'] = Hash::make($generatePassword);
        $input['user_type'] = 'AGENT';
        $input['status'] = 'Pending';
        $user =  User::create($input);
        $request['password'] = $generatePassword;
        $request['agent_register'] = 'Agent';
        $request['user_id'] = $user->id;
        Mail::to($request->email)->send(new AgentRegister($request->only(['name', 'email', 'password', 'agent_register'])));
        Mail::to(['info@flightsgyani.com'])->send(new AdminNotify($request->only(['name', 'email', 'user_id'])));

        return redirect()->back()->with('success', 'Your form has been successfully submitted. Our admin team will verify your details and get back to you shortly.');
    }
}
