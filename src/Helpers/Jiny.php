<?php

namespace jiny;

function session($db=null)
{
    new Modules\Sessions($db);
    session_start();
}