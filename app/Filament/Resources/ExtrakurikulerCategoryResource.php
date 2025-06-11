<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtrakurikulerCategoryResource\Pages;
use App\Models\ExtrakurikulerCategory;
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

class ExtrakurikulerCategoryResource extends Resource
{
   protected static ?string $model = ExtrakurikulerCategory::class;
   protected static ?string $navigationGroup = 'Ekstrakurikuler Course';
   protected static ?string $navigationLabel = 'Ekstrakurikuler';
   protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
   protected static ?int $navigationSort = 3;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            TextInput::make('nama')
               ->label('Nama Kategori')
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
            TextColumn::make('nama')
               ->label('Nama Ekstrakurikuler')
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
         'index' => Pages\ListExtrakurikulerCategories::route('/'),
         'create' => Pages\CreateExtrakurikulerCategory::route('/create'),
         'edit' => Pages\EditExtrakurikulerCategory::route('/{record}/edit'),
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
