<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class SignaturePad extends Field
{
    protected string $view = 'filament.forms.components.signature-pad';

    protected int $width = 500;
    protected int $height = 200;
    protected string $penColor = '#000000';
    protected string $backgroundColor = '#ffffff';

    public function width(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function penColor(string $color): static
    {
        $this->penColor = $color;
        return $this;
    }

    public function backgroundColor(string $color): static
    {
        $this->backgroundColor = $color;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getPenColor(): string
    {
        return $this->penColor;
    }

    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }
}
