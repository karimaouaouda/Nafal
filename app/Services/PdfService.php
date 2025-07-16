<?php
namespace App\Services;

use App\Services\Service;

class PdfService extends Service
{

    protected string $view;
    
    public function __construct(string $template_view)
    {
        $this->view = $template_view;
    }

    public function getView(): string
    {

        return $this->view;
    }

    public function getData(): array
    {
        return [];
    }
}
