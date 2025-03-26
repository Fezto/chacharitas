<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class ProductForm extends Component implements HasForms
{
    use InteractsWithForms;

    public array $state = [];
    // No es necesario declarar $uploaded_images como propiedad separada
    public Product $product; // Modelo de producto

    public function mount(): void
    {
        $this->product = new Product();
        $this->form->fill($this->product->toArray());
        $this->form->model($this->product);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model($this->product)
            ->statePath('state')
            ->schema([
                \Filament\Forms\Components\Wizard::make([
                    // Primer paso: Datos Principales
                    \Filament\Forms\Components\Wizard\Step::make('Datos Principales')
                        ->icon('heroicon-m-information-circle')
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('name')
                                ->label('Nombre del producto')
                                ->required()
                                ->maxLength(255),

                            \Filament\Forms\Components\TextInput::make('price')
                                ->label('Precio')
                                ->required()
                                ->numeric()
                                ->prefix('$'),

                            \Filament\Forms\Components\TextInput::make('quantity')
                                ->label('Cantidad')
                                ->required()
                                ->numeric(),

                            // Usamos 'uploaded_images' para evitar conflicto con la relación "images"
                            \Filament\Forms\Components\FileUpload::make('uploaded_images')
                                ->label('Imágenes del producto')
                                ->image()
                                ->disk('product_images') // Usa el disco configurado
                                ->directory('temp') // Carpeta temporal
                                ->multiple()
                                ->maxFiles(5)
                                ->panelLayout('grid')
                                ->required(),

                            \Filament\Forms\Components\Textarea::make('description')
                                ->label('Descripción del producto')
                                ->autosize()
                                ->maxLength(500)
                                ->helperText('Máximo 500 carácteres')
                                ->required(),
                        ])->columns(1),

                    // Segundo paso: Detalles del producto
                    \Filament\Forms\Components\Wizard\Step::make('Detalles del producto')
                        ->icon('heroicon-m-cog')
                        ->schema([
                            \Filament\Forms\Components\Select::make('brand_id')
                                ->label('Marca')
                                ->relationship('brand', 'name')
                                ->required(),

                            \Filament\Forms\Components\Select::make('categories')
                                ->multiple()
                                ->label('Categorías')
                                ->relationship('categories', 'name')
                                ->preload()
                                ->required(),

                            \Filament\Forms\Components\Select::make('colors')
                                ->multiple()
                                ->label('Colores')
                                ->relationship('colors', 'name')
                                ->preload()
                                ->required(),

                            \Filament\Forms\Components\Select::make('materials')
                                ->multiple()
                                ->label('Materiales')
                                ->relationship('materials', 'name')
                                ->preload(),

                            \Filament\Forms\Components\Select::make('sizes')
                                ->multiple()
                                ->label('Tamaños')
                                ->relationship('sizes', 'name'),
                        ]),
                ])
                    ->submitAction(new HtmlString("<button class='btn btn-secondary'>Publicar Producto</button>"))
                    ->cancelAction(new HtmlString("<button type='button' wire:click='cancel' class='btn btn-primary'>Cancelar</button>"))
                    ->nextAction(fn(\Filament\Forms\Components\Actions\Action $action) => $action->label('Siguiente')->color('secondary'))
                    ->previousAction(fn(\Filament\Forms\Components\Actions\Action $action) => $action->label('Regresar')->color('primary'))
                    ->columnSpanFull()
            ]);
    }

    public function submit()
    {
        // Obtener los datos del formulario
        $data = $this->form->getState();

        // Agregar el ID del usuario actual
        $data['user_id'] = Auth::id();

        // Extraer las imágenes subidas desde el state
        $uploadedImages = $data['uploaded_images'] ?? [];
        unset($data['uploaded_images']);

        // Crear el producto en la base de datos (sin imágenes aún)
        $product = Product::create($data);

        // Definir la carpeta del producto dentro de "img/products"
        $productFolder = "p_{$product->id}";

        // Mover las imágenes a la carpeta específica del producto
        $finalImagePaths = [];
        foreach ($uploadedImages as $imagePath) {
            $newPath = "{$productFolder}/" . basename($imagePath);
            // Mover la imagen a la nueva ubicación
            \Storage::disk('product_images')->move($imagePath, $newPath);

            // Guardar la nueva ruta en la base de datos
            $product->images()->create(['url' => $newPath]);
        }

        session()->flash('success', 'Producto publicado correctamente.');
        return redirect()->route('shop.index');
    }

    public function cancel()
    {
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
