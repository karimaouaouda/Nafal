<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    <div class="pdf-content h-full p-4 border border-black w-[210mm] flex flex-col justify-between">
        <div class="pdf-head flex justify-between border-indigo-400 border-b-2 pb-2">
            <div class="flex flex-col justify-between">
                <h1 class="text-2xl capitalize font-bold text-sky-800">
                    nifal al haditha trading est.
                </h1>
                <h2 class="text-xl capitalize">
                    safety - electrical - mechanical
                </h2>
                <h2 class="text-xl capitalize">
                    c.r. 2055154968
                </h2>
            </div>

            <div>
                <img src="{{ 'data:image/png;base64,'.$image }}" alt="logo" class="w-28 h-28">
            </div>

            <div class="flex flex-col justify-between" dir="rtl">
                <h1 class="text-2xl capitalize font-bold text-sky-800">
                    مؤسسة نفال الحديثة التجارية
                </h1>
                <h2 class="text-xl capitalize">
                    السلامة - الكهربائية - الميكانيكية
                </h2>
                <h2 class="text-xl capitalize">
                    س.ت. 2055154968
                </h2>
            </div>
        </div>

        <div class="pdf-body flex-1 py-4 flex flex-col space-y-2 items-center">
            <h1 class="text-xl uppercase">
                Quotation
            </h1>
            <div class="w-full flex justify-between border border-black">
                <div class="flex flex-col border-r border-black p-2 pr-8">
                    <h2 class="text-lg capitalize">
                        Quotation : {{ $quotation->code }}
                    </h2>
                    <h2 class="text-lg capitalize">
                        Date: {{ now()->format('d/m/Y') }}
                    </h2>
                    <h2 class="text-lg capitalize">
                        Attention : {{ $quotation->attention }}
                    </h2>
                    <h2 class="text-lg capitalize">
                        CUS REF: {{ $quotation->cus_ref }}
                    </h2>
                </div>
                <div class="flex flex-col flex-1 p-2">
                    <h2 class="text-xl capitalize">
                        Customer Name: {{ $quotation->transaction->customer->latin_name }}
                    </h2>
                    <h2 class="text-xl capitalize" dir="rtl">
                        إسم الزبون: {{ $quotation->transaction->customer->arabic_name }}
                    </h2>
                    <h2 class="text-xl capitalize">
                        VatNo. {{ $quotation->transaction->customer->vat_number }}
                    </h2>
                    <h2 class="text-xl capitalize">
                        address: al jubail - al badiyah st. makkah dist
                    </h2>
                    <h2 class="text-xl capitalize" dir="rtl">
                        العنوان: الجبيل - شارع البادية - حي مكة
                    </h2>

                </div>

            </div>
            <div class="table-container w-full">
                <table class="table-auto w-full border border-black">
                    <thead>
                        <tr class="border-b border-black">
                            <th class="p-2 text-left">Item</th>
                            <th class="p-2 text-left">Description</th>
                            <th class="p-2 text-left">Unity</th>
                            <th class="p-2 text-left">Qty</th>
                            <th class="p-2 text-left">Unit Price</th>
                            <th class="p-2 text-left">DISCOUNT</th>
                            <th class="p-2 text-left">sold</th>
                            <th class="p-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i = 0; $sum = 0 @endphp
                        @foreach($quotation->transaction->products as $product)
                            @php
                                $subtotal = ((($product->pivot->price - ($product->pivot->price * $product->pivot->sold / 100)) * $product->pivot->quantity) - $product->pivot->discount);
                            @endphp
                            <tr class="border-x border-black">
                                <td class="p-2 text-sm border-x border-black">{{ $i + 1 }}</td>
                                <td class="p-2 text-sm border-x border-black">{{ $product->title . "-" . $product->description }}</td>
                                <td class="p-2 text-sm border-x border-black">Pcs</td>
                                <td class="p-2 text-sm border-x border-black">{{ $product->pivot->quantity }}</td>
                                <td class="p-2 text-sm border-x border-black">{{ $product->pivot->price }}</td>
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
                            Subtotal
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $sum }}
                        </div>

                    </div>
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            VAT
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            100.00
                        </div>
                    </div>
                    <div class="row flex">
                        <div class="cell flex-1 text-right border border-black px-2">
                            Total
                        </div>
                        <div class="cell min-w-1/5 text-right border border-black px-2">
                            {{ $sum + 100.00 }}
                        </div>

                    </div>
                    <div class="row border-black text-center">
                        <div class="cell flex-1 border border-black px-2">
                            <h2 class="text-md capitalize">
                                Two Thousand Two Hundred Only
                            </h2>
                        </div>
                        <div class="cell flex-1 border border-black px-2">
                            <h2 class="text-md capitalize" dir="rtl">
                                ألفين ومئتين فقط
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="pdf-footer flex flex-col items-center border-indigo-400 border-t-2 pt-2">
            <div class="flex w-full justify-between">
                <div class="flex flex-col justify-between">
                    <h2 class="text-xl capitalize">
                        Vat Reg. No. {{ \App\Services\Configuration::get('vat_number')['en'] }}
                    </h2>
                    <h2 class="text-xl capitalize">
                        {{ \App\Services\Configuration::get('address')['en'] }}
                    </h2>
                </div>
                <div class="flex flex-col justify-between" dir="rtl">

                    <h2 class="text-xl capitalize">
                        رقم تسجيل ضريبة: {{ \App\Services\Configuration::get('vat_number')['ar'] }}
                    </h2>
                    <h2 class="text-xl capitalize">
                        {{ \App\Services\Configuration::get('address')['ar'] }}
                    </h2>
                </div>
            </div>
            <div class="text-center">
                <a href="mailto:sales@nifal.com" class="text-blue-500 font-semibold underline">
                    Email: sales@nifal.com
                </a>
                -
                <a href="https://www.nifal.com" target="_blank" class="text-blue-500 font-semibold underline">
                    web: www.nifal.com
                </a>
            </div>
        </div>
    </div>
</body>

</html>
