{\rtf1\ansi\ansicpg1252\cocoartf2708
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 <?php\
\
    $inData = getRequestInfo();\
    \
    $id = 0;\
    $firstName = "";\
    $lastName = "";\
\
    $conn = new mysqli("localhost", "root", "group16COP4331", "COP4331");\
	//format = database server's host, username, password, and then database name \
	//May need to change localhost to something else, will need to test after we get api running\
    \
    if( $conn->connect_error )\
    \{\
        returnWithError( $conn->connect_error );\
    \}\
    else\
    \{\
        // Prepare the SQL statement\
        $stmt = $conn->prepare("SELECT ID, FirstName, LastName, PasswordHash FROM Users WHERE (Username=? | Password=?)");\
        $stmt->bind_param("ss", $inData["Username"], $inData["Password"]);\
        $stmt->execute();\
\
        // Get the result of the SQL query\
        $result = $stmt->get_result();\
\
        if( $row = $result->fetch_assoc()  )\
        \{\
            returnWithInfo( $row['FirstName'], $row['LastName'], $row['ID'] );\
        \}\
        else\
        \{\
            returnWithError("No Records Found");\
        \}\
\
        $stmt->close();\
        $conn->close();\
    \}\
\
    function getRequestInfo()\
    \{\
        return json_decode(file_get_contents('php://input'), true);\
    \}\
\
    function sendResultInfoAsJson( $obj )\
    \{\
        header('Content-type: application/json');\
        echo $obj;\
    \}\
\
    function returnWithError( $err )\
    \{\
        $retValue = '\{"id":0,"firstName":"","lastName":"","error":"' . $err . '"\}';\
        sendResultInfoAsJson( $retValue );\
    \}\
\
    function returnWithInfo( $firstName, $lastName, $id )\
    \{\
        $retValue = '\{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""\}';\
        sendResultInfoAsJson( $retValue );\
    \}\
?>\
}