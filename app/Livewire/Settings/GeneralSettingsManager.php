<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Spatie\LaravelSettings\Settings; // Import Settings base class
use App\Settings\GeneralSettings; // Ganti ini dengan path kelas setting Anda

class GeneralSettingsManager extends Component
{
    // Properti yang akan di-bind ke form input
    public $siteName;
    public $siteActive;
    public $siteTimezone;

    // Rules Validasi
    protected $rules = [
        'siteName' => 'required|string|max:255',
        'siteActive' => 'required|boolean',
        'siteTimezone' => 'required|string|timezone',
    ];

    public function mount(GeneralSettings $settings)
    {
        $this->authorize('read-general-settings');
        // Isi properti dari data Settings yang tersimpan
        $this->siteName = $settings->site_name;
        $this->siteActive = $settings->site_active;
        $this->siteTimezone = $settings->site_timezone ?? config('app.timezone'); 
    }

    public function save(GeneralSettings $settings)
    {
        $this->authorize('update-general-settings');
        $this->validate();

        // Menyimpan data ke Settings
        $settings->site_name = $this->siteName;
        $settings->site_active = $this->siteActive;
        $settings->site_timezone = $this->siteTimezone;
        
        // Simpan ke database
        $settings->save();

        // Kirim notifikasi sukses
        session()->flash('success', 'Pengaturan Umum berhasil diperbarui!');

        return $this->redirect(route('settings.general'), navigate: false);
    }

    public function render()
    {
        // Pastikan Anda memiliki GeneralSettings.php di App\Settings\
        return view('livewire.settings.general-settings-manager');
    }
}