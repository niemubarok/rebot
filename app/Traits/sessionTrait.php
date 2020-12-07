<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait sessionTrait
{
    

    public function storeSession($key, $value)
    {
        return session([$key => $value]);
    }

    public function storeAndGetSession($key,$value )
    {
        $this->storeSession($key, $value);
        return session($key);
    }

    public function flashSession($key, $value)
    {
        return session()->flash($key, $value);
    }

    public function deleteSession($key)
    {
        return session()->forget($key);
    }

    

}