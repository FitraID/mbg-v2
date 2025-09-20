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

class PotongansRelationManager extends RelationManager
{
    protected static string $relationship = 'Potongan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                ->label('Nama Pendapatan')
                ->required()
                ->maxLength(255),
            TextInput::make('jumlah')
                ->label('Jumlah (Rp) / %')
                ->required()
                ->numeric()
                ->placeholder('contoh: 500000'),
            Select::make('status')
                ->options([
                    'hari' => 'Potongan Keterlambatan',
                ])
                ->required()
                ->default('hari'),
            Select::make('keterangan')
                ->options([
                    'persen' => 'Di Potong % Dari Gaji Pokok',
                    'fix' => 'Di Sesuai Nominal Yang Di Tetapkan',
                ])
                ->required()
                ->default('bulan'),
        ])
        ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('potongans')
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR')
                ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('keterangan')
                ->label('Di Berikan'),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
