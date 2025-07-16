<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    <div class="pdf-content h-screen p-4 border border-black w-[210mm] flex flex-col justify-between">
        <div class="pdf-head flex justify-between border-indigo-400 border-b-2 pb-2">
            <div class="flex flex-col">
                <h1 class="text-lg capitalize font-bold text-sky-800 leading-8">
                    {{ $settings->where('key', 'company_name')->first()->value['en'] ?? "Nifal Modern Trading Est." }}
                </h1>
                <h2 class="text-md capitalize leading-8">
                    {{ $settings->where('key', 'company_bio')->first()->value['en'] ?? "Safety - Electrical - Mechanical" }}
                </h2>
                <h2 class="text-md capitalize leading-8">
                    c.r. {{ $settings->where('key', 'cr_number')->first()->value['en'] ?? "2055154968" }}
                </h2>
            </div>

            <div>
                <img src="{{ 'data:image/png;base64,'.$image }}" alt="logo" class="w-28 h-28">
            </div>

            <div class="flex flex-col" dir="rtl">
                <h1 class="text-lg capitalize font-bold text-sky-800 leading-8">
                    {{ $settings->where('key', 'company_name')->first()->value['ar'] ?? "مؤسسة نفل الحديثة للتجارة" }}
                </h1>
                <h2 class="text-md capitalize leading-8">
                    {{ $settings->where('key', 'company_bio')->first()->value['ar'] ?? "السلامة - الكهرباء - الميكانيكا" }}
                </h2>
                <h2 class="text-md capitalize leading-8">
                    س.ت. {{ $settings->where('key', 'cr_number')->first()->value['ar'] ?? "2055154968" }}
                </h2>
            </div>
        </div>

        <div class="pdf-body flex-1 py-4 flex flex-col space-y-2 items-center">
            <h1 class="text-sm uppercase font-semibold">
                TAX INVOICE / فاتورة ضريبية

            </h1>
            <div class="w-full flex border border-black">
                <div class="flex flex-col border-r border-black p-2 pr-8">
                    <h2 class="text-sm capitalize whitespace-nowrap">
                        Invoice : {{ $invoice?->code ?? "something" }}
                    </h2>
                    <h2 class="text-sm capitalize">
                        Date: {{ now()->format('d/m/Y') }}
                    </h2>
                    <h2 class="text-sm capitalize">
                        PO : {{ $invoice?->po ?? "" }}
                    </h2>
                    <h2 class="text-sm capitalize">
                        PO DATE: {{ $invoice?->po_date ?? "" }}
                    </h2>
                </div>
                <div class="p-2 w-full">
                    <div class="float-right">
                        {{ $qr_code }}
                    </div>
                    <div class="flex space-x-2">
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                              Customer Name
                        </h2>
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                             {{ $invoice?->transaction->customer->latin_name ?? "some name" }}
                        </h2>
                    </div>

                    <div class="flex space-x-2">
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                            إسم الزبون
                        </h2>
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                            {{ $invoice?->transaction->customer->arabic_name ?? "اسم هنا" }}
                        </h2>
                    </div>

                    <div class="flex space-x-2">
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                            VatNo./الرقم الضريبي 
                        </h2>
                        <h2 class="text-sm leading-8 font-semibold capitalize">
                            {{ $invoice?->transaction->customer->vat_number ?? "300054789" }} 
                        </h2>
                    </div>

                    <h2 class="text-sm leading-8 font-semibold capitalize">
                        address/العنوان: {{ $invoice?->transaction->customer->address->full_address ?? "some address" }}
                    </h2>

                </div>

            </div>
            <div class="table-container w-full">
                <table class="table-auto w-full border border-black">
                    <thead>
                        <tr class="border-b border-black">
                            <th class="p-2 text-left text-xs">SLNo / التسلسل</th>
                            <th class="p-2 text-left text-xs">Description</th>
                            <th class="p-2 text-left text-xs">Unity</th>
                            <th class="p-2 text-left text-xs">Qty</th>
                            <th class="p-2 text-left text-xs">Unit Price</th>
                            <th class="p-2 text-left text-xs">DISCOUNT</th>
                            <th class="p-2 text-left text-xs">sold</th>
                            <th class="p-2 text-left text-xs">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; $sum = 0 @endphp
                        @foreach($invoice?->transaction->products?? [] as $product)
                        @php
                        $subtotal = ((($product->pivot->sell_price - ($product->pivot->price * $product->pivot->sold / 100)) * $product->pivot->quantity) - $product->pivot->discount);
                        @endphp
                        <tr class="border-x border-black">
                            <td class="p-2 text-sm border-x border-black">{{ $i + 1 }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->title . "-" . $product->description }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->unity->abbreviation }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->pivot->quantity }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->pivot->sell_price }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->pivot->discount }}</td>
                            <td class="p-2 text-sm border-x border-black">{{ $product->pivot->sold }}%</td>
                            <td class="p-2 text-sm border-x border-black">{{ $subtotal }}</td>
                        </tr>
                        @php $i = $i + 1; $sum += $subtotal @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="summary-container w-full">
                <div class="rows flex flex-col">
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            Subtotal / المجموع الفرعي
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $total }}
                        </div>

                    </div>
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            Taxable Amount / المبلغ الخاضع للضريبة
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $total }}
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            Vat 15.00% ضريبة القيمة المضافة
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $vat }}
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            Payable / مستحق الدفع
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $total + $vat }}
                        </div>

                    </div>
                    <div class="row border-black text-center">
                        <div class="cell flex-1 border border-black px-2">
                            <h2 class="text-md capitalize">
                                {{ \NumberToWords\NumberToWords::transformNumber('en', $total + $vat) }} Only
                            </h2>
                        </div>
                        <div class="cell flex-1 border border-black px-2">
                            <h2 class="text-md capitalize" dir="rtl">
                                {{ \NumberToWords\NumberToWords::transformNumber('ar', $total + $vat) }} فقط
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="pdf-footer flex flex-col items-center border-indigo-400 border-t-2 pt-2">
            <div class="flex w-full justify-between">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm capitalize">
                        Vat Reg. No. {{ \App\Services\Configuration::get('vat_number')['en'] ?? "no value" }}
                    </h2>
                    <h2 class="text-sm capitalize">
                        {{ \App\Services\Configuration::get('address')['en'] ?? "no value" }}
                    </h2>
                </div>
                <div class="flex flex-col justify-between" dir="rtl">

                    <h2 class="text-sm capitalize">
                        رقم تسجيل ضريبة: {{ \App\Services\Configuration::get('vat_number')['ar'] ?? "no value" }}
                    </h2>
                    <h2 class="text-sm capitalize">
                        {{ \App\Services\Configuration::get('address')['ar'] ?? "no value" }}
                    </h2>
                </div>
            </div>
            <div class="text-center">
                <a href="mailto:sales@nifal.com" class="text-blue-500 font-semibold underline">
                    Email: {{ $settings->where('key', 'email')->first()->value['en'] ?? "" }}
                </a>
                -
                <a href="https://www.nifal.com" target="_blank" class="text-blue-500 font-semibold underline">
                    web: {{ $settings->where('key', 'website')->first()->value['en'] ?? "www.nifal.com" }}
                </a>
            </div>
        </div>
    </div>
</body>

</html>