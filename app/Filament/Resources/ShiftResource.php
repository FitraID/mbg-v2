<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Models\Shift;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $pluralModelLabel = 'Shift';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationGroupIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Shift')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contoh: Shift Pagi, Shift Malam'),
                        TimePicker::make('jam_masuk')
                            ->label('Jam Masuk')
                            ->required()
                            ->helperText('Jam dimulainya shift.'),
                        TimePicker::make('jam_pulang')
                            ->label('Jam Pulang')
                            ->required()
                            ->helperText('Jam berakhirnya shift.'),
                        Select::make('id_cabang')
                            ->label('Cabang')
                            ->relationship('cabang', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih cabang tempat shift ini berlaku.'),
                    ])
                    ->columns(2)
                    ->heading('Detail Shift'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Shift')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk'),
                TextColumn::make('jam_pulang')
                    ->label('Jam Pulang'),
                TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
