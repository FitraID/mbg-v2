<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Models\Karyawan;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralModelLabel = 'Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Karyawan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: John Doe'),
                        TextInput::make('kode_karyawan')
                            ->label('Kode Karyawan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: 94181155'),
                        Select::make('id_cabang')
                            ->label('Cabang')
                            ->relationship('cabang', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih cabang tempat karyawan bekerja.'),
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Manajer, Staf'),
                        Select::make('id_shift')
                            ->label('Shift')
                            ->relationship('shift', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Tetapkan shift untuk karyawan.'),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('Detail opsional tentang karyawan.'),
                        Select::make('status')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Tidak Aktif',
                            ])
                            ->required()
                            ->helperText('Atur status kepegawaian karyawan saat ini.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Karyawan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),
                TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shift.name')
                    ->label('Shift')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
