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
               ->label('Sub-kategori')
               ->options(function() {
                  // Memastikan bahwa 'sub_nama' adalah field yang benar
                  // dan juga memastikan tidak ada nilai null yang diteruskan
                  return AlQuranLearningSubcategory::all()->mapWithKeys(function ($subcategory) {
                     // Menggunakan sub_nama dan memastikan nilainya tidak null
                     $nama = $subcategory->sub_nama ?? '(Nama tidak tersedia)';
                     return [$subcategory->id => $nama];
                  });
               })
               ->searchable()
               ->required(),
            Select::make('siswa_id')
               ->label('Siswa')
               ->options(function() {
                  // Memastikan bahwa 'nama' adalah field yang benar
                  return Siswa::all()->mapWithKeys(function ($siswa) {
                     $nama = $siswa->nama ?? '(Nama tidak tersedia)';
                     return [$siswa->id => $nama];
                  });
               })
               ->searchable()
               ->required(),
            Select::make('predicate')
               ->label('Predikat')
               ->options([
                  'A' => 'A (Sangat Baik)',
                  'B' => 'B (Baik)',
                  'C' => 'C (Cukup)',
                  'D' => 'D (Kurang)',
                  'E' => 'E (Sangat Kurang)',
               ])
               ->required(),
            TextInput::make('explanation')
               ->label('Explanation')
               ->placeholder('Misalnya: Excellent, Good, Enough, dll')
               ->maxLength(255),
            Textarea::make('notes')
               ->label('Internal Notes')
               ->placeholder('Catatan internal (tidak ditampilkan ke siswa/orangtua)')
               ->maxLength(500),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            TextColumn::make('subcategory.sub_nama') // Pastikan menggunakan sub_nama bukan nama
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
         'index' => Pages\ListAlQuranStudentAssessments::route('/'),
         'create' => Pages\CreateAlQuranStudentAssessment::route('/create'),
         'edit' => Pages\EditAlQuranStudentAssessment::route('/{record}/edit'),
      ];
   }
}
