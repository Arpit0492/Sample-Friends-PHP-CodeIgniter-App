<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{
    function __construct() {
        $this->userTbl = 'users';
        $this->friendsTbl = 'friends_added';
    }
    /*
     * get rows from the users table
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->userTbl);

        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }

        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $query->num_rows();
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }else{
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }

        //return fetched data
        return $result;
    }

    /*
     * Insert user information
     */
    public function insert($data = array()) {
        //add created and modified data if not included
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }

        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        if($insert){
            return $this->db->insert_id();;
        }else{
            return false;
        }
    }

    /*
     * Insert friend
     */
    public function insertFriendName($names = array()){
        //insert friend name to friends table
        $insert = $this->db->insert($this->friendsTbl, $names);

        //return the status
        if ($insert){
            return $this->db->insert_id();
        }
        else
            return false;
    }

    /*
     * delete friend by friend ID
     */
    public function deleteFriendById($friendID = ''){

//        $query = $this->db->get();
        $query = 'DELETE FROM friends_added WHERE friendID = '.$friendID;
        $this->db->simple_query($query);
        $this->db->select('*');
        $this->db->from($this->friendsTbl);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }

    /*
     * get friends of a User
     */
    public function getFriends($id){
        $this->db->select('*');
        $this->db->from($this->friendsTbl);
        $this->db->where('UserID',$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}