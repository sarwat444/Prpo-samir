<?php
use Carbon\Carbon ;

function gettime()
{
   return Carbon::now()->format('h:i:s');
}
