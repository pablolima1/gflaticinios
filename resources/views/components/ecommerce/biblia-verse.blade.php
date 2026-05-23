<div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
  <div class="shadow-default rounded-2xl bg-white px-5 pb-6 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">Versículo do dia</h2>
        <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">{{ strtok(Auth::user()->name ?? '', ' ') }}, um lembrete diário para começar bem o seu dia.</p>
      </div>
      <!-- Dropdown Menu -->
      <x-common.dropdown-menu />
      <!-- End Dropdown Menu -->
    </div>

    <div class="mt-5 space-y-3">
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed italic">{{ $versiculo['texto'] }}</p>
      <p class="text-theme-sm font-semibold text-gray-600 dark:text-gray-400">{{ $versiculo['referencia'] }}</p>
    </div>
  </div>
</div>
