package authorization;

import common.AbstractTest;
import org.junit.Test;

import java.util.HashMap;
import java.util.Map;

import static common.Endpoints.CHANGE_PASSWORD;
import static io.restassured.RestAssured.given;
import static io.restassured.RestAssured.when;

public class PasswordChangeTest extends AbstractTest {

    @Test
    public void changePasswordShouldReturn200IfAuthorizedAndCorrectPassword() {

        Map<String, String> requestBody = new HashMap<>();
        requestBody.put("oldPassword", VALID_USER_PASSWORD);
        requestBody.put("password", VALID_USER_PASSWORD);
        requestBody.put("repeatPassword", VALID_USER_PASSWORD);

        given().spec(requestSpecification).body(requestBody).
                when().post(CHANGE_PASSWORD).
                then().assertThat().statusCode(200);
    }

    @Test
    public void changePasswordShouldReturn422IfAuthorizedAndIncorrectPassword() {

        Map<String, String> requestBody = new HashMap<>();
        requestBody.put("oldPassword", "invalid password");
        requestBody.put("password", VALID_USER_PASSWORD);
        requestBody.put("repeatPassword", VALID_USER_PASSWORD);

        given().spec(requestSpecification).body(requestBody).
                when().post(CHANGE_PASSWORD).
                then().assertThat().statusCode(422);
    }

    @Test
    public void changePasswordShouldReturn401InNotAuthorized() {
        when().post(CHANGE_PASSWORD).then().assertThat().statusCode(401);
    }

    @Test
    public void changePasswordShouldReturn405IfMethodIsGet() {
        when().get(CHANGE_PASSWORD).then().assertThat().statusCode(405);
    }
}
