<?php

    $inData = getRequestInfo();
    
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");
    if ($conn->connect_error) 
    {
        returnWithError( $conn->connect_error );
    } 
    else
    {
        $stmt = $conn->prepare("SELECT Email FROM Users WHERE Email=?");
        $stmt->bind_param("s", $inData["email"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if( $row = $result->fetch_assoc()  )
        {
            returnWithError( "This Email is already in use" );
        }
        else
        {
            $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Email, Phone, PasswordHash) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"], password_hash($inData["password"], PASSWORD_DEFAULT));
            $stmt->execute();
            returnWithInfo( "Registration Successful!" );
        }

        $stmt->close();
        $conn->close();
    }
    
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
        $retValue = '{"error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }
    
    function returnWithInfo( $info )
    {
        $retValue = '{"info":"' . $info . '"}';
        sendResultInfoAsJson( $retValue );
    }

?>
