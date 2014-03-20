<?php

namespace Busko\EmployeeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BuskoEmployeeBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
