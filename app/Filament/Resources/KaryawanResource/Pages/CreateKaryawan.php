<?php

namespace App\Filament\Resources\KaryawanResource\Pages;

use App\Filament\Resources\KaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Gaji;
use Illuminate\Database\Eloquent\Model;

class CreateKaryawan extends CreateRecord
{
    protected static string $resource = KaryawanResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $gajiPokok = $data['gaji_pokok'];
        unset($data['gaji_pokok']);

        $karyawan = static::getModel()::create($data);

        Gaji::create([
            'nama' => 'Gaji Pokok',
            'id_pegawai' => $karyawan->id,
            'jumlah' => $gajiPokok,
            'status' => 'active',
            'keterangan' => 'Gaji_Pokok',
            'is_basic_salary' => true,
        ]);

        return $karyawan;
    }
}
