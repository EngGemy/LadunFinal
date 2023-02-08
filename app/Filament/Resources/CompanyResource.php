<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Concerns\Translatable;

class CompanyResource extends Resource
{
    use Translatable;

    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static ?string $navigationGroup = 'Companies Managemnt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('title')->label('title')->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })->required(),
                TextInput::make('slug')->required(),
             SpatieMediaLibraryFileUpload::make('thumbnail')->collection('companies'),
                RichEditor::make('content'),


                Toggle::make('is_published'),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->limit('50')->sortable(),
                Tables\Columns\TextColumn::make('slug')->limit('50'),
                Tables\Columns\BooleanColumn::make('is_published'),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('companies'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Companies');
    }

    public static function getLabel(): ?string
    {
        return __('Company');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Company');
    }
}
