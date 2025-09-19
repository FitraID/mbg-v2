<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'lokasi',
        'mesin_absen',
        'keterangan',
        'status',
    ];

    /**
     * Get the shifts for the branch.
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class, 'id_cabang');
    }

    /**
     * Get the employees (karyawans) for the branch.
     */
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'id_cabang');
    }
}
