<div class="px-4 sm:px-0">
    <!-- Formulário para criar URL -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Encurtar Nova URL</h2>
            
            <form wire:submit.prevent="createShortUrl" class="space-y-4">
                <div>
                    <label for="original_url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Original
                    </label>
                    <div class="flex gap-2">
                        <input 
                            type="url" 
                            id="original_url"
                            wire:model="original_url"
                            placeholder="https://exemplo.com"
                            class="flex-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md px-4 py-2 border @error('original_url') border-red-500 @enderror"
                        >
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="createShortUrl">
                                Encurtar
                            </span>
                            <span wire:loading wire:target="createShortUrl" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Encurtando...
                            </span>
                        </button>
                    </div>
                    @error('original_url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </form>

            <!-- Mensagem de sucesso -->
            @if($showSuccess)
                <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-green-800">
                                URL encurtada com sucesso!
                            </h3>
                            <div class="mt-2">
                                <div class="flex items-center gap-2">
                                    <input 
                                        type="text" 
                                        value="{{ $createdShortUrl }}" 
                                        readonly
                                        class="flex-1 text-sm bg-white border border-green-300 rounded px-3 py-2 font-mono"
                                        id="shortUrlInput"
                                    >
                                    <button 
                                        onclick="navigator.clipboard.writeText('{{ $createdShortUrl }}'); alert('URL copiada!');"
                                        class="inline-flex items-center px-3 py-2 border border-green-300 text-sm font-medium rounded text-green-700 bg-white hover:bg-green-50"
                                    >
                                        Copiar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto pl-3">
                            <button 
                                wire:click="closeSuccess"
                                class="inline-flex text-green-400 hover:text-green-500"
                            >
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Lista de URLs -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">URLs Encurtadas</h2>
                <button 
                    wire:click="$refresh"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                    <svg wire:loading.remove wire:target="$refresh" class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <svg wire:loading wire:target="$refresh" class="animate-spin h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="$refresh">Atualizar</span>
                    <span wire:loading wire:target="$refresh">Atualizando...</span>
                </button>
            </div>
            
            <div class="overflow-x-auto relative">
                <!-- Loading overlay -->
                <div wire:loading wire:target="$refresh,createShortUrl" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                    <div class="flex flex-col items-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Carregando...</p>
                    </div>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                URL Original
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                URL Encurtada
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantidade de Acessos
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data de Criação
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($urls as $url)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate" title="{{ $url->original_url }}">
                                        {{ $url->original_url }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ $url->short_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        {{ $url->short_url }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $url->access_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $url->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Nenhuma URL cadastrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $urls->links() }}
            </div>
        </div>
    </div>
</div>
