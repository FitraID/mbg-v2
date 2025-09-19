<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'id_cabang',
        'kode_karyawan',
        'jabatan',
        'id_shift',
        // 'id_absen',
        'keterangan',
        'status',
    ];

    /**
     * Get the branch (cabang) that the employee belongs to.
     */
    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    /**
     * Get the shift that the employee is assigned to.
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'id_shift');
    }

    /**
     * Get the absences (absens) for the employee.
     */
    public function absens(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_pegawai');
    }

    /**
     * Get the salaries (gajis) for the employee.
     */
    public function gajis(): HasMany
    {
        return $this->hasMany(Gaji::class, 'id_pegawai');
    }

    /**
     * Get the deductions (potongans) for the employee.
     */
    public function potongans(): HasMany
    {
        return $this->hasMany(Potongan::class, 'id_pegawai');
    }
}
