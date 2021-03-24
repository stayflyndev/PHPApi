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


$response = wp_remote_get( 'https://api.legiscan.com/?key=5bd75bff262103cd7d2501a8761aa0ca&op=getDatasetList&state=CO' );

$body     = wp_remote_retrieve_body( $response );
$http_code = wp_remote_retrieve_response_code( $response );


$data = json_decode($body, true);
echo $data['datasetlist'][0]['state_id'];
print_r($body);


$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// INSERTING DATA FROM THE RESPONES INTO THE TABLE
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


<?php

$response = wp_remote_get( 'https://api.legiscan.com/?key=5bd75bff262103cd7d2501a8761aa0ca&op=getBillText&id=2345569' );

$body     = wp_remote_retrieve_body( $response );
$http_code = wp_remote_retrieve_response_code( $response );

$bill_id = $body['text'][1];

$data = json_decode($body, true);


 function getBillText($text_id)
{
    $params = array('id'=>$text_id);

    return apiRequest('getBillText', $params);
}


echo getBillText($bill_id);
s
?>

<!-- CREATE TABLE IF NOT EXISTS `bills` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(12) NOT NULL,
  `roll` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`people_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;