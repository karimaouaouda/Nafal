<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

    /**
     * @throws \Exception
     */
    protected function handleRecordCreation(array $data): Model
    {
        try{
            return DB::transaction(function() use ($data){
                $customer = Customer::create($data);

                $customer->contact()->create($data['contact']);

                $customer->address()->create($data['address']);

                return $customer;
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
