<?php

namespace AdfabUser\Options;

interface UserListOptionsInterface
{
    public function getUserListElements();

    public function setUserListElements(array $elements);
}
