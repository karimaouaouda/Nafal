<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use App\Models\Customer;
use App\Models\Supplier;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        try{
            return DB::transaction(function() use ($data){
                $supplier = Supplier::create($data);

                $supplier->contact()->create($data['contact']);

                $supplier->address()->create($data['address']);

                return $supplier;
            });
        }catch(\Exception $e){
            Notification::make()
                ->danger()
                ->title("error")
                ->body($e->getMessage())
                ->send();
            throw $e;
        }
    }
}
