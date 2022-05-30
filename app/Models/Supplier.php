<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    public $timestamps = false;

    public function getSuppliers($search, $page_path)
    {
        $supplier = Supplier::orWhere(function ($query) use ($search) {
            $query->where('id', $search)
                ->orWhere('vendor', 'LIKE', "%$search%")
                ->orWhere('company_name', 'LIKE', "%$search%");
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

    public static function getVendorDetails($search)
    {
        $vendor = Supplier::orWhere(function ($query) use ($search) {
            $query->where('id', $search)
                ->orWhere('vendor', 'LIKE', "%$search%")
                ->orWhere('company_name');
        })
            ->whereNull('deleted_at')
            ->orderBy('vendor', 'asc')
            ->orderBy('company_name', 'asc')
            ->limit(Config::get('constant.autocomplete_suggestion_count'));
        return $vendor->get();
    }
}
