<?php
include 'config.php';
$csv=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    $fileTemp = $_FILES['csv']['tmp_name'];
    if (($fileOpen = fopen($fileTemp, "r"))) {
        // $header =true;
        $query = $conn->prepare("insert into datas(id, name, age, gender, department, year, email, cgpa) values (:id, :name, :age, :gender, :department, :year, :email, :cgpa)");
        while (($data = fgetcsv($fileOpen,100, ","))) {
            // $csv[] = $data;
            // if($header){
            //     $header = false;
            // }
            $csv[] = $data;
            $query->execute([
                ':id'=>$data[0],
                ':name'=>$data[1],
                ':age'=>$data[2],
                ':gender'=>$data[3],
                ':department'=>$data[4],
                ':year'=>$data[5], 
                ':email'=>$data[6],
                ':cgpa'=>$data[7],
            ]);
        }
        fclose($fileOpen);
        echo "file data inserted";
    }else{
        echo "file data not inserted";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select file to upload:
  <input type="file" name="csv">
  <input type="submit" value="Upload CSV" name="submit">
</form>

<?php
if (!empty($csv)) {;
    echo "<pre>";
    print_r($csv);
    echo "</pre>";
    // $encode = json_encode($csv);
    // print_r($encode);
    // $decode = json_decode($encode,1);
    // print_r($decode);
}
?>

</body>
</html>
