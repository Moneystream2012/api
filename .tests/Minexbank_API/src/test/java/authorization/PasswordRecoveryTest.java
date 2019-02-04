package authorization;

import common.AbstractTest;
import io.restassured.http.ContentType;
import io.restassured.response.Response;
import org.hamcrest.Matchers;
import org.junit.Test;
import utils.PropertyHelper;

import java.util.HashMap;
import java.util.Map;

import static common.Endpoints.PASSWORD_RECOVERY;
import static io.restassured.RestAssured.given;
import static io.restassured.RestAssured.when;

public class PasswordRecoveryTest extends AbstractTest {

    @Test
    public void passwordRecoveryShouldReturn200IfValidUser() {

        Map<String, String> requestBody = new HashMap<>();
        requestBody.put("address", VALID_USER_ADDRESS);
        requestBody.put("word", PropertyHelper.getProperty("word"));
        requestBody.put("sign", PropertyHelper.getProperty("sign"));
        requestBody.put("scenario", "checkAddress");

        Response response =
                given().body(requestBody).contentType(ContentType.JSON).
                        when().post(PASSWORD_RECOVERY);

        response.then().assertThat().statusCode(200);

        String resetToken = response.then().extract().body().jsonPath().get("resetToken");

        requestBody.clear();
        requestBody.put("address", VALID_USER_ADDRESS);
        requestBody.put("password", VALID_USER_PASSWORD);
        requestBody.put("passwordRepeat", VALID_USER_PASSWORD);
        requestBody.put("resetToken", resetToken);
        requestBody.put("scenario", "changePassword");

        given().body(requestBody).contentType(ContentType.JSON).
                when().post(PASSWORD_RECOVERY).
                then().assertThat().statusCode(200);
    }

    @Test
    public void passwordRecoveryShouldReturn422IfInvalidRequest() {
        when().post(PASSWORD_RECOVERY).then().assertThat().statusCode(422);
    }

    @Test
    public void passwordRecoveryShouldReturn422IfInvalidResetToken() {
        String expiredRecoveryToken = "eMdIS3xud_5LcwB-4f8o1tRYe-0GWao8";

        Map<String, String> requestBody = new HashMap<>();
        requestBody.put("address", VALID_USER_ADDRESS);
        requestBody.put("password", VALID_USER_PASSWORD);
        requestBody.put("passwordRepeat", VALID_USER_PASSWORD);
        requestBody.put("resetToken", expiredRecoveryToken);
        requestBody.put("scenario", "changePassword");

        given().body(requestBody).contentType(ContentType.JSON).
                when().post(PASSWORD_RECOVERY).
                then().log().ifValidationFails().assertThat().statusCode(422).
                and().assertThat().body("[0].message", Matchers.equalTo("Not valid data"));
    }
}
