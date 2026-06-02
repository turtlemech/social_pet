<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $search = '';
    public $showMobileSearch = false;
    public $showUserMenu = false;

    public function toggleMobileSearch()
    {
        $this->showMobileSearch = !$this->showMobileSearch;
    }

    public function toggleUserMenu()
    {
        $this->showUserMenu = !$this->showUserMenu;
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}