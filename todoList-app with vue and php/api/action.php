<?php   
header("Content-Type: application/json");
require 'db.php';

$obj = new DB();

$req = json_decode(file_get_contents("php://input"),true);

if(isset($req['action']) && $req['action'] == "view"){
    $output = '';
    $data =  $obj->Read('users');
    
    if ($obj->Crow('users')>0) {
        $output = json_encode($data); // this line show the data in vuetify table
        }else{
            $output = json_encode([]);
        } 
            echo $output; 
        
};

if(isset($req['action']) && $req['action'] == 'insert'){
    $name = $req['name'];
    $email= $req['email'];
    $phone= $req['phone'];

    $res = $obj->insert($name,$email,$phone);
     if($res){
        echo json_encode([
            "status" => "success",
            "message" => "Inserted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Insert failed"
        ]);
    }

    exit;

}

if(isset($req['action']) && $req['action'] == 'delete'){
    $id = $req['id'];
    $res = $obj->delete('users',$id);
}

if(isset($req['action']) && $req['action'] == 'update'){
    $Id = $req['id'];
    $Name = $req['name'];
    $Email = $req['email'];
    $Phone = $req['phone'];
    $row=$obj->update('users',$Name, $Email, $Phone,$Id);
    
    // echo json_encode($row);
}


if(isset($req['export']) && $req['export'] == 'excel')
    {
        header("Content-Type:application/xls");
        header("Content-Disposition: attachment; filename=users.xls");
        header("Pragma: no-cache");
        header('Expires: 0');

        $data = $obj->Read();
        echo '<table border="1">';
        echo '<tr><th>ID</th> <th>Full Name </th> <th>Email</th> <th>Phone</th> </tr>';

        foreach($data as $row)
            {
                echo '<tr>
                <td>'.$row['Id'].'</td>
                <td>'.$row['Name'].'</td>
                <td>'.$row['Email'].'</td>
                <td>'.$row['Phone'].'</td>
                </tr>';
            }
            echo '</table>';
    }

?>