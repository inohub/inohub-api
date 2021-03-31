<?php


namespace App\Services\Faq;


use App\Models\Faq\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FaqCreateService
{
    private Faq $faq;
    private Request $request;

    /**
     * StartupCreateService constructor.
     *
     * @param Faq $faq
     * @param Request $request
     */
    public function __construct(Faq $faq, Request $request)
    {
        $this->faq = $faq;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->faq->startup_id = Arr::get($data, 'startup_id');

        return $this->faq->save();
    }
}
