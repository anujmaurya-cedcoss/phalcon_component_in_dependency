<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction() {
        // redirected to view
    }

    public function registerAction() {
        if($_POST['name'] != '' && $_POST['email'] != '') {
            $success = $this->mongo->users->insertOne($_POST)->getInsertedCount();
        }
        if($success > 0) {
            $this->response->redirect('/index/find');
        } else {
            echo "<h3>Oops !</h3> There was some error";
            echo "<a href = '/index/'>Go back</a>";
            die;
        }
    }

    public function findAction() {
        // redirected to view
    }

    public function displayAction() {
        $name = $_POST['name'];
        $data = $this->findUser->searchInDB($name);
        if($data->name != '') {
            echo "Name => $data->name <br>";
            echo "Email => $data->email";
        }else {
            echo "No records found, go back to home <a href = '/index'>Home</a>";
        }
        die;
    }
}
