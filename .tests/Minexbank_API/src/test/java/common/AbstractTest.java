package common;

import io.restassured.builder.RequestSpecBuilder;
import io.restassured.config.LogConfig;
import io.restassured.config.RestAssuredConfig;
import io.restassured.http.ContentType;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;
import org.junit.Before;
import utils.PropertyHelper;

import java.util.HashMap;
import java.util.Map;

import static common.Endpoints.SIGN_IN;
import static io.restassured.RestAssured.given;

public abstract class AbstractTest {

    protected final String VALID_USER_ADDRESS = PropertyHelper.getProperty("wallet");
    protected final String VALID_USER_PASSWORD = PropertyHelper.getProperty("password");
    protected static RequestSpecification requestSpecification;

    @Before
    public void setup() {

        Response signInResponse = signInWith(VALID_USER_ADDRESS, VALID_USER_PASSWORD);
        String accessToken = signInResponse.getHeader("Access-Token");
        String userId = signInResponse.getHeader("Userid");
        RestAssuredConfig REST_ASSURED_CONFIG =
                RestAssuredConfig.config().logConfig(LogConfig.logConfig()
                        .enableLoggingOfRequestAndResponseIfValidationFails()
                        .enablePrettyPrinting(true));

        requestSpecification = new RequestSpecBuilder()
                .setConfig(REST_ASSURED_CONFIG)
                .setContentType(ContentType.JSON)
                .setBaseUri(PropertyHelper.getProperty("bankMainApiUrl"))
                .addHeader("Access-Token", accessToken)
                .addHeader("Token-Type", PropertyHelper.getProperty("tokenType"))
                .addHeader("Userid", userId)
                .build();
    }

    private Response signInWith(String address, String password) {
        Map<String, String> jsonRequestAsMap = new HashMap<>();
        jsonRequestAsMap.put("address", address);
        jsonRequestAsMap.put("password", password);

        return given().config(RestAssuredConfig.config())
                .contentType(ContentType.JSON)
                .body(jsonRequestAsMap)
                .post(SIGN_IN);
    }
}
