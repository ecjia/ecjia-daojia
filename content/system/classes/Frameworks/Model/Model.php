<?php

namespace Ecjia\System\Frameworks\Model;

use Royalcms\Component\Rememberable\Rememberable;
use Royalcms\Component\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use Rememberable;
    use InsertOnDuplicateKey;
    
}
