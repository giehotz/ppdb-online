<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'address_type',
        'address_line',
        'province',
        'regency',
        'district',
        'village',
        'postal_code',
        'distance_km',
        'transport_mode',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'address_type' => 'required|in_list[kk,domisili]',
        'address_line' => 'required|max_length[255]',
        'province' => 'required|max_length[100]',
        'regency' => 'required|max_length[100]',
        'district' => 'required|max_length[100]',
        'village' => 'required|max_length[100]',
        'postal_code' => 'required|exact_length[5]|numeric',
        'distance_km' => 'permit_empty|decimal',
        'transport_mode' => 'required|in_list[jalan_kaki,sepeda,motor,mobil,angkot,lainnya]',
    ];
    
    protected $validationMessages = [
        'postal_code' => [
            'exact_length' => 'Kode pos harus 5 digit angka',
            'numeric' => 'Kode pos harus berupa angka',
        ],
    ];
    
    protected $skipValidation = false;
}