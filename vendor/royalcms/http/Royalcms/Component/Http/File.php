<?php

namespace Royalcms\Component\Http;

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class File extends SymfonyFile
{
    use FileHelpers;
}
