<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Data Siswa')
                    ->description('Isi Data Siswa Dengan Benar')
                    ->schema([
                        TextInput::make('nis')
                            ->label('NIS')
                            ->required()
                            ->numeric()
                            ->length(5)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: 13579'),
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->length(10)
                            ->numeric()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: 0098765432'),
                        TextInput::make('nama')
                            ->label('Nama')
                            ->required()
                            ->placeholder('Contoh: Anisa Putri'),
                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->required()
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ]),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required()
                            ->placeholder('Contoh: Bandung'),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->native(false)
                            ->maxDate(now()->subYears(6))
                            ->placeholder('Masukkan Tanggal Lahir'),
                        DatePicker::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->required()
                            ->native(false)
                            ->placeholder('Masukkan Tanggal Masuk'),
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(200)
                            ->placeholder('Contoh: Jl. Sudirman No. 45, RT 03/RW 04, Kec. Cicendo, Kota Bandung'),

                    ])->columnSpan(1)->columns(1),
                Section::make('Data Orang Tua')
                    ->description('Data Orang Tua Siswa')
                    ->schema([
                        TextInput::make('nama_bapak')
                            ->label('Nama Bapak')
                            ->required()
                            ->placeholder('Contoh: Drs. Agus Supriyanto'),
                        TextInput::make('nama_ibu')
                            ->label('Nama Ibu')
                            ->required()
                            ->placeholder('Contoh: Sri Wahyuni, S.E.'),
                        TextInput::make('pekerjaan_bapak')
                            ->label('Pekerjaan Bapak')
                            ->required()
                            ->placeholder('Contoh: Pegawai Swasta'),
                        TextInput::make('pekerjaan_ibu')
                            ->label('Pekerjaan Ibu')
                            ->required()
                            ->placeholder('Contoh: Wiraswasta'),
                        TextInput::make('no_hp_bapak')
                            ->label('No HP Bapak')
                            ->numeric()
                            ->maxLength(12)
                            ->minLength(10)
                            ->required()
                            ->placeholder('Contoh: 081234567890'),
                        TextInput::make('no_hp_ibu')
                            ->label('No HP Ibu')
                            ->numeric()
                            ->maxLength(12)
                            ->minLength(10)
                            ->required()
                            ->placeholder('Contoh: 085678901234'),
                    ])->columnSpan(1)->columns(1),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
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
                TextColumn::make('tanggal_masuk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->searchable()
                    ->sortable(),
                /*                 TextColumn::make('nama_bapak')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_ibu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pekerjaan_bapak')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pekerjaan_ibu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp_bapak')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp_ibu')
                    ->searchable()
                    ->sortable(), */

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
