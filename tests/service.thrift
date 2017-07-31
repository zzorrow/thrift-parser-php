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
