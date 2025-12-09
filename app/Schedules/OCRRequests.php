<?php

namespace App\Schedules;

use App\Models\Request;
use App\Services\OcrService;

class OCRRequests {

    public function __invoke(OCRService $ocrService)
    {
        $requests = Request::where('status','pending')->get();

        foreach ($requests as $request) {
            $request->status = 'ready';

            $ocrResult = $ocrService->analyze(
                $request['images'],
                $request['opis'],
                $request['kwota_brutto'],
            );

            $request->ocr_result = $ocrResult;
            $request->save();
        }

    }

}
