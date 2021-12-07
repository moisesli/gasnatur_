<?php

//namespace App\Models;

use Config\Model;

class UserModel extends Model
{

  public function __construct()
  {
      parent::__construct();
  }

  public function CreateUser($data){
    $response = new \stdClass;
    $response->success = false;

    try{
        $sth = $this->db->insert('users',$data);
        // validacion
        if ($sth) {
            $response->success = true;
            $response->message = "Registrado correctamente";
        }else{
            $response->message = "No se pudo registrar, vuelva a intentarlo";
        }
    } catch (\Exception $e){
        $response->message = $e->getMessage();
    }
    return $response;
    //return true;
    }

  public function list(){
      $result = $this->db->findAll("select * from users");
      return $result;
  }

//   public function update(){
//     $result = $this->db->update();
//       return;
//   }

    public function delete($id){

    $result = $this->db->delete('users', 'id'.'='.$id);
    return;

    }
  

}