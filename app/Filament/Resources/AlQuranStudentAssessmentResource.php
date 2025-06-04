<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlQuranStudentAssessmentResource\Pages;
use App\Models\AlQuranStudentAssessment;
use App\Models\AlQuranLearningSubcategory;
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

class AlQuranStudentAssessmentResource extends Resource
{
   protected static ?string $model = AlQuranStudentAssessment::class;
   protected static ?string $navigationGroup = 'Al-Quran Course';
   protected static ?string $navigationLabel = 'Al-Quran Assessments';
   protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
   protected static ?int $navigationSort = 5;

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Select::make('subcategory_id')
               ->label('Subkategori')
               ->options(AlQuranLearningSubcategory::all()->pluck('nama', 'id'))
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
               ->label('Penjelasan')
               ->placeholder('Misalnya: Excellent, Good, Enough, dll')
               ->maxLength(255),
            Textarea::make('notes')
               ->label('Catatan')
               ->placeholder('Tambahkan catatan tambahan jika perlu')
               ->maxLength(65535),
            Select::make('created_by')
               ->label('Dibuat oleh')
               ->options(User::all()->pluck('name', 'id'))
               ->default(Auth::id()),
            Select::make('updated_by')
               ->label('Diperbarui oleh')
               ->options(User::all()->pluck('name', 'id'))
               ->default(Auth::id()),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            TextColumn::make('subcategory.nama')
               ->label('Subkategori')
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
               ->label('Penjelasan')
               ->searchable(),
            TextColumn::make('user_creator.name')
               ->label('Dibuat oleh')
               ->searchable()
               ->sortable(),
            TextColumn::make('created_at')
               ->label('Tanggal')
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
         'index' => Pages\ListAlQuranStudentAssessments::route('/'),
         'create' => Pages\CreateAlQuranStudentAssessment::route('/create'),
         'edit' => Pages\EditAlQuranStudentAssessment::route('/{record}/edit'),
      ];
   }
}
