<?php

namespace App\Filament\Resources\EditProfileResource\Pages;

use App\Filament\Resources\EditProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEditProfile extends CreateRecord
{
    protected static string $resource = EditProfileResource::class;
}
