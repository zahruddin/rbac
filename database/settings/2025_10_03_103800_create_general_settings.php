<?php

// database/settings/2024_01_01_000001_create_general_settings.php (Nama file bervariasi)

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Grup/Kunci harus sesuai dengan yang didefinisikan di Settings Class
        $this->migrator->add('general.site_name', 'Nama Situs Default');
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.timezone', 'Asia/Jakarta');
    }
};