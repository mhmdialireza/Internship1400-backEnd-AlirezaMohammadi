<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\V1\Types\Poly;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Operation\PolyOperation;
use App\Services\AnalyzingService;
use App\Services\PolyService;
use App\Services\ValidationService;

class ApiResponseController extends Controller
{
    public function __construct(
        private AnalyzingService  $analyzingService,
        private ValidationService $validationService,
        private PolyOperation     $polyOperation,
        private PolyService       $polyService
    )
    {
    }

    public function index(Request $request)
    {
        $isValid = $this->validationService->isValid($request->string ?? '-');
        if (!$isValid) {
            return response()->json(['error' => 'invalid string']);
        }

        $poly = $this->analyzingService->getPolyFromString($request->string);

        return response()->json([
            'monos' => $this->polyService->getArrayMonos($poly),
            'string' => $poly->__toString()
        ]);
    }

    public function derivate(Request $request)
    {
        $poly = $this->polyService->makePolyByRequestMonos($request->monos);

        $derivatePoly = $this->polyOperation->derivative($poly);
        $arrayMonos = $this->polyService->getArrayMonos($derivatePoly);

        return response()->json([
            'monos' => $arrayMonos,
            'string' => $derivatePoly->__toString()
        ]);
    }

    public function answerForValue(Request $request)
    {
        $poly = $this->polyService->makePolyByRequestMonos($request->monos);

        $answerForValue = $this->polyOperation->answerForValue($poly, $request->x);

        return response()->json([
            'answer' => $answerForValue
        ]);
    }

    public function sum(Request $request)
    {
        $poly1 = $this->polyService->makePolyByRequestMonos($request->monos1);
        $poly2 = $this->polyService->makePolyByRequestMonos($request->monos2);

        $sum = $this->polyOperation->sum($poly1, $poly2);

        return response()->json([
            'monos' => $this->polyService->getArrayMonos($sum),
            'string' => $sum->__toString()
        ]);
    }

    public function sub(Request $request)
    {
        $poly1 = $this->polyService->makePolyByRequestMonos($request->monos1);
        $poly2 = $this->polyService->makePolyByRequestMonos($request->monos2);

        $sub = $this->polyOperation->sub($poly1, $poly2);

        return response()->json([
            'monos' => $this->polyService->getArrayMonos($sub),
            'string' => $sub->__toString()
        ]);
    }

    public function mul(Request $request)
    {
        $poly1 = $this->polyService->makePolyByRequestMonos($request->monos1);
        $poly2 = $this->polyService->makePolyByRequestMonos($request->monos2);

        $mul = $this->polyOperation->mul($poly1, $poly2);

        return response()->json([
            'monos' => $this->polyService->getArrayMonos($mul),
            'string' => $mul->__toString()
        ]);
    }
}
