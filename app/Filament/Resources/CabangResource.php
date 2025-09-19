<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CabangResource\Pages;
use App\Models\Cabang;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CabangResource extends Resource
{
    protected static ?string $model = Cabang::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $pluralModelLabel = 'Cabang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Cabang')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Cabang Utama, Kantor Pusat'),
                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Jalan Sudirman No. 123'),
                        Toggle::make('mesin_absen')
                            ->label('Mesin Absensi')
                            ->inline(false)
                            ->default(false)
                            ->helperText('Aktifkan jika cabang ini memiliki mesin absensi.'),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('Detail opsional tentang cabang.'),
                        Select::make('status')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Tidak Aktif',
                            ])
                            ->required()
                            ->helperText('Atur status operasional cabang saat ini.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Cabang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Cabang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable(),
                IconColumn::make('mesin_absen')
                    ->label('Mesin Absensi')
                    ->boolean(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    }),
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
            'index' => Pages\ListCabangs::route('/'),
            'create' => Pages\CreateCabang::route('/create'),
            'edit' => Pages\EditCabang::route('/{record}/edit'),
        ];
    }
}
