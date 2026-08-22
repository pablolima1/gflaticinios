<div id="modal-delete" class="p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Confirmar exclusão</h3>
    <p class="text-gray-700 dark:text-gray-300">Tem certeza que deseja excluir a venda do cliente <span id="delete-target-nome" class="font-medium"></span>?</p>

    <form id="delete-form" class="mt-6">
        @csrf
        @method('DELETE')

        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Excluir
            </button>
        </div>
    </form>
</div>
