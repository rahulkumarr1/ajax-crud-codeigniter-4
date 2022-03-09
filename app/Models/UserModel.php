<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function getUsersRows()
    {
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $this->db->escapeLikeString(trim($_POST['search']['value'])); // Search value  

        ## Filter count result
        $userTbl = $this->db->table('users');
        $userTbl->select('users.*');
        ## Fetch records 
        $this->select('users.*');
        
        if(!empty($columnName)){ $this->orderBy($columnName,$columnSortOrder); }         
        ## Search
        if(!empty($searchValue)){
            $searchArray = ['users.name'=> $searchValue,'users.username'=> $searchValue,'users.email'=> $searchValue];
            $this->orLike($searchArray);           
            $userTbl->orLike($searchArray);           
        }  
        $this->limit($rowperpage,$row);  
        $userRes = $this->get();       
        ## Total number of records without filtering
        $totalRecords = $this->countAllResults();
        $userResAll = $userTbl->get();       
        ## Total number of record with filtering
        $totalRecordwithFilter = $userResAll->resultID->num_rows; 
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,            
            "dataRows" => $userRes->getResultArray(),
        );
       return $response;
    }
}
