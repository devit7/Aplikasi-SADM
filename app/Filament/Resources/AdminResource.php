<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->placeholder('Contoh: Budi Santoso, S.Pd'),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->unique(
                        table: 'users',
                        column: 'email',
                        ignoreRecord: true,
                        modifyRuleUsing: function ($rule) {
                            return $rule->where('role', 'admin');
                        }
                    )
                    ->placeholder('Contoh: budi.santoso@gmail.com'),
                TextInput::make('password')
                    ->label('Password')
                    ->required()
                    ->placeholder('Contoh: BudiS123#')
                    ->minLength(5)
                    ->password()
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                        $component->state('');
                    })
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn($livewire) => ($livewire instanceof CreateRecord)),
                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->required()
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->native(false)
                    ->maxDate(now()->subYears(20))
                    ->placeholder('Contoh: May 5, 2005'),
                TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->placeholder('Contoh: Jakarta'),
                TextInput::make('no_hp')
                    ->label('No HP')
                    ->maxLength(12)
                    ->minLength(10)
                    ->required()
                    ->numeric()
                    ->placeholder('Contoh: 081234567890'),
                Textarea::make('alamat')
                    ->label('Alamat')
                    ->maxLength(200)
                    ->required()
                    ->placeholder('Contoh: Jl. Raya Bogor No. 123, RT 01/RW 02, Kec. Bogor Tengah, Kota Bogor'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Admin::where('role', '!=', 'walikelas'))
            ->columns([
                //
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tempat_lahir')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_lahir')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
