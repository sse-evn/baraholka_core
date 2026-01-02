<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Товары';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['admin', 'seller']);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();
        if ($user && $user->role === 'seller') {
            $query->whereHas('seller', fn($q) => $q->where('user_id', $user->id));
        }
        return $query;
    }

    public static function form(Form $form): Form
    {
        $user = Auth::user();

        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Описание')
                ->rows(5),

            Forms\Components\TextInput::make('price')
                ->label('Цена')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('stock')
                ->label('Количество на складе')
                ->numeric()
                ->required(),

            Forms\Components\FileUpload::make('image_url')
                ->label('Изображение')
                ->disk('public')
                ->directory('products')
                ->preserveFilenames(),

            Forms\Components\Select::make('category_id')
                ->label('Категория')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('seller_id')
                ->label('Продавец')
                ->relationship('seller', 'shop_name')
                ->searchable()
                ->preload()
                ->required()
                ->visible(fn() => $user?->role === 'admin'),

            Forms\Components\Hidden::make('seller_id')
                ->default(fn() => $user?->role === 'seller' ? optional($user->seller)->id : null),

            Forms\Components\Toggle::make('is_active')
                ->label('Активен')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Категория'),
                Tables\Columns\TextColumn::make('seller.shop_name')->label('Продавец'),
                Tables\Columns\TextColumn::make('price')->label('Цена')->money('KZT'),
                Tables\Columns\TextColumn::make('stock')->label('Склад'),
                Tables\Columns\IconColumn::make('is_active')->label('Активен')->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ProductResource\Pages\ListProducts::route('/'),
            'create' => \App\Filament\Resources\ProductResource\Pages\CreateProduct::route('/create'),
            'edit' => \App\Filament\Resources\ProductResource\Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}