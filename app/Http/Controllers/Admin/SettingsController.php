<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Repositories\ImageRepository;
use App\Repositories\OptionRepository;
use Illuminate\Http\Request;
use App\Repositories\SettingsRepository;

class SettingsController extends Controller
{
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    private $settingsRepository;
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * SettingsController constructor.
     *
     * @param OptionRepository $optionRepository
     * @param SettingsRepository $settingsRepository
     * @param ImageRepository $imageRepository
     */
    public function __construct(
        OptionRepository $optionRepository,
        SettingsRepository $settingsRepository,
        ImageRepository $imageRepository
    )
    {
        parent::__construct();
        view()->share('type', 'admin/setting');
        $this->optionRepository = $optionRepository;
        $this->settingsRepository = $settingsRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('settings.settings');
        $max_upload_file_size = [
            '1000' => '1MB',
            '2000' => '2MB',
            '3000' => '3MB',
            '4000' => '4MB',
            '5000' => '5MB',
            '6000' => '6MB',
            '7000' => '7MB',
            '8000' => '8MB',
            '9000' => '9MB',
            '10000' => '10MB',
        ];

        $currency = $this->optionRepository->getAll()
            ->where('category', 'currency')
            ->map(
                function ($title) {
                    return [
                        'text' => $title->title,
                        'id' => $title->value,
                    ];
                }
            )->pluck('text', 'id')->toArray();

        $backup_type = $this->optionRepository->getAll()
            ->where('category', 'backup_type')
            ->map(
                function ($title) {
                    return [
                        'text' => $title->value,
                        'id' => $title->title,
                    ];
                }
            );

        $languages = $this->optionRepository->getAll()->where('category', 'language')->pluck('title', 'value');

        return view('admin.setting.index', compact('title', 'max_upload_file_size', 'currency', 'backup_type', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request)
    {

        if ('' != $request->hasFile('site_logo_file')) {
            $file = $request->file('site_logo_file');
            $file_name = $this->imageRepository->uploadImage($file,'site');

            $request->merge([
                'site_logo' => $file_name,
            ]);
            $this->imageRepository->generateThumbnail($file_name,'site');
        }

        $request->date_format = $request->date_format_custom;
        $request->time_format = $request->time_format_custom;
        if ('' == $request->date_format) {
            $request->date_format = 'F j,Y';
        }
        if ('' == $request->time_format) {
            $request->time_format = 'H:i';
        }
        $request->merge([
            'date_time_format' => $request->date_format . ' ' . $request->time_format,
        ]);
        foreach ($request->except('_token', 'site_logo_file', 'date_format_custom', 'time_format_custom') as $key => $value) {
            $this->settingsRepository->setKey($key, $value);
        }

        return redirect()->back();
    }
}
