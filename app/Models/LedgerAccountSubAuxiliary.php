<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LedgerAccountSubAuxiliary extends Model
{
    use HasFactory,SoftDeletes;
    use SoftDeletes;
    protected $table ="ledger_account_subauxiliaries";
}
