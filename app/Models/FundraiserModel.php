<?php

namespace App\Models;

use CodeIgniter\Model;

class FundraiserModel extends Model
{
    protected $table            = 'fundraiser';
    protected $primaryKey       = 'fundraiser_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'address',
        'photo',
        'phone',
        'referral',
        'created_at',
        'updated_at',
    ];

    public function generateReferralCode()
    {
        helper('text'); // untuk random_string()

        do {
            // Format kode → FUND + 6 karakter acak
            $code = 'FUND' . strtoupper(random_string('alnum', 6));

            // Cek apakah sudah ada di database
            $exists = $this->where('referral', $code)->first();
        } while ($exists); // Ulang sampai ketemu yang belum ada

        return $code;
    }

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
