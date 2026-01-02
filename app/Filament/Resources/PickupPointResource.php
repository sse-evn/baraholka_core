<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PickupPointResource\Pages;
use App\Models\PickupPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Humaidem\FilamentMapPicker\Fields\OSMMap;

class PickupPointResource extends Resource
{
    protected static ?string $model = PickupPoint::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Регион';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('address')
                ->label('Адрес')
                ->required()
                ->maxLength(255),
                
OSMMap::make('location')
    ->label('Расположение на карте')
    ->showMarker()
    ->draggable()
    ->zoom(13)
    ->maxZoom(18)
    ->tilesUrl('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),

            Forms\Components\Toggle::make('is_active')
                ->label('Активен')
                ->default(true),
        ]);
    }


        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->label('Название')
                        ->searchable(),

                    Tables\Columns\TextColumn::make('address')
                        ->label('Адрес')
                        ->searchable(),

                    Tables\Columns\IconColumn::make('is_active')
                        ->label('Статус')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])
                ->filters([
                    Tables\Filters\SelectFilter::make('is_active')
                        ->label('Статус')
                        ->options([
                            1 => 'Активные',
                            0 => 'Неактивные',
                        ]),
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
            return [];
        }

        public static function getPages(): array
        {
            return [
                'index'  => Pages\ListPickupPoints::route('/'),
                'create' => Pages\CreatePickupPoint::route('/create'),
                'edit'   => Pages\EditPickupPoint::route('/{record}/edit'),
            ];
        }
    }
