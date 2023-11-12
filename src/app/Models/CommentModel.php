<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'comments';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
            'email',
            'text'
        ];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
        protected $updatedField         = ''; 
        protected $deletedField         = '';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
        
        
        public function getPage(int $page = null, int $order = null) {
            $order = $order ? $order : 1;
            $orderList = [
                1=>["id", "asc"],
                2=>['id', 'desc'],
                3=>['created_at', 'asc'],
                4=>['created_at', 'desc'],
            ];
            $this->orderBy($orderList[$order][0],$orderList[$order][1]);
            $data = [
            'comments' => $this->paginate(3, 'default', $page),
            'pager' => $this->pager,
            ];
            return $data;
        }
}
