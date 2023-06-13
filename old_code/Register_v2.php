<?php

    $inData = getRequestInfo();
    
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");
    if ($conn->connect_error) 
    {
        returnWithError( $conn->connect_error );
    } 
    else
    {
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username=?");
        $stmt->bind_param("s", $inData["Username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if( $rows = mysqli_num_rows($result)  )
        {
            returnWithError( "This Username is already in use" );
        }
        else
        {
            $stmt = $conn->prepare("INSERT into Users (FirstName, LastName, Username, PasswordHash) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $inData["FirstName"], $inData["LastName"], $inData["Username"], $inData["Password"]);
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
