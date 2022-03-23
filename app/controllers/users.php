<?php
require_once 'uservalidator.php';
require_once 'controller.php';
class Users extends Controller
{
    public $errors = [];
    public function __construct()
    {

        echo "<h1>inside users controller construct</h1>";


  if(isset($_POST['submit'])){
    // validate entries
    $validation = new Uservalidator($_POST);
    $errors = $validation->validateForm();
if(count($errors)>0){
$this->view('register', $errors);
}
    // if errors is empty --> save data to db
  }

    }
    
    function index()
    {

        echo "<h1>index of users</h1>";
    }
    function show($id)
    {


        $user = $this->model('user');
        $userName = $user->select($id);
        $this->view('user_view', $userName);
    }
    function add()
    {

        echo "<h1>add of users</h1>";
    }

    function add_user()
    {
        print_r($_POST);
        if(isset($_POST['submit']))
        {
            $userName=$_POST['name'];
            $password=$_POST['password'];
            $email=$_POST['email'];
           if($userName!=""&&$password!=""&&$email!="")
           {
               $user_data =array(
                   'name'=>$userName,
                   'password'=>md5($password),
                   'email'=>$email
                   
               );
               $u=$this->model('user');
               $message="";
               if($u->insert($user_data)){
                   $type='success';
                    $message="user created successful";
                    $this->view('feedback',array('type'=>$type,'message'=>$message));

                }
               else {
                   $type='danger';
                   $message="can not create user please check your data ";
               
                   $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));

                }
           } 

        }
        
    }
    function register()
    {
        $this->view('register');
    }

    function list_all()
    { $users=$this->model("user");
        $result=$users->select();
        $this->view('users_table',$result);

    }
    function status($id){
    $user=$this->model("user");
        $user->changeStatus($id);
        $this->list_all();

//        header('location:users/list_all');


        
    }
}
