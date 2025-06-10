<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorshipStudentAssessmentResource\Pages;
use App\Models\WorshipStudentAssessment;
use App\Models\WorshipCharacterCategory;
use App\Models\Siswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WorshipStudentAssessmentResource extends Resource
{
   protected static ?string $model = WorshipStudentAssessment::class;
   protected static ?string $navigationGroup = 'Worship and Character Course';
   protected static ?string $navigationLabel = 'Worship and Character Assessments';
   protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
   protected static ?int $navigationSort = 7;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Select::make('category_id')
               ->label('Kategori')
               ->options(WorshipCharacterCategory::all()->pluck('nama', 'id'))
               ->searchable()
               ->required(),
            Select::make('siswa_id')
               ->label('Siswa')
               ->options(Siswa::all()->pluck('nama', 'id'))
               ->searchable()
               ->required(),
            TextInput::make('predicate')
               ->label('Predikat (A, B, C, D, E)')
               ->required()
               ->maxLength(5),
            TextInput::make('explanation')
               ->label('Explanation')
               ->placeholder('Misalnya: Excellent, Good, Enough, dll')
               ->maxLength(255),
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
            TextColumn::make('siswa.nama')
               ->label('Siswa')
               ->searchable()
               ->sortable(),
            TextColumn::make('predicate')
               ->label('Predikat')
               ->searchable(),
            TextColumn::make('explanation')
               ->label('Explanation')
               ->searchable(),
            TextColumn::make('created_at')
               ->dateTime('d M Y')
               ->sortable(),
         ])
         ->filters([
            //
         ])
         ->actions([
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
         'index' => Pages\ListWorshipStudentAssessments::route('/'),
         'create' => Pages\CreateWorshipStudentAssessment::route('/create'),
         'edit' => Pages\EditWorshipStudentAssessment::route('/{record}/edit'),
      ];
   }
}
