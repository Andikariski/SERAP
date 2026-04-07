<?php
namespace App\Livewire\Admin\LWpagu;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;


class PaguGrafik extends Component
{
     #[Layout('components.layouts.admin',['pageTitle' => 'Grafik Pagu'])]
    public function render()
    {
         return view('livewire.admin.LW_pagu.pagu-grafik');
    }
}
