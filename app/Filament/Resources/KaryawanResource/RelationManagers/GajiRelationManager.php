<?php

namespace App\Filament\Resources\KaryawanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class GajiRelationManager extends RelationManager
{
    protected static string $relationship = 'Pendapatan';

    protected static ?string $label = 'Pendapatan';
    protected static ?string $pluralLabel = 'Gaji';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                ->label('Nama Pendapatan')
                ->required()
                ->maxLength(255)
                ->disabled(fn ($record) => $record?->keterangan === 'Gaji_Pokok'),
            TextInput::make('jumlah')
                ->label('Jumlah (Rp)')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->placeholder('contoh: 500000'),
            Select::make('status')
                ->options([
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                ])
                ->required()
                ->default('active')
                ->disabled(fn ($record) => $record?->keterangan === 'Gaji_Pokok'),
            Select::make('keterangan')
                ->options([
                    'bulan' => 'Di Berikan Bulan an',
                    'minggu' => 'Di Berikan Minggu an',
                    'hari' => 'Di Berikan Hari an',
                ])
                ->required()
                ->default('bulan')
                ->disabled(fn ($record) => $record?->keterangan === 'Gaji_Pokok'),
        ])
        ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Gaji')
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR')
                ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('keterangan')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'Gaji_Pokok' => 'Bulan an',
                    'bulan' => 'Bulan an',
                    'hari' => 'Hari an',
                    'minggu' => 'Minggu an',
                    default => $state,
                })
                ->label('Di Berikan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ->visible(fn ($record) => $record?->keterangan !== 'Gaji_Pokok'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
