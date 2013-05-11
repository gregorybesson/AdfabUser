<?php

namespace AdfabUser\Options;

interface RememberMeOptionsInterface
{
    /**
     * @param int $seconds
     */
    public function setCookieExpire($seconds);

    /**
     * @return int
     */
    public function getCookieExpire();
}
