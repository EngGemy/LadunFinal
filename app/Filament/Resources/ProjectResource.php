<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Columns\IconColumn;
use Filament\Resources\Concerns\Translatable;


class ProjectResource extends Resource
{
    use Translatable;

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
            ->schema([
                TextInput::make('name')->label(__('name'))->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    $set('slug', Str::slug($state));
                })->required(),
            TextInput::make('slug')->required(),
            TextInput::make('phone')
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
            ->required(),
            TextInput::make('email')
->email(),
TextInput::make('address')
->required(),

         SpatieMediaLibraryFileUpload::make('Main_image')->collection('projects'),
         SpatieMediaLibraryFileUpload::make('attachments')
->multiple()
->enableReordering(),
FileUpload::make('Pdf Project')->acceptedFileTypes(['application/pdf'])
->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
    return (string) str($file->getClientOriginalName())->prepend('custom-prefix-');
})->directory('form-attachments'),
            RichEditor::make('content'),


            Toggle::make('is_published')->label(trans('is_published')),


            ])
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('id'))->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('name'))->limit('50')->sortable(),
                Tables\Columns\TextColumn::make('slug')->label(__('slug'))->limit('50'),
                IconColumn::make('is_published')->label(trans('is_published'))->boolean(),
                SpatieMediaLibraryImageColumn::make('Main_image')->label(__('Main_image'))->collection('projects'),


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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }


    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }


    protected static function getNavigationGroup(): ?string
    {
        return __('Projects');
    }

    public static function getLabel(): ?string
    {
        return __('Project');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Project');
    }





}
