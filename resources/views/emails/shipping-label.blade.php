{{-- resources/views/emails/shipping-label.blade.php --}}
<h1>¡Tu producto "{{ $product->name }}" ha sido vendido!</h1>

<p>Descarga tu guía de envío en PDF y llévala a la sucursal FedEx más cercana:</p>

<p><a href="{{ $labelUrl }}" target="_blank">{{ $labelUrl }}</a></p>

<p>Gracias por vender en Chacharitas.</p>
