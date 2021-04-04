<?php


namespace App\Services\Faq;


use App\Models\Faq\Faq;
use App\Services\Text\TextCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FaqUpdateService
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

        $this->faq->text->title = $data['title'];
        $this->faq->text->content = $data['content'];

        return $this->faq->text->save();
    }
}
