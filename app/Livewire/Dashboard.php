<?php

namespace App\Livewire;

use App\Models\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $original_url = '';
    public $showSuccess = false;
    public $createdShortUrl = '';

    protected $rules = [
        'original_url' => 'required|url|max:2048',
    ];

    protected $messages = [
        'original_url.required' => 'A URL é obrigatória.',
        'original_url.url' => 'A URL deve ser válida.',
        'original_url.max' => 'A URL não pode ter mais de 2048 caracteres.',
    ];

    public function createShortUrl()
    {
        $this->validate();

        $url = Url::create([
            'original_url' => $this->original_url,
            'short_code' => Url::generateShortCode(),
        ]);

        $this->createdShortUrl = $url->short_url;
        $this->showSuccess = true;
        $this->original_url = '';
        
        // Reset pagination to show the new URL
        $this->resetPage();
    }

    public function closeSuccess()
    {
        $this->showSuccess = false;
        $this->createdShortUrl = '';
    }

    public function render()
    {
        $urls = Url::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.dashboard', [
            'urls' => $urls,
        ])->layout('components.layouts.app');
    }
}
