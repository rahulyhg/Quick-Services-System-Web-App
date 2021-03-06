<?php

namespace App\Policies;

class ServicePolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function add(User $user){
        
        if($user->isAdmin()){
            return true;
        }
    }
    
    public function edit(User $user, $service){
        
        if($user->isAdmin()){
            return true;
        }
    }
}
