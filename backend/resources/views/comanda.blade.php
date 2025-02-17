<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova comanda</title>
</head>
<body>
    <h1>Detalls de la Comanda</h1>

    <p><strong>Usuari:</strong> {{ $order->user->name }}</p>
    <p><strong>data de la Comanda:</strong> {{ $order->created_at }}</p>

    <h2>Productes:</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nom</th>
                <th>preu</th>
                <th>quantitat</th>
                <th>Preu Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->nom }}</td>
                    <td>{{ $item->price }} €</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price * $item->quantity }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total de la Comanda: {{ $order->total_amount }} €</h3>

    <p>Gràcias per la compra.</p>
</body>
</html>
