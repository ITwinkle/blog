<?php

namespace Framework\Security\Model;

interface UserInterface
{
    /**
     * return User role
     * @return mixed
     */
    public function getRole();

}