<?php

namespace App\Filament\Imports;

use App\Models\Absen;
use App\Models\Karyawan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Carbon;

class AbsenImporter extends Importer
{
    protected static ?string $model = Absen::class;

    public static function getColumns(): array
    {
        return [
            // ImportColumn::make('kode_karyawan')
            //     ->requiredMapping(),
            ImportColumn::make('id_pegawai')
                ->requiredMapping(),
            ImportColumn::make('absen_masuk')
                ->requiredMapping(),
            ImportColumn::make('absen_pulang')
                ->requiredMapping(),
            ImportColumn::make('tanggal')
                ->requiredMapping(),
            ImportColumn::make('keterangan')
                ->requiredMapping(),
            // ImportColumn::make('tanggal_dan_waktu')
            //     ->requiredMapping()
            //     ->rules(['required', 'date_format:d-m-Y H:i'])
            //     ->castStateUsing(fn($state) => Carbon::createFromFormat('d-m-Y H:i', $state)),
            // ImportColumn::make('binary_0')
            //     ->requiredMapping(),
            // ImportColumn::make('binary_1')
            //     ->requiredMapping(),
            // ImportColumn::make('binary_2')
            //     ->requiredMapping(),
            // ImportColumn::make('binary_3')
            //     ->requiredMapping(),
        ];
    }

    public function resolveRecord(): ?Absen
    {

        $kode_karyawan = $this->data['kode_karyawan'];
        $tanggal_dan_waktu = $this->data['tanggal_dan_waktu'];
        $binData = [
            'bin0' => $this->data['binary_0'],
            'bin1' => $this->data['binary_1'],
            'bin2' => $this->data['binary_2'],
            'bin3' => $this->data['binary_3'],
        ];

        $employeeData = Karyawan::where('kode_karyawan', $kode_karyawan)->first();

        if (!$employeeData) {
            return null;
        }


        $status = 'unidentified';
        if ($binData['bin0'] == '1' && $binData['bin1'] == '0' && $binData['bin2'] == '1' && $binData['bin3'] == '0') {
            $status = 'check-in';
        } else if ($binData['bin0'] == '1' && $binData['bin1'] == '1' && $binData['bin2'] == '1' && $binData['bin3'] == '0') {
            $status = 'check-out';
        }


        if ($status == 'check-in') {

            return Absen::firstOrCreate([
                'id_pegawai' => $employeeData->id,
                'tanggal' => $tanggal_dan_waktu->format('Y-m-d'),
            ], [
                'absen_masuk' => $tanggal_dan_waktu->toDateTimeString(),
            ]);
        } else if ($status == 'check-out') {

            $existingAbsen = Absen::where('id_pegawai', $employeeData->id)
                ->whereDate('tanggal', $tanggal_dan_waktu->format('Y-m-d'))
                ->first();

            if ($existingAbsen) {

                $existingAbsen->absen_pulang = $tanggal_dan_waktu->toDateTimeString();
                return $existingAbsen;
            } else {
                return null;
            }
        }

        return new Absen();
        // return null;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your absen import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';
        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }
        return $body;
    }
}