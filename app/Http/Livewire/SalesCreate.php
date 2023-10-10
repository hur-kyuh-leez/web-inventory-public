<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Client;
use App\User;
use App\Sale;

use Auth;

class SalesCreate extends Component
{
    public $clients;
    public $users;
    public $sales;

    public $current_seller_id;
    public $order_date;
    public $set_bool;
    public $client_id;
    public $hide_bool;



    public function mount()
    {

//        $this -> current_seller_id = Auth::id();  // 이게 없어야  첫 선택이 잘된다. 출처: https://stackoverflow.com/questions/67344047/livewire-wiremodel-on-select-option-not-working-properly

        $this -> set_bool = '1';
        $this -> upgraded_bool = '1';
        $this -> order_date = date('Y-m-d');

    }

    public function updated()
    {
        $this -> current_seller_id;
        $this -> client_id;
        $this -> order_date;
    }

    public function render()
    {
         $this -> clients = Client::all();
         $this -> users = User::get(['id','name']);
         $this -> sales = Sale::get(['client_id','order_date']);

        return view('livewire.sales-create');
    }

}
