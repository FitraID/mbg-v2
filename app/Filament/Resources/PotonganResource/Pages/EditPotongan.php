<?php

namespace App\Filament\Resources\PotonganResource\Pages;

use App\Filament\Resources\PotonganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPotongan extends EditRecord
{
    protected static string $resource = PotonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
