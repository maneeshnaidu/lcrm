<?php

namespace App\Repositories;

use Intervention\Image\ImageManagerStatic as Image;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

/**
 * Class SettingsRepositoryEloquent.
 */
class SettingsRepositoryEloquent extends BaseRepository implements SettingsRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Setting::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAll()
    {
        if (!Cache::get('all_keys')) {
            $this->setCache();
        }

        return Cache::many(Cache::get('all_keys') ?? []);
    }

    public function setCache()
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::forever($setting->key, $setting->value);
            $keys = Cache::get('all_keys');
            $keys[] = $setting->key;
            Cache::forever('all_keys', array_unique($keys));
        }

        return;
    }

    public function getKey($key, $default = null)
    {
        $value = Cache::rememberForever($key, function () use ($key) {
            return Setting::where('key', $key)->get()->last();
        });

        return $value ?? $default;
    }

    public function setKey($key, $value)
    {
        $setting = Setting::updateOrCreate([
            'key' => $key,
        ], [
            'value' => $value,
        ]);

        Cache::forever($setting->key, $setting->value);
        $keys = Cache::get('all_keys');
        $keys[] = $key;
        Cache::forever('all_keys', array_unique($keys));

        return;
    }

    public function forgetKey($key)
    {
        Setting::where('key', $key)->delete();
        $key = Cache::pull($key);

        return $key;
    }
}
