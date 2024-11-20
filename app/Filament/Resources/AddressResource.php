<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddressResource\Pages;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AddressResource extends Resource
{
    protected static ?string $navigationGroup = 'Principales';
    protected static ?string $modelLabel = 'dirección';
    protected static ?string $pluralModelLabel = 'direcciones';
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->schema([
                    // Primera columna con estado, municipio, colonia, y calle
                    Forms\Components\Grid::make(1) // Una columna para los campos de ubicación
                    ->schema([
                        Forms\Components\Select::make('state_id')
                            ->label('Estado')
                            ->relationship('neighborhood.municipality.state', 'name')
                            ->required()
                            ->reactive()
                            ->placeholder('Selecciona un estado')
                            ->dehydrated(false),

                        Forms\Components\Select::make('municipality_id')
                            ->label('Municipio')
                            ->relationship('neighborhood.municipality', 'name', fn(Builder $query, $get) => $query->where('state_id', $get('state_id')))
                            ->required()
                            ->reactive()
                            ->placeholder('Selecciona un municipio')
                            ->dehydrated(false),

                        Forms\Components\Select::make('neighborhood_id')
                            ->label('Colonia')
                            ->relationship('neighborhood', 'name', fn(Builder $query, $get) => $query->where('municipality_id', $get('municipality_id')))
                            ->required()
                            ->placeholder('Selecciona una colonia'),

                        Forms\Components\TextInput::make('street')
                            ->label('Calle')
                            ->placeholder('Introduce el nombre de la calle')
                            ->required()
                            ->maxLength(255),
                    ]),

                    // Segunda columna con número exterior e interior
                    Forms\Components\Grid::make(2) // Dos columnas para estos campos
                    ->schema([
                        Forms\Components\TextInput::make('street_number')
                            ->label('Número Exterior')
                            ->placeholder('Introduce el número exterior')
                            ->required(),

                        Forms\Components\TextInput::make('unit_number')
                            ->label('Número Interior (Opcional)')
                            ->placeholder('Ej.: Departamento 101, Suite 200')
                            ->maxLength(50),
                    ]),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('neighborhood.municipality.state.name')
                    ->label('Estado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('neighborhood.municipality.name')
                    ->label('Municipio')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('neighborhood.name')
                    ->label('Colonia')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('street')
                    ->label('Calle')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('street_number')
                    ->label('Número Exterior')
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_number')
                    ->label('Número Interior')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
