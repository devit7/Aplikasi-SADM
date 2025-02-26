<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatapelajaranResource\Pages;
use App\Filament\Resources\MatapelajaranResource\RelationManagers;
use App\Models\Matapelajaran;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatapelajaranResource extends Resource
{
    protected static ?string $model = Matapelajaran::class;

    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ? string $navigationLabel = 'Matapelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('nama_mapel')
                    ->label('Nama Mapel')
                    ->required()
                    ->placeholder('Masukkan Nama Mapel'),
                TextInput::make('kode_mapel')
                    ->label('Kode Mapel')
                    ->required()
                    ->placeholder('Masukkan Kode Mapel'),
                Select::make('kelas_id')
                    ->searchable()
                    ->searchDebounce(200)
                    ->label('Kelas')
                    ->preload()
                    ->required()
                    ->relationship('kelas', 'nama_kelas')
                    ->placeholder('Masukkan Kelas'),
                Select::make('semester')
                    ->label('Semester')
                    ->required()
                    ->options([
                        'ganjil' => 'Ganjil',
                        'genap' => 'Genap',
                    ]),
                TextInput::make('kkm')
                    ->label('KKM')
                    ->required()
                    ->placeholder('Masukkan KKM'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama_mapel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kode_mapel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kelas_id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kelas.nama_kelas')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('semester')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kkm')
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
            'index' => Pages\ListMatapelajarans::route('/'),
            'create' => Pages\CreateMatapelajaran::route('/create'),
            'edit' => Pages\EditMatapelajaran::route('/{record}/edit'),
        ];
    }
}
