<?php

    $inData = getRequestInfo();
    
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");
    if ($conn->connect_error) 
    {
        returnWithError( $conn->connect_error );
    } 
    else
    {
        $stmt = $conn->prepare("INSERT INTO Contacts (UserID, Name, Email, Phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $inData["userID"], $inData["name"], $inData["email"], $inData["phone"]);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        returnWithInfo( "Contact Added Successfully!" );
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

    function returnWithInfo( $firstName, $lastName, $id )
    {
        $retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
        sendResultInfoAsJson( $retValue );
    }

?>
