package finance.parking;

import common.AbstractTest;
import io.restassured.http.ContentType;
import org.junit.Test;

import static common.Endpoints.*;
import static io.restassured.RestAssured.given;
import static io.restassured.RestAssured.when;

public class ParkingRequestsTest extends AbstractTest {

    @Test
    public void parkingShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().post(PARKING).then().assertThat().statusCode(422);
    }

    @Test
    public void parkingShoulReturn401IfNotAuthorized() {
        when().get(PARKING).then().assertThat().statusCode(401);
    }

    @Test
    public void parkingTypeShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_TYPE).then().assertThat().statusCode(200);
    }

    @Test
    public void parkingTypeShouldReturn200IfNotAuthorized() {
        when().get(PARKING_TYPE).then().assertThat().statusCode(200);
    }

    @Test
    public void parkingStatusShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_STATUS).then().assertThat().statusCode(200);
    }

    @Test
    public void parkingStatusShouldReturn401IfNotAuthorized() {
        when().get(PARKING_STATUS).then().assertThat().statusCode(401);
    }

    @Test
    public void activePendingShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_ACTIVE_PENDING).then().assertThat().statusCode(200);
    }

    @Test
    public void activePandingShouldReturn401IfUnauthorized() {
        when().get(PARKING_ACTIVE_PENDING).then().assertThat().statusCode(401);
    }

    @Test
    public void completedShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_COMPLETED).then().assertThat().statusCode(200);
    }

    @Test
    public void completedShouldReturn401IfNotAuthorized() {
        when().get(PARKING_COMPLETED).then().assertThat().statusCode(401);
    }

    @Test
    public void canceledShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_CANCELED).then().assertThat().statusCode(200);
    }

    @Test
    public void canceledShoulReturn401IfNotAuthorized() {
        when().get(PARKING_CANCELED).then().assertThat().statusCode(401);
    }

    @Test
    public void cancelShouldReturn400IfAuthorizedAndNoData() {
        given().spec(requestSpecification).when().post(PARKING_CANCEL).then().assertThat().statusCode(400);
    }

    @Test
    public void cancelShouldReturn404IfAuthorizedAndInvalidRequestData() {
        String requestBody = "{\"id\":\"invalidId\"}";
        given().spec(requestSpecification).
                when().body(requestBody).contentType(ContentType.JSON).post(PARKING_CANCEL).
                then().assertThat().statusCode(404);
    }

    @Test
    public void cancelShouldReturn401IfNotAuthorized() {
        when().post(PARKING_CANCEL).then().assertThat().statusCode(401);
    }

    @Test
    public void cancelShouldReturn405IfMethodIsGet() {
        when().get(PARKING_CANCEL).then().assertThat().statusCode(405);
    }

    @Test
    public void activateShouldReturn400IfAuthorizedAndNoData() {
        given().spec(requestSpecification).when().post(PARKING_ACTIVATE).then().assertThat().statusCode(400);
    }

    @Test
    public void activateShouldReturn404IfAuthorizedAndInvalidRequestData() {
        String requestBody = "{\"id\":\"invalidId\"}";
        given().spec(requestSpecification).
                when().body(requestBody).contentType(ContentType.JSON).post(PARKING_ACTIVATE).
                then().assertThat().statusCode(404);
    }

    @Test
    public void activateShouldReturn401IfNotAuthorized() {
        when().post(PARKING_ACTIVATE).then().assertThat().statusCode(401);
    }

    @Test
    public void activateShouldReturn405IfMethodIsGet() {
        when().get(PARKING_ACTIVATE).then().assertThat().statusCode(405);
    }

    @Test
    public void totalCountShouldReturn200IfAuthorized() {
        given().spec(requestSpecification).when().get(PARKING_TOTAL_COUNT).then().assertThat().statusCode(200);
    }

    @Test
    public void totalCountShouldReturn401IfNotAuthorized() {
        when().get(PARKING_TOTAL_COUNT).then().assertThat().statusCode(401);
    }
}
