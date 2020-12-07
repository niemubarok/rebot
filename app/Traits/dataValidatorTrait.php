<?php

namespace App\Traits;

use App\Traits\messageTrait;
use App\Traits\agTrait;
use Illuminate\Support\Str;
use App\Traits\jadwalTrait;
use app\Traits\poliTrait;
use App\Traits\waTableTrait;

trait dataValidatorTrait
{

    use agTrait;
    use messageTrait;
    use jadwalTrait;
    use poliTrait;
    use waTableTrait;

    public function dataValidation()
    {
        $poli = $this->getWaTableData('poli');

        // if($poli )
        
    }
}