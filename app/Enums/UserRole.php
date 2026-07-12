<?php

namespace App\Enums;

enum UserRole: string
{
  case ADMIN = 'ADMIN';
  case LECTURER = 'LECTURER';
  case STUDENT = 'STUDENT';
}
