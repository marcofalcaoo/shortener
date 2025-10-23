<div class="w-full max-w-md">
    <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900">URL Shortener</h2>
            <p class="text-gray-600 mt-2">Entre com suas credenciais</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input 
                    wire:model="email" 
                    type="email" 
                    id="email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                    placeholder="admin@beepayapp.com.br"
                >
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Senha
                </label>
                <input 
                    wire:model="password" 
                    type="password" 
                    id="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input wire:model="remember" type="checkbox" class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-sm text-gray-700">Lembrar-me</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Entrar
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Credenciais padrão:</p>
            <p class="font-mono text-xs mt-1">admin@beepayapp.com.br / admin123456</p>
        </div>
    </div>
</div>
