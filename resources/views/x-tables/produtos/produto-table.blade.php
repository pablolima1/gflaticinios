<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 border-b">ID</th>
            <th class="px-6 py-3 border-b">Nome</th>
            <th class="px-6 py-3 border-b">Preço</th>
            <th class="px-6 py-3 border-b">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td class="px-6 py-4 border-b">{{ $produto->id }}</td>
                <td class="px-6 py-4 border-b">{{ $produto->nome }}</td>
                <td class="px-6 py-4 border-b">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td class="px-6 py-4 border-b">
                    <a href="{{ route('produtos.show', $produto->id) }}" class="text-blue-500 hover:underline">Ver</a>
                    <a href="{{ route('produtos.edit', $produto->id) }}" class="ml-2 text-yellow-500 hover:underline">Editar</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
