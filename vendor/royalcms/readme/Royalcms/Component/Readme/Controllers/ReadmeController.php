<?php

namespace Royalcms\Component\Readme\Controllers;

use Royalcms\Component\Routing\Controller;
use Royalcms\Component\Http\Request;
use Royalcms\Component\Readme\Services\ReadmeService;

class ReadmeController extends Controller
{
    private $readme;

    /**
     * ReadmeController constructor.
     * @param $readme
     */
    public function __construct(ReadmeService $readme)
    {
        $this->readme = $readme;

        $royalcms = royalcms();

        $royalcms->forgeRegister('Royalcms\Component\View\ViewServiceProvider');
        $royalcms->forgeRegister('Royalcms\Component\Readme\ReadmeServiceProvider');
    }

    public function index($packageName = 'royalcms_framework')
    {
        $packages = $this->readme->getPackageList();
        $docs = $this->readme->getDocs($packageName);

        $packageName = $this->readme->parseUrlParamToPackageName($packageName);

        return view('readme::index')->with(compact('packageName', 'packages', 'docs'));
    }

}
