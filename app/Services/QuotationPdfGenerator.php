<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\Settings;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class QuotationPdfGenerator extends PdfService
{
    public string $view = 'documents.quotation';

    public Quotation $quotation;

    public function __construct()
    {
        parent::__construct($this->view);
    }

    public function getData(): array
    {
         $settings = Settings::all();

        $quotation = $this->quotation ?? $this->getQuotation();

        $total = $quotation->transaction->products->sum(function (Product $product) {
            $price = $product->pivot->sell_price * $product->pivot->quantity;

            $price = $price - $product->pivot->discount;
            $price = $price - ($price * ($product->pivot->sold / 100));
            return $price;
        });

        $vat = $total * ( $this->getVatPercent()  / 100);

        $qr_code_data = sprintf(
            "%s--%s--%s--%s--%s--%s",
            $settings->where('key','company_name')->first()->value['en'],
            $quotation->transaction->customer->vat_number,
            now(),
            $total,
            $vat,
            $quotation->transaction->customer->latin_name
        );

        

        return [
            'quotation' => $this->getQuotation(),
            'image' => base64_encode(file_get_contents(public_path('logo.png'))),
            'settings' => $settings,
            'vat' => $vat,
            'vat_percent' => $this->getVatPercent(),
            'total' => $total,
            'qr_code' => QrCode::size(100)->generate(base64_encode($qr_code_data)),
        ];
    }

    private function getVatPercent(): float
    {
        return Settings::where('key', 'vat_percent')->first()?->value['vat_percent'] ?? 0;
    }

    private function getSettings(){
        return Settings::all();
    }


    private function getQuotation()
    {
        // Logic to retrieve the quotation data
        return request('quotation')
            ->load(['transaction', 'transaction.products']);
    }

    public static function pdfResponse(?Quotation $quotation): string
    {
        $instance = new self();

        $instance->quotation = $quotation ?? $instance->getQuotation();

        $data = $instance->getData();

        return $instance->generatePdf($data);
    }

    public static function generate(?Quotation $quotation): PdfBuilder
    {
        $instance = new self();

        $instance->quotation = $quotation ?? $instance->getQuotation();

        $data = $instance->getData();

        return Pdf::view($instance->view, $data);
    }

    public function generatePdf($data)
    {
        // set content type to application/pdf
        request()->headers->set('Content-Type', 'application/pdf');
        return Pdf::view($this->view, $data)
            ->format('a4')
            ->toResponse(request());
    }
}