namespace php SMS

typedef i64 Int
typedef string Json
typedef string Mobile

enum SMSErrorCode {
    UNKNOWN_ERROR = 0,
    TOO_BUSY_ERROR = 1,
    DATABASE_ERROR = 2,
    EMPTY_MOBILE = 3,
    INVALID_MOBILE = 4,
}

const string SMS_IN = "in"
const string SMS_PROMO = "promo"
const string SMS_COMMENT = "comment"
const string SMS_WATCH = "watch"

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

struct TSMSSendParams {
    1: required Mobile mobile,
    2: required string template,
    3: optional string type,
    4: optional string channel,
    5: optional map<string, string> params,
}

struct TSMSSendText {
    1: required Mobile mobile,
    2: required string template,
    3: required i32 code,
    4: optional i32 success,
    5: optional string channel,
    6: optional i32 error_code,
}

service MessageService
{
    TSMSSendText send(1: TSMSSendParams params)
        throws (1: SMSUserException user_exception,
                2: SMSSystemException system_exception,
                3: SMSUnknownException unknown_exception),

    bool ping()
        throws (1: SMSUserException user_exception,
                2: SMSSystemException system_exception,
                3: SMSUnknownException unknown_exception),
}

