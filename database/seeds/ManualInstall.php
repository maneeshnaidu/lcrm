<?php

use Illuminate\Database\Seeder;
use App\Repositories\SettingsRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;

class ManualInstall extends Seeder
{
    private $settingsRepository;

    private $userRepository;

    public function run()
    {
        $first_name = 'admin';
        $last_name = 'admin';
        $email = 'admin@admin.com';
        $password = 'password';

        $this->settingsRepository = new SettingsRepositoryEloquent(app());
        $this->userRepository = new UserRepositoryEloquent(app());

        $this->settingsRepository->setKey('site_name', 'lcrm_saas');
        $this->settingsRepository->setKey('site_email', 'saas@lcrm.com');
        $this->settingsRepository->setKey('currency', 'USD');
        $this->settingsRepository->setKey('allowed_extensions', 'gif,jpg,jpeg,png,pdf,txt');
        $this->settingsRepository->setKey('max_upload_file_size', '1000');
        $this->settingsRepository->setKey('minimum_characters', '3');
        $this->settingsRepository->setKey('date_format', 'F j,Y');
        $this->settingsRepository->setKey('time_format', 'H:i');
        $this->settingsRepository->setKey('date_time_format', 'F j,Y H:i');

        $admin = Sentinel::register([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'user_id' => 1,
        ], true);

        $this->userRepository->assignRole($admin, 'admin');

        $this->command->info('New user with email :'.$admin->email.' created');

        $my_file = base_path().'/storage/installed';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $data = 'Lcrm saas successfully installed';
        fwrite($handle, $data);

        \Artisan::call('config:cache');
        \Artisan::call('route:cache');

        $this->command->info('LCRM_SAAS INSTALLATION SUCCESSFUL');
    }
}
