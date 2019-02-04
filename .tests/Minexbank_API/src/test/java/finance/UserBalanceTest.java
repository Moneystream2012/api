package finance;

import common.AbstractTest;
import org.junit.Ignore;
import org.junit.Test;
import utils.PropertyHelper;

import static common.Endpoints.USER_BALANCE;
import static io.restassured.RestAssured.get;
import static io.restassured.RestAssured.given;
import static org.hamcrest.Matchers.equalTo;

public class UserBalanceTest extends AbstractTest {

    private final String EXPLORER_WALLET_BALANCE_ENDPOINT =
            PropertyHelper.getProperty("explorerMainApiUrl") + "/address/" + VALID_USER_ADDRESS + "/get-balance";

    @Ignore //while new explorer with api is unavailable
    @Test
    public void userBalanceIsEqualToExplorer() {
        String userBalanceInExplorer =
                get(EXPLORER_WALLET_BALANCE_ENDPOINT).body().jsonPath().getString("balance");

        given().spec(requestSpecification).
                when().get(USER_BALANCE).
                then().assertThat().statusCode(200).
                and().body("balance", equalTo(userBalanceInExplorer));
    }
}
