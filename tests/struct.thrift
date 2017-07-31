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