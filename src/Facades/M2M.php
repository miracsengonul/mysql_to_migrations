<?php
namespace mirac\m2m\Facades;

use Illuminate\Support\Facades\Facade;

class M2M extends Facade
{
  protected static function getFacadeAccessor() { return 'm2m'; }
}