<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiResource\Pages;
use App\Models\Gaji;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GajiResource extends Resource
{
    protected static ?string $model = Gaji::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $pluralModelLabel = 'Gaji';

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
                            ->helperText('Pilih karyawan untuk merekam gaji.'),
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->prefix('IDR')
                            ->required()
                            ->placeholder('contoh: 5000000'),
                        Select::make('status')
                            ->options([
                                'paid' => 'Dibayar',
                                'unpaid' => 'Belum Dibayar',
                            ])
                            ->required()
                            ->helperText('Tentukan status pembayaran gaji.'),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('Detail opsional tentang pembayaran gaji.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Gaji'),
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
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'warning',
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
            'index' => Pages\ListGajis::route('/'),
            'create' => Pages\CreateGaji::route('/create'),
            'edit' => Pages\EditGaji::route('/{record}/edit'),
        ];
    }
}
