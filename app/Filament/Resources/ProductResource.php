<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Товары';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->guard()->user();
        return $user && in_array($user->role, ['admin', 'seller']);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->guard()->user();
        if ($user && $user->role === 'seller') {
            $query->whereHas('seller', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->createOptionForm([
                        Forms\Components\TextInput::make('shop_name')
                            ->label('Название магазина')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email контакта')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон')
                            ->tel(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $seller = \App\Models\Seller::create($data);
                        return $seller->id;
                    })
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('seller_id', $state)),

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

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),

                Tables\Columns\TextColumn::make('seller.shop_name')
                    ->label('Продавец')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money('KZT')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Склад')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getModel(): string
    {
        return Product::class;
    }

    public static function getPolicy(): ?string
    {
        return \App\Policies\ProductPolicy::class;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
