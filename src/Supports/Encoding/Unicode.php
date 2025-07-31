<?php

namespace Aijoh\Core\Supports\Encoding;

use Aijoh\Core\Supports\Encoding\Trait\UnicodeHorizontalBarExtender;
use Aijoh\Core\Supports\Encoding\Trait\UnicodeSpaceExtender;

class Unicode
{
    use UnicodeHorizontalBarExtender;
    use UnicodeSpaceExtender;
}
