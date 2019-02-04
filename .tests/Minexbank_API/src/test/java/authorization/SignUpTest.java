package authorization;

import common.AbstractTest;
import org.junit.Test;
import utils.PropertyHelper;

import java.util.HashMap;
import java.util.Map;

import static common.Endpoints.SIGN_UP;
import static io.restassured.RestAssured.given;

public class SignUpTest extends AbstractTest {

    @Test
    public void signUpEndpointShouldReturn422IfUserExists() {

        Map<String, String> requestBody = new HashMap<>();
        requestBody.put("address", VALID_USER_ADDRESS);
        requestBody.put("password", VALID_USER_PASSWORD);
        requestBody.put("repeatPassword", VALID_USER_PASSWORD);
        requestBody.put("word", PropertyHelper.getProperty("word"));
        requestBody.put("sign", PropertyHelper.getProperty("sign"));

        given().body(requestBody).when().post(SIGN_UP).then().assertThat().statusCode(422);
    }
}
