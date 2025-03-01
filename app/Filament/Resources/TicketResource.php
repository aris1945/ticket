<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Pages\ListTicket;
use App\Models\Ticket;
use App\Filament\Resources\TicketResource\Pages\CreateTicket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use GuzzleHttp\Promise\Create;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Spatie\Permission\Traits\HasRoles;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TicketResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Ticket';

    public static function canCreate(): bool
    {
        return !auth()->user()->hasRole('teknisi');
    }

    public static function form(Form $form): Form
    {
        $isEditing = $form->getOperation() === 'edit';
        $user = Auth::user();
        $isTeknisi = $user->hasRole('teknisi');
        return $form
            ->schema([
                Section::make('Create New Ticket')
                    ->schema([
                        TextInput::make('ticket_number')
                            ->required()
                            ->disabled($isEditing && $isTeknisi),
                        Select::make('category')
                            ->options([
                                'psb' => 'PSB',
                                'ggn' => 'GGN',
                                'preventive' => 'PREVENTIVE',
                                'exbis' => 'EXBIS',
                                'lainnya' => 'LAINNYA'
                            ])
                            ->disabled($isEditing && $isTeknisi),
                        Select::make('subcategory')
                            ->options([
                                'node_b' => 'NODE-B',
                                'olo' => 'OLO',
                                'patroli' => 'PATROLI',
                                'mitratel' => 'MITRATEL',
                                'lintasarta' => 'LINTASARTA',
                                'tis' => 'TIS'
                            ])
                            ->disabled($isEditing && $isTeknisi),
                        TextArea::make('description')
                            ->label('Description'),
                        TextInput::make('status')
                            ->disabled()
                            ->placeholder('assigned'),
                        Select::make('assigned_to')
                            ->options(User::all()->mapWithKeys(function ($user) {
                                return [$user->nik => "{$user->nik} - {$user->name}"];
                            }))
                            ->label('Assigned To')
                            ->required()
                            ->disabled($isEditing && $isTeknisi)
                            ->placeholder('Select User'),
                        FileUpload::make('evident_image')
                            ->label('Evident Image')
                            ->disk('public')
                            ->directory('evident_images')
                            ->visibility('public')
                            ->required(fn () => auth()->user()->hasRole('teknisi'))
                            ->image()
                            ->maxSize(5120)
                            ->imagePreviewHeight('250')
                            ->downloadable()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->preserveFilenames()
                            ->visible(function ($record) {
                                return auth()->user()->hasRole('teknisi') && 
                                       $record && 
                                       $record->status === 'assigned';
                            })
                            ->mutateDehydratedStateUsing(function ($state, $record) {
                                if ($state && auth()->user()->hasRole('teknisi')) {
                                    $record->status = 'done';
                                }
                                return $state;
                            }),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Menentukan query berdasarkan peran pengguna
        $query = Ticket::query();

        // Jika pengguna adalah helpdesk atau super_admin, ambil semua tiket
        if ($user->hasRole('helpdesk') || $user->hasRole('super_admin')) {
            // Tidak ada filter, ambil semua tiket
        } else {
            // Jika bukan, hanya ambil tiket yang ditugaskan kepada pengguna
            $query->where('assigned_to', $user->nik);
        }


        return $table
            ->query($query)
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket Number')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Category')
                    ->searchable(),
                TextColumn::make('subcategory')
                    ->label('Subcategory')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->status === 'done' ? 'success' : 'warning')
                    ->searchable(),
                TextColumn::make('assigned_to')
                    ->label('Assigned To')
                    ->searchable()
                    ->getStateUsing(function (Ticket $record) {
                        return $record->user ? "{$record->user->nik} - {$record->user->name}" : 'Unassigned';
                    }),
                TextColumn::make('description')
                    ->label('Description'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->searchable(),
                ImageColumn::make('evident_image')
                    ->label('Evident Image')
                    ->disk('public')
                    ->visibility('public')
                    ->url(fn($record) => $record->evident_image ? Storage::disk('public')->url($record->evident_image) : null),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'assigned' => 'Assigned',
                        'done' => 'Done',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => 
                        !auth()->user()->hasRole('teknisi') || 
                        ($record->status === 'assigned')
                    ),
                ...(Auth::user()->hasRole('teknisi') ? [] : [Tables\Actions\DeleteAction::make()]),
            ])
            ->bulkActions(
                Auth::user()->hasRole('teknisi') ? [] : [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTicket::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
