<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlQuranLearningSubcategoryResource\Pages;
use App\Models\AlQuranLearningSubcategory;
use App\Models\AlQuranLearningCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlQuranLearningSubcategoryResource extends Resource
{
   protected static ?string $model = AlQuranLearningSubcategory::class;
   protected static ?string $navigationGroup = 'Al-Quran Course';
   protected static ?string $navigationLabel = 'Al-Quran Sub-Categories';
   protected static ?string $navigationIcon = 'heroicon-o-document-text';
   protected static ?int $navigationSort = 2;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Select::make('category_id')
               ->label('Kategori')
               ->options(AlQuranLearningCategory::all()->pluck('nama', 'id'))
               ->required()
               ->searchable(),
            TextInput::make('sub_nama')
               ->label('Nama Subkategori')
               ->required()
               ->maxLength(255),

            TextInput::make('tahun_ajaran')
               ->label('Tahun Ajaran')
               ->required()
               ->placeholder('Contoh: 2023/2024')
               ->maxLength(20),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            TextColumn::make('category.nama')
               ->label('Kategori')
               ->searchable()
               ->sortable(),
            TextColumn::make('sub_nama')
               ->label('Nama Subkategori')
               ->searchable()
               ->sortable(),
            TextColumn::make('tahun_ajaran')
               ->label('Tahun Ajaran')
               ->searchable()
               ->sortable(),

            TextColumn::make('created_at')
               ->dateTime('d M Y')
               ->sortable(),

         ])
         ->filters([
            Tables\Filters\TrashedFilter::make(),
         ])
         ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\RestoreAction::make(),
         ])
         ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
               Tables\Actions\DeleteBulkAction::make(),
               Tables\Actions\RestoreBulkAction::make(),
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
         'index' => Pages\ListAlQuranLearningSubcategories::route('/'),
         'create' => Pages\CreateAlQuranLearningSubcategory::route('/create'),
         'edit' => Pages\EditAlQuranLearningSubcategory::route('/{record}/edit'),
      ];
   }

   public static function getEloquentQuery(): Builder
   {
      return parent::getEloquentQuery()
         ->withoutGlobalScopes([
            SoftDeletingScope::class,
         ]);
   }
}
