<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\ContactUsRequest;
use App\Repositories\BlogRepository;
use App\Repositories\ContactUsRepository;
use App\Repositories\OrganizationSettingsRepository;
use App\Repositories\PayPlanRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class IndexController extends Controller
{
    private $payPlanRepository;
    private $contactUsRepository;
    private $settingsRepository;
    private $userRepository;
    private $organizationSettingsRepository;
    private $blogRepository;

    public function __construct(
        PayPlanRepository $payPlanRepository,
        ContactUsRepository $contactUsRepository,
        SettingsRepository $settingsRepository,
        UserRepository $userRepository,
        OrganizationSettingsRepository $organizationSettingsRepository,
        BlogRepository $blogRepository
    ) {
        parent::__construct();
        $this->payPlanRepository = $payPlanRepository;
        $this->contactUsRepository = $contactUsRepository;
        $this->settingsRepository = $settingsRepository;
        $this->userRepository = $userRepository;
        $this->organizationSettingsRepository = $organizationSettingsRepository;
        $this->blogRepository = $blogRepository;
        view()->share('no_vue', true);
    }

    public function index()
    {
        $this->generateParams();
        $title = 'Home';
        return view('frontend.index', compact('title'));
    }

    public function aboutUs()
    {
        if ($this->userRepository->inRole('admin')) {
            $language = $this->settingsRepository->getKey('language');
            App::setLocale($language??'en');
        }
        $organization = $this->userRepository->getOrganization();
        if (!$this->userRepository->inRole('admin') && $organization) {
            $language = $this->organizationSettingsRepository->getKey('language');
            App::setLocale($language??'en');
        }
        $this->generateParams();
        $title = 'About Us';

        return view('frontend.about_us', compact('title'));
    }

    public function contactUs()
    {
        $user = $this->userRepository->getUser();
        $title = trans('contactus.contactus');
        return view('frontend.contactus', compact('title', 'user'));
    }

    public function storeContactUs(ContactUsRequest $request)
    {
        $site_email = $this->settingsRepository->getKey('site_email');
        $user = $this->userRepository->getUser();
        if (isset($user)) {
            $request->merge(['from' => $user->id]);
        }
        $this->contactUsRepository->create($request->all());
        if (false === !filter_var($site_email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($site_email)->send(new ContactUs([
                'from' => $request->email,
                'subject' => trans('contactus.contactus'),
                'message' => $request->message,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]));
        }

        return redirect('contactus');
    }

    public function privacy()
    {
        $user = $this->userRepository->getUser();
        $title = trans('index.privacy_policy');
        $navbar_custom = trans('frontend.custom_navbar');

        return view('frontend.privacy', compact('title', 'user','navbar_custom'));
    }

    public function pricing()
    {
        $user = $this->userRepository->getUser();
        $title = trans('frontend.pricing');
        $navbar_custom = trans('frontend.custom_navbar');
        $this->generateParams();
        return view('frontend.pricing', compact('title', 'user','navbar_custom'));
    }

    private function generateParams()
    {
        $payplans = $this->payPlanRepository->all()->sortByDesc('order');

        $payment_plans_list = $payplans->values()->all();
        view()->share('payment_plans_list', $payment_plans_list);
    }
}
