<x-base>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                📦 Crear Guía de Envío
            </h1>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">Producto a Enviar</h3>
                <p><strong>{{ $product->name }}</strong></p>
                <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
            </div>

            <form action="{{ route('shipping.store', $product) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Nombre del Destinatario *</label>
                        <input type="text" name="recipient_name" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ old('recipient_name') }}">
                        @error('recipient_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Email del Destinatario *</label>
                        <input type="email" name="recipient_email" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ old('recipient_email') }}">
                        @error('recipient_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Teléfono del Destinatario *</label>
                        <input type="tel" name="recipient_phone" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ old('recipient_phone') }}">
                        @error('recipient_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Código Postal *</label>
                        <input type="text" name="recipient_postal_code" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ old('recipient_postal_code') }}">
                        @error('recipient_postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-2">Dirección Completa *</label>
                    <input type="text" name="recipient_street" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                           placeholder="Calle, número, colonia"
                           value="{{ old('recipient_street') }}">
                    @error('recipient_street')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Ciudad *</label>
                        <input type="text" name="recipient_city" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ old('recipient_city') }}">
                        @error('recipient_city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Estado *</label>
                        <select name="recipient_state" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar estado</option>
                            <option value="AGU" {{ old('recipient_state') == 'AGU' ? 'selected' : '' }}>Aguascalientes</option>
                            <option value="BCN" {{ old('recipient_state') == 'BCN' ? 'selected' : '' }}>Baja California</option>
                            <option value="BCS" {{ old('recipient_state') == 'BCS' ? 'selected' : '' }}>Baja California Sur</option>
                            <option value="CAM" {{ old('recipient_state') == 'CAM' ? 'selected' : '' }}>Campeche</option>
                            <option value="CHP" {{ old('recipient_state') == 'CHP' ? 'selected' : '' }}>Chiapas</option>
                            <option value="CHH" {{ old('recipient_state') == 'CHH' ? 'selected' : '' }}>Chihuahua</option>
                            <option value="CMX" {{ old('recipient_state') == 'CMX' ? 'selected' : '' }}>Ciudad de México</option>
                            <option value="COA" {{ old('recipient_state') == 'COA' ? 'selected' : '' }}>Coahuila</option>
                            <option value="COL" {{ old('recipient_state') == 'COL' ? 'selected' : '' }}>Colima</option>
                            <option value="DUR" {{ old('recipient_state') == 'DUR' ? 'selected' : '' }}>Durango</option>
                            <option value="MEX" {{ old('recipient_state') == 'MEX' ? 'selected' : '' }}>Estado de México</option>
                            <option value="GUA" {{ old('recipient_state') == 'GUA' ? 'selected' : '' }}>Guanajuato</option>
                            <option value="GRO" {{ old('recipient_state') == 'GRO' ? 'selected' : '' }}>Guerrero</option>
                            <option value="HID" {{ old('recipient_state') == 'HID' ? 'selected' : '' }}>Hidalgo</option>
                            <option value="JAL" {{ old('recipient_state') == 'JAL' ? 'selected' : '' }}>Jalisco</option>
                            <option value="MIC" {{ old('recipient_state') == 'MIC' ? 'selected' : '' }}>Michoacán</option>
                            <option value="MOR" {{ old('recipient_state') == 'MOR' ? 'selected' : '' }}>Morelos</option>
                            <option value="NAY" {{ old('recipient_state') == 'NAY' ? 'selected' : '' }}>Nayarit</option>
                            <option value="NLE" {{ old('recipient_state') == 'NLE' ? 'selected' : '' }}>Nuevo León</option>
                            <option value="OAX" {{ old('recipient_state') == 'OAX' ? 'selected' : '' }}>Oaxaca</option>
                            <option value="PUE" {{ old('recipient_state') == 'PUE' ? 'selected' : '' }}>Puebla</option>
                            <option value="QUE" {{ old('recipient_state') == 'QUE' ? 'selected' : '' }}>Querétaro</option>
                            <option value="ROO" {{ old('recipient_state') == 'ROO' ? 'selected' : '' }}>Quintana Roo</option>
                            <option value="SLP" {{ old('recipient_state') == 'SLP' ? 'selected' : '' }}>San Luis Potosí</option>
                            <option value="SIN" {{ old('recipient_state') == 'SIN' ? 'selected' : '' }}>Sinaloa</option>
                            <option value="SON" {{ old('recipient_state') == 'SON' ? 'selected' : '' }}>Sonora</option>
                            <option value="TAB" {{ old('recipient_state') == 'TAB' ? 'selected' : '' }}>Tabasco</option>
                            <option value="TAM" {{ old('recipient_state') == 'TAM' ? 'selected' : '' }}>Tamaulipas</option>
                            <option value="TLA" {{ old('recipient_state') == 'TLA' ? 'selected' : '' }}>Tlaxcala</option>
                            <option value="VER" {{ old('recipient_state') == 'VER' ? 'selected' : '' }}>Veracruz</option>
                            <option value="YUC" {{ old('recipient_state') == 'YUC' ? 'selected' : '' }}>Yucatán</option>
                            <option value="ZAC" {{ old('recipient_state') == 'ZAC' ? 'selected' : '' }}>Zacatecas</option>
                        </select>
                        @error('recipient_state')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="font-semibold text-yellow-800 mb-3">📏 Dimensiones del Paquete</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) *</label>
                            <input type="number" name="weight" step="0.1" min="0.1" max="70" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('weight', '1.0') }}">
                            @error('weight')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Largo (cm) *</label>
                            <input type="number" name="dimensions[length]" step="1" min="1" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('dimensions.length', '20') }}">
                            @error('dimensions.length')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ancho (cm) *</label>
                            <input type="number" name="dimensions[width]" step="1" min="1" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('dimensions.width', '15') }}">
                            @error('dimensions.width')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alto (cm) *</label>
                            <input type="number" name="dimensions[height]" step="1" min="1" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('dimensions.height', '10') }}">
                            @error('dimensions.height')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 font-medium transition duration-200">
                        📦 Crear Guía de Envío
                    </button>
                    
                    <a href="{{ route('shop.show', $product) }}" 
                       class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-md hover:bg-gray-400 font-medium text-center transition duration-200">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-base>
