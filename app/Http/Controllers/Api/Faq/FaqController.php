<?php

namespace App\Http\Controllers\Api\Faq;

use App\Http\Controllers\Controller;
use App\Models\Faq\Faq;
use App\Models\Startup\Startup;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function getParams()
    {
        return (Startup::with(['faqs'])->where('id', 1)->first());
    }
}
