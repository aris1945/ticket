<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeringkatResource\Pages;
use App\Filament\Resources\PeringkatResource\RelationManagers;
use App\Models\Peringkat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeringkatResource extends Resource
{
    protected static ?string $model = Peringkat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                ->label('NIK'),
                TextColumn::make('nama')
                ->label('Nama'),
                TextColumn::make('total')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPeringkats::route('/'),
            'create' => Pages\CreatePeringkat::route('/create'),
            'edit' => Pages\EditPeringkat::route('/{record}/edit'),
        ];
    }
}
