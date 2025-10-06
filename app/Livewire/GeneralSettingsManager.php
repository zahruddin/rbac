<?php

namespace App\Livewire;

use Livewire\Component;
use App\Settings\GeneralSettings; // Pastikan Anda mengimpor kelas pengaturan Spatie Anda

class GeneralSettingsManager extends Component
{
    // Properti publik untuk two-way binding dari form. 
    // Nama harus sesuai dengan properti di kelas GeneralSettings.
    public string $site_name;
    public bool $site_active;

    // Status notifikasi
    public bool $statusSaved = false;

    // Definisi aturan validasi Livewire
    protected array $rules = [
        'site_name' => 'required|string|min:3|max:255',
        'site_active' => 'boolean',
    ];

    /**
     * Dipanggil saat komponen diinisialisasi. Mengisi properti Livewire.
     */
    public function mount(GeneralSettings $settings): void
    {
        // Mengambil nilai pengaturan saat ini dari database/cache dan menetapkannya ke properti Livewire
        $this->site_name = $settings->site_name;
        $this->site_active = $settings->site_active;
    }

    /**
     * Metode untuk menyimpan data pengaturan.
     */
    public function save(GeneralSettings $settings): void
    {
        // 1. Jalankan Validasi
        $this->validate();

        // 2. Perbarui properti pada objek pengaturan Spatie dari properti Livewire
        $settings->site_name = $this->site_name;
        $settings->site_active = $this->site_active;

        // 3. Simpan objek pengaturan (menyimpan ke database)
        $settings->save();

        // 4. Tampilkan Notifikasi dan hapus setelah 3 detik
        $this->statusSaved = true;
        
        // Menggunakan JavaScript untuk mengatur ulang status saved setelah 3 detik
        $this->js('setTimeout(() => $wire.statusSaved = false, 3000)');
    }

    public function render()
    {
        return view('livewire.general-settings-manager');
    }
}