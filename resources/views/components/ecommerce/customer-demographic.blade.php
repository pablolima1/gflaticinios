@props(['birthdays' => []])

@php
    $defaultBirthdays = [];
    $birthdaysList = !empty($birthdays) ? $birthdays : $defaultBirthdays;
@endphp


<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Aniversariantes do Mês 🎂
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Clientes que fazem aniversário neste mês
            </p>
        </div>
        <!-- Dropdown Menu -->
        <x-common.dropdown-menu />
        <!-- End Dropdown Menu -->
    </div>

    <div class="space-y-5 mt-6">
        @forelse($birthdaysList as $client)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                            {{ $client->nome }}
                        </p>
                        <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $client->data_nascimento->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($client->data_nascimento->format('m-d') === now()->format('m-d'))
                        <span class="text-2xl">🎉</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            Parabéns!
                        </p>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-3">Nenhum aniversariante neste mês.</div>
        @endforelse
    </div>
</div>
