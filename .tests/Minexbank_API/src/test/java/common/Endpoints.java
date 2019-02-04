package common;

import utils.PropertyHelper;

public interface Endpoints {
    String BANK_MAIN_API_URL = PropertyHelper.getProperty("bankMainApiUrl");
    String SIGN_UP = BANK_MAIN_API_URL + "/user/aaa/register";
    String SIGN_IN = BANK_MAIN_API_URL + "/user/aaa/sign-in";
    String SIGN_OUT = BANK_MAIN_API_URL + "/user/aaa/sign-out";
    String PASSWORD_RECOVERY = BANK_MAIN_API_URL + "/user/aaa/password-recovery";
    String CHANGE_PASSWORD = BANK_MAIN_API_URL + "/user/aaa/change-password";
    String PARKING = BANK_MAIN_API_URL + "/finance/parking";
    String PARKING_TYPE = BANK_MAIN_API_URL + "/finance/parking/type";
    String PARKING_STATUS = BANK_MAIN_API_URL + "/finance/parking/status/";
    String PARKING_ACTIVE_PENDING = BANK_MAIN_API_URL + "/finance/parking/status/active,pending";
    String PARKING_COMPLETED = BANK_MAIN_API_URL + "/finance/parking/status/completed";
    String PARKING_CANCELED = BANK_MAIN_API_URL + "/finance/parking/status/canceled";
    String PARKING_CANCEL = BANK_MAIN_API_URL + "/finance/parking/cancel";
    String PARKING_ACTIVATE = BANK_MAIN_API_URL + "/finance/parking/activate";
    String PARKING_TOTAL_COUNT = BANK_MAIN_API_URL + "/finance/parking/total-count";
    String TRANSACTION_COMPLETED = BANK_MAIN_API_URL + "/finance/transaction/status/completed";
    String USER_BALANCE = BANK_MAIN_API_URL + "/finance/balance/user";
    String USER_NOTIFICATIONS = BANK_MAIN_API_URL + "/notification/user";
    String SUPPORT_CREATE_CHAT = BANK_MAIN_API_URL + "/chat/create-chat";
    String SUPPORT_CHAT_HISTORY = BANK_MAIN_API_URL + "/chat/chat-history";
    String SUPPORT_CREATE_CHAT_MESSAGE = BANK_MAIN_API_URL + "/chat/create-message";
    String SUBSCRIBER = BANK_MAIN_API_URL + "/subscriber";
}
