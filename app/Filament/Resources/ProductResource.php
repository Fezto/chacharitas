<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ColorsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\GendersRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SizesRelationManager;
use App\Models\Color;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductResource extends Resource
{
    protected static ?string $navigationGroup = 'Principales';
    protected static ?string $modelLabel = 'producto';
    protected static ?string $pluralModelLabel = 'productos';
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Datos principales')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Precio')
                            ->required()
                            ->numeric()
                            ->prefix('$'),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad')
                            ->required()
                            ->numeric(),

                        Forms\Components\Select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'name')
                            ->required()
                            ->suffixAction(Forms\Components\Actions\Action::make('Colocar usuario actual')
                                ->label('Colocar usuario actual')
                                ->icon('heroicon-o-user')
                                ->action(function (Forms\Components\Actions\Action $action, $state, callable $set) {
                                    $set('user_id', Auth::user()->id); // Establece el usuario actual
                                })
                            ),

                        Forms\Components\FileUpload::make('image')
                            ->label('Imagen del producto')
                            ->image()
                            ->disk('product_images') // Tu disco personalizado
                            ->maxSize(2048) // Tamaño máximo en KB
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción del producto')
                            ->autosize()
                            ->maxLength(500)
                            ->helperText('El máximo es de 500 carácteres')


                    ])->columns(1),

                Wizard\Step::make('Detalles del producto')
                    ->icon('heroicon-m-cog')
                    ->schema([
                        Forms\Components\Select::make('brand_id')
                            ->label('Marca')
                            ->relationship('brand', 'name')
                            ->required(),

                        Forms\Components\Select::make('categories')
                            ->multiple()
                            ->label('Categorías')
                            ->relationship('categories', 'name')
                            ->required()
                            ->preload(),

                        Forms\Components\Select::make('colors')
                            ->multiple()
                            ->label('Colores')
                            ->relationship('colors', 'name')
                            ->required()
                            ->preload(),

                        Forms\Components\Select::make('materials')
                            ->multiple()
                            ->label('Materiales')
                            ->relationship('materials', 'name')
                            ->preload(),

                        Forms\Components\Select::make('sizes')
                            ->multiple()
                            ->label('Tamaños')
                            ->relationship('sizes', 'name'),
                    ]),
            ])->columnSpanFull()
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario'),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca'),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            ColorsRelationManager::class,
            CategoriesRelationManager::class,
            GendersRelationManager::class,
            ColorsRelationManager::class,
            SizesRelationManager::class,
        ];
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
