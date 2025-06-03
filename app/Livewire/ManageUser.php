<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageUser extends Component
{
    use WithPagination;

    public $searchTerm = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }


    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->searchTerm . '%')
        ->paginate(5);
        return view('livewire.manage-user', compact('users'));
    }
}
