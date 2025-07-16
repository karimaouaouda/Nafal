<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Settings;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class InvoicePdfGenerator extends PdfService
{
    public string $view = 'documents.invoice';

    public Invoice $invoice;

    public function __construct()
    {
        parent::__construct($this->view);
    }

    public function getData(): array
    {
        $settings = Settings::all();

        $invoice = $this->invoice;

        $total = $invoice->transaction->products->sum(function (Product $product) {
            $price = $product->pivot->sell_price * $product->pivot->quantity;

            $price = $price - $product->pivot->discount;
            $price = $price - ($price * ($product->pivot->sold / 100));
            return $price;
        });

        $vat = $total * (($settings->where('key', 'VAT')->first()?->value['en'] ?? 15)  / 100);

        $qr_code_data = sprintf(
            "%s--%s--%s--%s--%s--%s",
            $settings->where('key','company_name')->first()->value['en'],
            $invoice->transaction->customer->vat_number,
            now(),
            $total,
            $vat,
            $invoice->transaction->customer->latin_name
        );

        

        return [
            'invoice' => $this->getInvoice(),
            'image' => base64_encode(file_get_contents(public_path('logo.png'))),
            'settings' => $settings,
            'vat' => $vat,
            'total' => $total,
            'qr_code' => QrCode::size(100)->generate(base64_encode($qr_code_data)),
        ];
    }

    private function getInvoice()
    {
        // Logic to retrieve the invoice data
        return request('invoice')
            ->load(['transaction', 'transaction.products']);
    }


    public static function pdfResponse(?Invoice $invoice): string
    {
        $instance = new self();

        $instance->invoice = $invoice ?? $instance->getInvoice();

        $data = $instance->getData();

        return $instance->generatePdf($data);
    }

    public static function generate(?Invoice $invoice): PdfBuilder
    {
        $instance = new self();

        $instance->invoice = $invoice ?? $instance->getInvoice();

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
