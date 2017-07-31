exception SMSUserException {
    1: required SMSErrorCode error_code,
    2: required string error_name,
    3: optional string message,
}

exception SMSSystemException {
    1: required SMSErrorCode error_code,
    2: required string error_name,
    3: optional string message,
}

exception SMSUnknownException {
    1: required SMSErrorCode error_code,
    2: required string error_name,
    3: required string message,
}