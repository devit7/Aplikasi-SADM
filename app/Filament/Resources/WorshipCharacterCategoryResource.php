<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorshipCharacterCategoryResource\Pages;
use App\Models\WorshipCharacterCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorshipCharacterCategoryResource extends Resource
{
   protected static ?string $model = WorshipCharacterCategory::class;
   protected static ?string $navigationGroup = 'Worship and Character Course';
   protected static ?string $navigationLabel = 'Worship and Character';
   protected static ?string $navigationIcon = 'heroicon-o-sparkles';
   protected static ?int $navigationSort = 4;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            TextInput::make('nama')
               ->label('Nama Kategori')
               ->required()
               ->maxLength(255),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            TextColumn::make('nama')
               ->label('Nama Kategori')
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
         'index' => Pages\ListWorshipCharacterCategories::route('/'),
         'create' => Pages\CreateWorshipCharacterCategory::route('/create'),
         'edit' => Pages\EditWorshipCharacterCategory::route('/{record}/edit'),
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
