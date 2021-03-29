<?php
/*Template Name: LegalScan */


//Show the header of your WordPress site so the page does not look out of place
get_header();
?>


<!--  -->

<?php

/* 
 CALL THE API 
 GET THE RESPONSE IN JSON
 CONVERT JSON INTO PHP ARRAY 
 INSERT DATA TO  DATABASE 
 RETRIEVE THE DATA FROM THE DATABASE
 STORE THE DATA IN A VAR
 DISPLAY THE DATA ON THE FRONT
 */


$response = wp_remote_get( 'https://api.legiscan.com/?key=5bd75bff262103cd7d2501a8761aa0ca&op=getBillText&id=2345569' );

$body     = wp_remote_retrieve_body( $response );
$http_code = wp_remote_retrieve_response_code( $response );

$data = json_decode($body);
print_r($data);

$pdf = $data->text->doc;
echo "<div>++++++++++++++++++++++++++++++++++++++++++++
THE DECODED PDF IS BELOW 
++++++++++++++++++++++++++++++++</div>";

$pdf_decoded = base64_decode($pdf);
header('Content-Type: application/pdf');
echo($pdf_decoded);



$servername = "localhost";
$username = USERNAME
$password = PW
$dbname = DBNAME

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$state_id = $data['datasetlist'][0]['state_id'];
echo $state_id;

$insert_data = "INSERT INTO 9a9_legal_api (api) VALUES ('$state_id')";
mysqli_query($conn,$insert_data);//for execute

if ($conn->query($insert_data) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $insert_data . "<br>" . $conn->error;
  }
  
  $conn->close();
  
?>