<?php

    $inData = getRequestInfo();
    
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");
    if ($conn->connect_error) 
    {
        returnWithError( $conn->connect_error );
    } 
    else
    {
        $stmt = $conn->prepare("SELECT ID, Name, Email, Phone FROM Contacts WHERE UserID=?");
        $stmt->bind_param("i", $inData["userID"]);
        $stmt->execute();
        $result = $stmt->get_result();

        $contacts = [];
        while ($row = $result->fetch_assoc())
        {
            $contacts[] = $row;
        }

        $stmt->close();
        $conn->close();

        returnWithInfo( json_encode($contacts) );
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
