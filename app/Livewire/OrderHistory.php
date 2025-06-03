<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
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
        $orders = OrderItem::where('quantity', 'like', '%' . $this->searchTerm . '%')
            ->orWhereHas('product', function ($query) {
                $query->where('product_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orWhereHas('order.user', function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->with('product', 'order.user')
            ->paginate(5);

        return view('livewire.order-history', compact('orders'));
    }
}
