<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PotonganResource\Pages;
use App\Models\Potongan;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PotonganResource extends Resource
{
    protected static ?string $model = Potongan::class;
    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';
    protected static ?string $pluralModelLabel = 'Potongan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('id_pegawai')
                            ->label('Karyawan')
                            ->relationship('karyawan', 'nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Pilih karyawan yang dikenai potongan ini.'),
                        TextInput::make('nama')
                            ->label('Nama Potongan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Denda Keterlambatan, Cuti Tanpa Bayar'),
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->prefix('IDR')
                            ->required()
                            ->placeholder('contoh: 50000'),
                        Select::make('status')
                            ->options([
                                'applied' => 'Diterapkan',
                                'pending' => 'Tertunda',
                            ])
                            ->required()
                            ->helperText('Pilih status potongan saat ini.'),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('Detail opsional tentang potongan.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Potongan'),
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
                TextColumn::make('nama')
                    ->label('Nama Potongan')
                    ->searchable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'applied' => 'success',
                        'pending' => 'warning',
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
            'index' => Pages\ListPotongans::route('/'),
            'create' => Pages\CreatePotongan::route('/create'),
            'edit' => Pages\EditPotongan::route('/{record}/edit'),
        ];
    }
}
