<?php

namespace App\Models;

use CodeIgniter\Model;

class SequenceModel extends Model
{
    protected $table = 'sequences';
    protected $primaryKey = 'period';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    // Since 'period' is the primary key, we don't need to protect it
    protected $allowedFields = ['counter'];
    
    protected $useTimestamps = false;
    
    protected $validationRules = [
        'period' => 'required|max_length[9]',
        'counter' => 'required|integer',
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get the next registration number for the given period
     * 
     * @param string $period The period in format like "2025/2026"
     * @return string The generated registration number
     */
    public function getNextRegistrationNumber($period)
    {
        // Try to get the current sequence for the period
        $sequence = $this->find($period);
        
        if (!$sequence) {
            // If no sequence exists for this period, create one
            $this->insert([
                'period' => $period,
                'counter' => 0
            ]);
            $sequence = ['period' => $period, 'counter' => 0];
        }
        
        // Increment the counter
        $newCounter = $sequence['counter'] + 1;
        
        // Update the sequence
        $this->update($period, ['counter' => $newCounter]);
        
        // Format the registration number
        // Example: PPDB-2025-0001
        $year = substr($period, 0, 4); // Get the first year from period like "2025/2026"
        $registrationNumber = sprintf('PPDB-%s-%04d', $year, $newCounter);
        
        return $registrationNumber;
    }
}