<?php

namespace App\Models;

use CodeIgniter\Model;

class CMSModel extends Model
{
    protected $table = 'cms_posts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'type',
        'title',
        'slug',
        'content',
        'attachment_path',
        'status',
        'publish_at',
        'author_id',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'type' => 'required|in_list[announcement,info,page]',
        'title' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]',
        'content' => 'permit_empty',
        'attachment_path' => 'permit_empty|max_length[255]',
        'status' => 'required|in_list[draft,published]',
        'publish_at' => 'permit_empty|valid_date',
        'author_id' => 'required|is_natural_no_zero',
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get published posts by type
     */
    public function getPublishedByType($type, $limit = null)
    {
        $builder = $this->where('type', $type)
            ->where('status', 'published')
            ->where('(publish_at IS NULL OR publish_at <= NOW())')
            ->orderBy('created_at', 'DESC');
            
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
    
    /**
     * Get a published post by slug
     */
    public function getPublishedBySlug($slug)
    {
        return $this->where('slug', $slug)
            ->where('status', 'published')
            ->where('(publish_at IS NULL OR publish_at <= NOW())')
            ->first();
    }
    
    /**
     * Get latest announcements
     */
    public function getLatestAnnouncements($limit = 5)
    {
        return $this->getPublishedByType('announcement', $limit);
    }
    
    /**
     * Get all published info posts
     */
    public function getPublishedInfo()
    {
        return $this->getPublishedByType('info');
    }
    
    /**
     * Get all published pages
     */
    public function getPublishedPages()
    {
        return $this->getPublishedByType('page');
    }
}