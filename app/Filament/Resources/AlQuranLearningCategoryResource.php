<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlQuranLearningCategoryResource\Pages;
use App\Models\AlQuranLearningCategory;
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

class AlQuranLearningCategoryResource extends Resource
{
   protected static ?string $model = AlQuranLearningCategory::class;
   protected static ?string $navigationGroup = 'Al-Quran Course';
   protected static ?string $navigationLabel = 'Al-Quran Learning';
   protected static ?string $navigationIcon = 'heroicon-o-book-open';
   protected static ?int $navigationSort = 1;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            TextInput::make('nama')
               ->label('Nama Kategori')
               ->required()
               ->maxLength(255),
            Textarea::make('deskripsi')
               ->label('Deskripsi')
               ->maxLength(65535)
               ->columnSpanFull(),
            TagsInput::make('predicates')
               ->label('Predikat (A, B, C, D, E)')
               ->placeholder('Tambahkan predikat')
               ->helperText('Tekan Enter untuk menambahkan predikat baru'),
            TagsInput::make('explanations')
               ->label('Penjelasan (Excellent, Good, Enough, dll)')
               ->placeholder('Tambahkan penjelasan')
               ->helperText('Tekan Enter untuk menambahkan penjelasan baru'),
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
            TextColumn::make('deskripsi')
               ->label('Deskripsi')
               ->limit(50)
               ->searchable(),
            TextColumn::make('predicates')
               ->label('Predikat')
               ->formatStateUsing(fn(string $state): string => implode(', ', json_decode($state, true) ?? [])),
            TextColumn::make('created_at')
               ->label('Dibuat')
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
         'index' => Pages\ListAlQuranLearningCategories::route('/'),
         'create' => Pages\CreateAlQuranLearningCategory::route('/create'),
         'edit' => Pages\EditAlQuranLearningCategory::route('/{record}/edit'),
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
