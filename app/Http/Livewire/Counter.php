<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
       // $data =['name'=>'Niloy','age'=>25];
       // return view('livewire.counter',['data'=>$data]);

       return view('livewire.counter');
    }
}
