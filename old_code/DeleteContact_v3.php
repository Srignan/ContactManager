<?php

    $inData = getRequestInfo();
    
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");
    if ($conn->connect_error) 
    {
        returnWithError( $conn->connect_error );
    } 
    else
    {
        $stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=?");
        $stmt->bind_param("i", $inData["contactID"]);
        
        $stmt->execute();

        $stmt->close();
        $conn->close();

        returnWithInfo( "Contact Deleted Successfully!" );
    }
    
    // Linebreak request stuff
	
	function getRequestInfo()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError( $err )
    {
        $retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }

    function returnWithInfo($message) {
        $retValue = '{"id":0,"firstName":"","lastName":"","error":"","message":"' . $message . '"}';
        sendResultInfoAsJson($retValue);
    }
    

?>
