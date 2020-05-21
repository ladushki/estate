<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use App\Handlers\PropertyImporterHandler;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ImportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param \App\Handlers\PropertyImporterHandler $handler
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PropertyImporterHandler $handler)
    {
        return view('import', ['result' => null]);
    }

    /**
     * @param \App\Handlers\PropertyImporterHandler $handler
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function run(PropertyImporterHandler $handler)
    {
        try {
            $result = $handler->handle();
        } catch (\Throwable $exception) {
            Log::critical($exception->getMessage());
            abort(500, $exception->getMessage());
        }

        return view('import')->with(compact('result'));
    }
}
