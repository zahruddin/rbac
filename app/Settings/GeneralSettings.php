<?php

// app/Settings/GeneralSettings.php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public bool $site_active;
    public ?string $timezone; // Contoh properti yang bisa null

    public static function group(): string
    {
        // Ini adalah kunci unik untuk grup pengaturan ini di database/cache
        return 'general';
    }
}