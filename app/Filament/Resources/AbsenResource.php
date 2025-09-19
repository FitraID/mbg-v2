<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenResource\Pages;
use App\Models\Absen;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbsenResource extends Resource
{
    protected static ?string $model = Absen::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $pluralModelLabel = 'Absensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('id_pegawai')
                            ->label('Karyawan')
                            ->relationship('karyawan', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih karyawan untuk merekam absensi.'),
                        DateTimePicker::make('absen_masuk')
                            ->label('Waktu Masuk')
                            ->required(),
                        DateTimePicker::make('absen_pulang')
                            ->label('Waktu Pulang')
                            ->nullable(),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('Detail opsional tentang absensi.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Absensi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('karyawan.nama')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('absen_masuk')
                    ->label('Waktu Masuk')
                    ->sortable(),
                TextColumn::make('absen_pulang')
                    ->label('Waktu Pulang')
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsens::route('/'),
            'create' => Pages\CreateAbsen::route('/create'),
            'edit' => Pages\EditAbsen::route('/{record}/edit'),
        ];
    }
}
