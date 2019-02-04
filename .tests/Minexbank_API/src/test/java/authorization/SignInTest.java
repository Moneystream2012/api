package authorization;

import common.AbstractTest;
import org.junit.Test;

import java.util.HashMap;
import java.util.Map;

import static common.Endpoints.SIGN_IN;
import static io.restassured.RestAssured.given;
import static io.restassured.RestAssured.when;

public class SignInTest extends AbstractTest {

    @Test
    public void registeredUserIsAbleToSignIn() {
        Map<String, String> jsonRequestAsMap = new HashMap<>();
        jsonRequestAsMap.put("address", VALID_USER_ADDRESS);
        jsonRequestAsMap.put("password", VALID_USER_PASSWORD);

        given().spec(requestSpecification).body(jsonRequestAsMap).when().post(SIGN_IN).then().statusCode(200);
    }

    @Test
    public void invalidUserIsNotAbleToSignIn() {
        when().post(SIGN_IN).then().assertThat().statusCode(422);
    }
}