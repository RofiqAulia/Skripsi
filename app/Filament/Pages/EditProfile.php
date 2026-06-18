<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getPhotoFormComponent(),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPositionFormComponent(),
                $this->getCompanyFormComponent(),
                $this->getAgeFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
            ]);
    }

    protected function getPhotoFormComponent(): Component
    {
        return FileUpload::make('photo')
            ->label('Profile Photo')
            ->image()
            ->avatar()
            ->disk('public')
            ->directory('profile-photos')
            ->maxSize(2048)
            ->columnSpanFull();
    }

    protected function getPositionFormComponent(): Component
    {
        return TextInput::make('position')
            ->label('Position / Job Title')
            ->maxLength(255);
    }

    protected function getCompanyFormComponent(): Component
    {
        return TextInput::make('company')
            ->label('Company / Organization')
            ->maxLength(255);
    }

    protected function getAgeFormComponent(): Component
    {
        return TextInput::make('age')
            ->label('Age')
            ->numeric()
            ->minValue(1)
            ->maxValue(120);
    }
}
