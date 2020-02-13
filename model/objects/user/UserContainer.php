<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 20/11/2018
 * Time: 13:56
 */

class UserContainer
{
    private $user;

    /**
     * UserContainer constructor.
     * @param $user
     */
    public function __construct(UserConnected $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserConnected
     */
    public function getUser(): UserConnected
    {
        return $this->user;
    }

    /**
     * @param UserConnected $user
     */
    public function setUser(UserConnected $user): void
    {
        $this->user = $user;
    }

}