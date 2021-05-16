<?php

namespace App\Services\Faq;

use App\Components\Request\DataTransfer;
use App\Models\Faq\Faq;

/**
 * Class FaqUpdateService
 * @property Faq          $faq
 * @property DataTransfer $request
 * @package App\Services\Faq
 */
class FaqUpdateService
{
    private Faq $faq;
    private DataTransfer $request;

    /**
     * StartupCreateService constructor.
     *
     * @param Faq          $faq
     * @param DataTransfer $request
     */
    public function __construct(Faq $faq, DataTransfer $request)
    {
        $this->faq = $faq;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->faq->text->title = $this->request->post('title');
        $this->faq->text->content = $this->request->post('content');

        return $this->faq->text->save();
    }
}
