<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    public $timestamps = false;

    public function getCustomers($search, $page_path)
    {
        $supplier = Customer::orWhere(function ($query) use ($search) {
            $query->where('id', $search)
                ->orWhere('name', 'LIKE', "%$search%");
        })
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')

            ->paginate(Config::get('constant.per_page'))
            ->withPath($page_path)
            ->appends(
                [
                    'q' => $search,
                ]
            );

        return $supplier;
    }

    public static function getCustomerDetails($search)
    {
        $customer = Customer::orWhere(function ($query) use ($search) {
            $query->where('id', $search)
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('contact_detail', 'LIKE', "%$search%");
        })
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')
            ->orderBy('contact_detail', 'asc')
            ->limit(Config::get('constant.autocomplete_suggestion_count'));
        return $customer->get();
    }
}
