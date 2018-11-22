package utility;

import org.json.JSONException;
import org.json.JSONObject;

import java.net.URL;

import utility.HTTPRequest;

public class GoogleBookAPI {
    private String queryTitle;
    private String API_KEY = "AIzaSyBZmgEtwukg-N_eCzML5wQiKHcOKEOEu1Q";

    public GoogleBookAPI(String queryTitle) {
        this.queryTitle = queryTitle;
    }

    public JSONObject searchBook() {
//        String cobaJSON = "{id: \"Habibi\", title: \"Habibi\", authors: [\"Habibi\", \"YUly\"], description: \"Habibi\", price: 10000}";
//        try {
//            JSONObject hasilJSON = new JSONObject(cobaJSON);
//            return hasilJSON;
//        } catch (JSONException err) {
//            System.out.println(err);
//        }

        try {
            HTTPRequest googleBookAPIRequest = new HTTPRequest(String.format("https://www.googleapis.com/books/v1/volumes?q=%s&key=%s", this.queryTitle, this.API_KEY));
            String resultRequest = googleBookAPIRequest.doRequest("GET");
            JSONObject hasilJSON = new JSONObject(resultRequest);
            return hasilJSON;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }
}
