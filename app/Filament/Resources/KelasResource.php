<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\Pages\DeleteSiswa;
use App\Filament\Resources\KelasResource\Pages\ManageSiswa;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->required()
                    ->placeholder('Contoh: X IPA 1')
                    ->unique(
                        table: 'kelas',
                        column: 'nama_kelas',
                        ignoreRecord: true,
                        modifyRuleUsing: function (Unique $rule, callable $get) {
                            return $rule->where('tahun_ajaran', $get('tahun_ajaran'));
                        }
                    ),
                TextInput::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->required()
                    ->placeholder('Contoh: 2023/2024')
                    ->default(function () {
                        $currentYear = now()->year;
                        $nextYear = $currentYear + 1;
                        return $currentYear . '/' . $nextYear;
                    }),
                Select::make('walikelas_id')
                    ->searchable()
                    ->searchDebounce(200)
                    ->label('Wali Kelas')
                    ->required()
                    ->preload()
                    ->relationship('user', 'name')
                    ->placeholder('Contoh: Budi Santoso, S.Pd'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama_kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tahun_ajaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('siswa_count')->counts('siswa')
                    ->label('Jumlah Siswa')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('add_siswa')
                    ->label('Tambah Siswa')
                    ->icon('heroicon-o-user-plus')
                    ->color('success')
                    ->url(fn($record) => Pages\AddSiswa::getUrl(['record' => $record->id]))
                    ->openUrlInNewTab(false), // Agar tetap di tab yang sama
                Action::make('manage_siswa')
                    ->label('Hapus Siswa')
                    ->icon('heroicon-o-user-minus')
                    ->color('info')
                    ->url(fn($record) => DeleteSiswa::getUrl(['record' => $record->id]))
                    ->openUrlInNewTab(false), // Agar tetap di tab yang sama
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
            'manage-siswa' => DeleteSiswa::route('/{record}/manage-siswa'),
            'add-siswa' => Pages\AddSiswa::route('/{record}/add-siswa'),
        ];
    }
}
