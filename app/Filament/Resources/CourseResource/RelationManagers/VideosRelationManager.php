<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class VideosRelationManager extends RelationManager
{
    protected static string $relationship = 'videos';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('episode')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(function (\Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->label('Judul Video')
                    ->placeholder('Judul Video'),
                Forms\Components\TextInput::make('slug')
                    ->placeholder('Slug')
                    ->disabled(),
                Forms\Components\TextInput::make('duration')
                    ->required(),
                Forms\Components\TextInput::make('youtube_id')
                    ->required(),
                Forms\Components\Toggle::make('is_previewable'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('episode'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('duration'),
                Tables\Columns\ToggleColumn::make('is_previewable'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
