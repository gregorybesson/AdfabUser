<?php

namespace AdfabUser\Options;

interface ForgotOptionsInterface
{
    public function setEmailTransport($emailTransport);
    public function getEmailTransport();
    public function setEmailFromAddress($email);
    public function getEmailFromAddress();
    public function setResetEmailSubjectLine($subject);
    public function getResetEmailSubjectLine();
}
