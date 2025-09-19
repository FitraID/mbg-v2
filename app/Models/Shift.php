<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'jam_masuk',
        'jam_pulang',
        'id_cabang',
    ];

    /**
     * Get the branch (cabang) that owns the shift.
     */
    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    /**
     * Get the employees (karyawans) assigned to the shift.
     */
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'id_shift');
    }
}
