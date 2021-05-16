<?php

namespace App\Services\Faq;

use App\Components\Request\DataTransfer;
use App\Models\Faq\Faq;
use App\Services\Text\TextCreateService;

/**
 * Class FaqCreateService
 * @property Faq          $faq
 * @property DataTransfer $request
 * @package App\Services\Faq
 */
class FaqCreateService
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
        $this->faq->startup_id = $this->request->post('startup_id');

        return $this->faq->save() && (new TextCreateService($this->faq, new DataTransfer([
                'title'   => $this->request->post('title'),
                'content' => $this->request->post('content'),
            ])))->run();
    }
}
