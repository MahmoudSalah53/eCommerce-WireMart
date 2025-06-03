<?php

namespace App\Livewire;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistoryseller extends Component
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
        $orders = OrderItem::whereHas('product', function ($query) {
            $query->where('seller_id', Auth::id());
        })->where(function ($query) {
                $query->where('quantity', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('product', function ($query) {
                        $query->where('product_name', 'like', '%' . $this->searchTerm . '%');
                    })
                    ->orWhereHas('order.user', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    });
            })
            ->with('product', 'order.user')
            ->paginate(5);

        return view('livewire.order-history-seller', compact('orders'));
    }
}
