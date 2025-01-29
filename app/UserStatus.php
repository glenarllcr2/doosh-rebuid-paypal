<?php

namespace App;

enum UserStatus: string
{
    case Active = 'active';
    case Pendig = 'pending';
    case Suspended = 'suspended';
    case Blocked = 'blocked';
}
