<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffAccesResource\Pages;
use App\Filament\Resources\StaffAccesResource\RelationManagers;
use App\Models\Matapelajaran;
use App\Models\StaffAcces;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class StaffAccesResource extends Resource
{
    protected static ?string $model = StaffAcces::class;
    protected static ?string $navigationGroup = 'Staff Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('staff_id')
                    ->label('Staff')
                    ->preload()
                    ->searchable()
                    ->searchDebounce(200)
                    ->relationship('staff', 'nama')
                    ->required(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->preload()
                    ->searchable()
                    ->searchDebounce(200)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(callable $set) => $set('matapelajaran_id', null)),

                Select::make('matapelajaran_id')
                    ->label('Mata Pelajaran')
                    ->options(function (callable $get) {
                        $kelasId = $get('kelas_id');

                        if (!$kelasId) { // jika kelas_id tidak ada
                            return [];
                        }

                        return Matapelajaran::where('kelas_id', $kelasId)
                            ->get()
                            ->mapWithKeys(function ($matapelajaran) {
                                return [$matapelajaran->id => $matapelajaran->nama_mapel . ' - ' . $matapelajaran->semester];
                            });
                    })
                    ->searchable()
                    ->disabled(fn(callable $get) => !$get('kelas_id')),

                Section::make('Hak Akses')
                    ->description('Pilih 1 atau lebih hak akses yang diberikan kepada staff')
                    ->schema([
                        Checkbox::make('akses_nilai')
                            ->label('Akses Nilai'),
                        Checkbox::make('akses_absen')
                            ->label('Akses Absen'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('staff.nama')
                    ->label('Staff'),
                TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),
                TextColumn::make('matapelajaran.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->matapelajaran->nama_mapel . ' - ' . $record->matapelajaran->semester;
                    }),
                IconColumn::make('akses_nilai')
                    ->label('Akses Nilai')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('akses_absen')
                    ->label('Akses Absen')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListStaffAcces::route('/'),
            'create' => Pages\CreateStaffAcces::route('/create'),
            'edit' => Pages\EditStaffAcces::route('/{record}/edit'),
        ];
    }
}
