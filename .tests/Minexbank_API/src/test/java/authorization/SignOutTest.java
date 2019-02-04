package authorization;

import common.AbstractTest;
import org.junit.Test;

import static common.Endpoints.SIGN_OUT;
import static io.restassured.RestAssured.given;
import static io.restassured.RestAssured.when;

public class SignOutTest extends AbstractTest {

    @Test
    public void authorizedUserIsAbleToSignOut() {
        given().spec(requestSpecification).when().post(SIGN_OUT).then().assertThat().statusCode(200);
    }

    @Test
    public void unauthorizedUserCannotSignOut() {
        when().post(SIGN_OUT).then().assertThat().statusCode(401);
    }
}
