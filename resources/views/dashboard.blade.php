<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Your stats (Classic mode):</h3>

                    @if ($stats)
                        <ul class="space-y-2">
                            <li><strong>Current Streak:</strong> {{ $stats->currentStreak }}</li>
                            <li><strong>Total tries:</strong> {{ $stats->totalTries }}</li>
                            <li><strong>Total guessed Servants:</strong> {{ $stats->total_guesses }}</li>
                            <li>
                                <strong>Best play:</strong>
                                @if ($minServant)
                                    {{ $minServant->name }} ({{ $stats->min_tries_count }} tries)
                                    <img src="{{ $minServant->img }}" height="200px" width="200px">

                                @else
                                    -
                                @endif
                            </li>
                            
                        </ul>
                    @else
                        <p>You don't have any stat yet! Play your first game.</p>
                    @endif
                </div>

                
            </div>
            <br>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Your stats (Unlimited mode):</h3>

                    @if ($stats)
                        <ul class="space-y-2">
                            <li><strong>Total tries:</strong> {{ $stats->numeroIntentosIlimitado }}</li>
                            <li><strong>Total guesses:</strong> {{ $stats->Unlimited_total_guesses }}</li>
                        </ul>
                    @else
                        <p>You don't have any stat yet! Play your first game.</p>
                    @endif
                </div>

                
            </div>
        </div>
    </div>
</x-app-layout>


