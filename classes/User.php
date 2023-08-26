<?php

class User
{
    public function isAdmin()
    {
        return isset($_SESSION['role_role']) && $_SESSION['user_role'] == 'admin';
    }
}